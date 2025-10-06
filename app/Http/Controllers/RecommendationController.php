<?php

namespace App\Http\Controllers;

use App\Exports\MooraExport;
use App\Models\Achievement;
use App\Models\PreUniversityAchievement;
use App\Models\StudentPeriod;
use App\Models\StudentSkill;
use App\Models\User;
use App\Models\Competition;
use App\Models\DetailSupervisor;
use App\Models\RecommendationResult;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class RecommendationController extends Controller
{
    public function index()
    {
        $competitions = Competition::where('competition_registration_deadline', '>=', now())
            ->get();

        return view('admin.recommendations.index', compact('competitions'));
    }

    public function showRecommendations($competitionId)
    {
        $competition = Competition::findOrFail($competitionId);
        $categoryId = $competition->category_id;

        $resultsData = $this->calculateMoora($competition);
        $results = $resultsData['results'];

        $topResults = array_slice($results, 0, 5);

        foreach ($topResults as $result) {
            $student = $result['student'];

            $matchingSupervisors = DetailSupervisor::whereHas('supervisorSkills.skill', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })->get();

            $selectedSupervisor = $matchingSupervisors->isNotEmpty()
                ? $matchingSupervisors->random()
                : null;

            $recommendationResult = RecommendationResult::firstOrNew([
                'competition_id' => $competition->competition_id,
                'user_id' => $student->user_id,
                'detail_student_id' => $student->detailStudent->detail_student_id,
            ]);

            $isNew = !$recommendationResult->exists;

            $recommendationResult->recommendation_result_score = $result['score'];
            $recommendationResult->detail_supervisor_id = $selectedSupervisor?->detail_supervisor_id;

            if ($isNew) {
                $recommendationResult->email_sent = false;
            }

            $recommendationResult->save();

            if (!$recommendationResult->email_sent) {
                $this->sendEmailToStudent($recommendationResult);
                $recommendationResult->email_sent = true;
                $recommendationResult->save();
            }
        }

        $perPage = 10;
        $page = request()->get('page', 1);
        $pagedResults = array_slice($results, ($page - 1) * $perPage, $perPage);

        $paginator = new LengthAwarePaginator($pagedResults, count($results), $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query()
        ]);

        return view('admin.recommendations.show', compact('competition'))->with('results', $paginator);
    }

    private function calculateMoora($competition)
    {
        $categoryId = $competition->category_id;
        $students = $this->getEligibleStudents();

        if ($students->isEmpty()) {
            return [
                'decisionMatrix' => [],
                'normalizedMatrix' => [],
                'results' => [],
            ];
        }

        $decisionMatrix = $this->buildDecisionMatrix($students, $categoryId);
        $normalizedMatrix = $this->normalizeMatrix($decisionMatrix);
        $results = $this->calculateOptimizationScores($normalizedMatrix);

        return [
            'decisionMatrix' => $decisionMatrix,
            'normalizedMatrix' => $normalizedMatrix,
            'results' => $this->rankAlternatives($results),
        ];
    }

    public function exportToExcel($competitionId)
    {
        $competition = Competition::findOrFail($competitionId);
        $resultsData = $this->calculateMoora($competition);
        $weights = $this->getMooraWeights();

        return Excel::download(
            new MooraExport(
                $competition,
                $resultsData['decisionMatrix'],
                $resultsData['normalizedMatrix'],
                $resultsData['results'],
                $weights
            ),
            'moora_step_by_step.xlsx'
        );
    }

    public function exportPdf($competitionId)
    {
        $competition = Competition::findOrFail($competitionId);
        $resultsData = $this->calculateMoora($competition);

        $exporter = new MooraExport(
            $competition,
            $resultsData['decisionMatrix'],
            $resultsData['normalizedMatrix'],
            $resultsData['results']
        );

        return $exporter->downloadPdf();
    }

    public function sendEmailToStudent($recommendationResult)
    {
        $student = $recommendationResult->user;
        $competition = $recommendationResult->competition;

        if ($student->detailStudent) {
            Mail::send('emails.recommendation', [
                'student' => $student,
                'competition' => $competition,
                'recommendationResult' => $recommendationResult,
            ], function ($message) use ($student, $competition) {
                $message->to($student->detailStudent->detail_student_email)
                    ->subject('Rekomendasi untuk Kompetisi ' . $competition->competition_tittle);
            });
        } else {
            Log::error('DetailStudent not found for user: ' . $student->user_name);
        }
    }

    // Tambahan opsional: simpan hasil MOORA ke file log untuk pelacakan
    public function logMooraResults($results, $filename = 'moora_log.json')
    {
        $logData = json_encode($results, JSON_PRETTY_PRINT);
        Storage::disk('local')->put($filename, $logData);
    }

    // Tambahan opsional: tampilkan chart visualisasi (via view)
    public function viewMooraChart($competitionId)
    {
        $competition = Competition::findOrFail($competitionId);
        $resultsData = $this->calculateMoora($competition);
        $results = $resultsData['results'];

        return view('admin.recommendations.chart', compact('competition', 'results'));
    }

    private function getEligibleStudents()
    {
        return User::where('role_id', 3)
            ->whereHas('detailStudent')
            ->with('detailStudent')
            ->get();
    }

    private function buildDecisionMatrix($students, $categoryId)
    {
        $matrix = [];
        $levelMapping = ['regional' => 1, 'nasional' => 2, 'internasional' => 3];

        foreach ($students as $student) {
            $detail = $student->detailStudent;

            $jumlahPrestasi = max(1, Achievement::where('user_id', $student->user_id)->where('category_id', $categoryId)->count());
            $benefitPrestasi = $jumlahPrestasi * 2;

            $jumlahPrestasiDisetujui = max(1, Achievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)
                ->where('achievement_verified', 'approved')->count());

            $maxLevel = optional(Achievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)
                ->where('achievement_verified', 'approved')
                ->whereIn('achievement_level', array_keys($levelMapping))
                ->orderByRaw("CASE achievement_level WHEN 'internasional' THEN 3 WHEN 'nasional' THEN 2 WHEN 'regional' THEN 1 ELSE 0 END DESC")
                ->first())->achievement_level;
            $maxLevel = $levelMapping[$maxLevel] ?? 1;

            $bestRanking = Achievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)
                ->where('achievement_verified', 'approved')
                ->whereNotNull('achievement_ranking')
                ->where('achievement_ranking', '>', 0)->min('achievement_ranking') ?? 8;

            $ipk = StudentPeriod::where('detail_student_id', $detail->detail_student_id)->orderByDesc('period_id')->value('ipk') ?? 1;

            $skillSesuaiKategori = max(1, StudentSkill::where('detail_student_id', $detail->detail_student_id)
                ->whereHas('skill', fn($q) => $q->where('category_id', $categoryId))->count());

            $totalSkill = max(1, StudentSkill::where('detail_student_id', $detail->detail_student_id)->count());
            $semester = max(1, StudentPeriod::where('detail_student_id', $detail->detail_student_id)->max('period_id') ?? 1);

            $preUniJumlah = max(1, PreUniversityAchievement::where('user_id', $student->user_id)->where('category_id', $categoryId)->count());
            $preUniBestRank = PreUniversityAchievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)
                ->whereNotNull('pre_university_achievement_ranking')
                ->where('pre_university_achievement_ranking', '>', 0)->min('pre_university_achievement_ranking') ?? 8;

            $preUniMaxLevel = optional(PreUniversityAchievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)
                ->whereIn('pre_university_achievement_level', array_keys($levelMapping))
                ->orderByRaw("CASE pre_university_achievement_level WHEN 'internasional' THEN 3 WHEN 'nasional' THEN 2 WHEN 'regional' THEN 1 ELSE 0 END DESC")
                ->first())->pre_university_achievement_level;
            $preUniMaxLevel = $levelMapping[$preUniMaxLevel] ?? 1;

            $matrix[] = [
                'student' => $student,
                'Name' => $student->user_name,
                'Total Achievements' => $benefitPrestasi,
                'Approved Achievements' => $jumlahPrestasiDisetujui,
                'Level of Achievements' => $maxLevel,
                'Best Ranking' => $bestRanking,
                'GPA' => (float) $ipk,
                'Category Skills' => $skillSesuaiKategori,
                'Total Skills' => $totalSkill,
                'Semester' => $semester,
                'Pre-University Achievements' => $preUniJumlah,
                'Pre-University Best Rank' => $preUniBestRank,
                'Pre-University Level' => $preUniMaxLevel,
            ];
        }

        return $matrix;
    }

    private function normalizeMatrix($decisionMatrix)
    {
        $weights = $this->getMooraWeights();
        $maxValues = $minValues = [];

        foreach (array_keys($weights) as $key) {
            $values = array_column($decisionMatrix, $key);
            $maxValues[$key] = max($values);
            $minValues[$key] = min($values);
        }

        $normalizedMatrix = [];

        foreach ($decisionMatrix as $row) {
            $normalized = [];
            foreach ($weights as $key => $weight) {
                $val = $row[$key];
                $range = $maxValues[$key] - $minValues[$key];
                $normalized[$key] = $range == 0 ? 0.5 : (in_array($key, ['Best Ranking', 'Semester', 'Pre-University Best Rank']) ? ($maxValues[$key] - $val) / $range : ($val - $minValues[$key]) / $range);
            }

            $normalizedMatrix[] = [
                'student' => $row['student'],
                'normalized' => $normalized,
                'raw_data' => $row,
            ];
        }

        return $normalizedMatrix;
    }

    private function calculateOptimizationScores($normalizedMatrix)
    {
        $weights = $this->getMooraWeights();
        $results = [];

        foreach ($normalizedMatrix as $row) {
            $totalScore = 0;
            foreach ($weights as $key => $weight) {
                $totalScore += $row['normalized'][$key] * $weight;
            }
            $results[] = [
                'student' => $row['student'],
                'score' => round($totalScore, 4),
                'raw_data' => $row['raw_data'],
                'normalized_data' => $row['normalized'],
            ];
        }

        return $results;
    }

    private function rankAlternatives($results)
    {
        usort($results, fn($a, $b) => $b['score'] <=> $a['score']);
        return $results;
    }

    public function getMooraWeights()
    {
        return [
            'Total Achievements' => 0.1,
            'Approved Achievements' => 0.15,
            'Level of Achievements' => 0.15,
            'Best Ranking' => 0.15,
            'GPA' => 0.1,
            'Category Skills' => 0.18,
            'Total Skills' => 0.05,
            'Semester' => 0.03,
            'Pre-University Achievements' => 0.03,
            'Pre-University Best Rank' => 0.03,
            'Pre-University Level' => 0.03,
        ];
    }

    public function showStudentRecommendations()
    {
        $userId = Auth::id();

        $recommendations = RecommendationResult::with('competition', 'supervisor')
            ->where('user_id', $userId)
            ->orderByDesc('recommendation_result_score')
            ->get();

        return view('student.recommendations.index', compact('recommendations'));
    }
}
