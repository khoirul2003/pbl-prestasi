<?php

namespace App\Http\Controllers;

use App\Exports\MooraExport;
use App\Exports\MooraSingleSheetExport;
use App\Models\Achievement;
use App\Models\PreUniversityAchievement;
use App\Models\StudentPeriod;
use App\Models\StudentSkill;
use App\Models\User;
use App\Models\Competition;
use App\Models\DetailSupervisor;
use App\Models\RecommendationResult;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
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

        $students = User::where('role_id', 3)
            ->whereHas('detailStudent')
            ->with('detailStudent')
            ->get();

        if ($students->isEmpty()) {
            return view('admin.recommendations.show', [
                'competition' => $competition,
                'results' => []
            ]);
        }

        $decisionMatrix = [];
        $levelMapping = [
            'regional' => 1,
            'nasional' => 2,
            'internasional' => 3
        ];

        foreach ($students as $student) {
            $detailStudent = $student->detailStudent;

            // Achievement calculations
            $jumlahPrestasi = Achievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)->count();

            // Ensure no 0 value for jumlahPrestasi (Benefit)
            $jumlahPrestasi = $jumlahPrestasi == 0 ? 1 : $jumlahPrestasi;
            $benefitPrestasi = $jumlahPrestasi * 2;  // Benefit calculation

            // Approved achievements count
            $jumlahPrestasiDisetujui = Achievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)
                ->where('achievement_verified', 'approved')->count();

            // Ensure no 0 value for jumlahPrestasiDisetujui (Benefit)
            $jumlahPrestasiDisetujui = $jumlahPrestasiDisetujui == 0 ? 1 : $jumlahPrestasiDisetujui;

            // Level calculation for achievements
            $maxLevelAchievement = Achievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)
                ->where('achievement_verified', 'approved')
                ->whereIn('achievement_level', array_keys($levelMapping))
                ->orderByRaw("CASE achievement_level
            WHEN 'internasional' THEN 3
            WHEN 'nasional' THEN 2
            WHEN 'regional' THEN 1
            ELSE 0 END DESC")
                ->first();

            $maxLevel = $maxLevelAchievement && $maxLevelAchievement->achievement_level
                ? $levelMapping[$maxLevelAchievement->achievement_level]
                : 0;

            // Ensure no 0 value for maxLevel (Benefit)
            $maxLevel = $maxLevel == 0 ? 1 : $maxLevel;

            // Ranking calculation
            $bestRankingQuery = Achievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)
                ->where('achievement_verified', 'approved')
                ->whereNotNull('achievement_ranking')
                ->where('achievement_ranking', '>', 0);

            $bestRanking = $bestRankingQuery->exists()
                ? $bestRankingQuery->min('achievement_ranking')
                : 0;

            $bestRanking = $bestRanking == 0 ? 8 : $bestRanking;

            $ipk = StudentPeriod::where('detail_student_id', $detailStudent->detail_student_id)
                ->orderByDesc('period_id')
                ->value('ipk') ?? 0;

            $ipk = $ipk == 0 ? 1 : $ipk;

            $skillSesuaiKategori = StudentSkill::where('detail_student_id', $detailStudent->detail_student_id)
                ->whereHas('skill', function ($query) use ($categoryId) {
                    $query->where('category_id', $categoryId);
                })->count();

            $skillSesuaiKategori = $skillSesuaiKategori == 0 ? 1 : $skillSesuaiKategori;

            $totalSkill = StudentSkill::where('detail_student_id', $detailStudent->detail_student_id)->count();

            $totalSkill = $totalSkill == 0 ? 1 : $totalSkill;

            $semester = StudentPeriod::where('detail_student_id', $detailStudent->detail_student_id)
                ->max('period_id') ?? 1;

            $semester = $semester == 0 ? 1 : $semester;

            $preUniJumlah = PreUniversityAchievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)->count();

            $preUniJumlah = $preUniJumlah == 0 ? 1 : $preUniJumlah;

            $preUniBestRankQuery = PreUniversityAchievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)
                ->whereNotNull('pre_university_achievement_ranking')
                ->where('pre_university_achievement_ranking', '>', 0);

            $preUniBestRank = $preUniBestRankQuery->exists()
                ? $preUniBestRankQuery->min('pre_university_achievement_ranking')
                : 0;

            $preUniBestRank = $preUniBestRank == 0 ? 8 : $preUniBestRank;

            $maxLevelPreUni = PreUniversityAchievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)
                ->whereIn('pre_university_achievement_level', array_keys($levelMapping))
                ->orderByRaw("CASE pre_university_achievement_level
            WHEN 'internasional' THEN 3
            WHEN 'nasional' THEN 2
            WHEN 'regional' THEN 1
            ELSE 0 END DESC")
                ->first();

            $preUniMaxLevel = $maxLevelPreUni && $maxLevelPreUni->pre_university_achievement_level
                ? $levelMapping[$maxLevelPreUni->pre_university_achievement_level]
                : 0;

            // Ensure no 0 value for preUniMaxLevel (Benefit)
            $preUniMaxLevel = $preUniMaxLevel == 0 ? 1 : $preUniMaxLevel;

            // Add all data to decision matrix
            $decisionMatrix[] = [
                'student' => $student,
                'Name' => $student->user_name,
                'Total Achievements' => $benefitPrestasi,  // Updated to benefit
                'Approved Achievements' => $jumlahPrestasiDisetujui,
                'Level of Achievements' => $maxLevel,
                'Best Ranking' => $bestRanking,  // Updated to cost with +2 rule if no ranking
                'GPA' => (float) $ipk,
                'Category Skills' => $skillSesuaiKategori,
                'Total Skills' => $totalSkill,
                'Semester' => $semester,
                'Pre-University Achievements' => $preUniJumlah,
                'Pre-University Best Rank' => $preUniBestRank,
                'Pre-University Level' => $preUniMaxLevel,
            ];
        }

        $weights = [
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

        $maxValues = [];
        $minValues = [];

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
                $max = $maxValues[$key];
                $min = $minValues[$key];
                $range = $max - $min;

                if ($range == 0) {
                    $normalized[$key] = 0.5;
                } else {
                    if (in_array($key, ['Best Ranking', 'Semester', 'Pre-University Best Rank'])) {
                        $normalized[$key] = ($max - $val) / $range;
                    } else {
                        $normalized[$key] = ($val - $min) / $range;
                    }
                }
            }

            $normalizedMatrix[] = [
                'student' => $row['student'],
                'normalized' => $normalized,
                'raw_data' => $row,
            ];
        }

        $results = [];

        foreach ($normalizedMatrix as $row) {
            $totalScore = 0;

            foreach ($weights as $key => $weight) {
                $normalizedValue = $row['normalized'][$key];
                $totalScore += $normalizedValue * $weight;
            }

            $results[] = [
                'student' => $row['student'],
                'score' => round($totalScore, 4),
                'raw_data' => $row['raw_data'],
                'normalized_data' => $row['normalized'],
            ];
        }

        usort($results, fn($a, $b) => $b['score'] <=> $a['score']);

        $topResults = array_slice($results, 0, 5);

        foreach ($topResults as $result) {
            $student = $result['student'];

            $matchingSupervisors = DetailSupervisor::whereHas('supervisorSkills.skill', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })->get();

            $selectedSupervisor = $matchingSupervisors->isNotEmpty()
                ? $matchingSupervisors->random()
                : null;

            RecommendationResult::updateOrCreate(
                [
                    'competition_id' => $competition->competition_id,
                    'user_id' => $student->user_id
                ],
                [
                    'recommendation_result_score' => $result['score'],
                    'detail_supervisor_id' => $selectedSupervisor?->detail_supervisor_id,
                ]
            );
        }

        $perPage = 10;
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $perPage;
        $pagedResults = array_slice($results, $offset, $perPage);

        $paginator = new LengthAwarePaginator(
            $pagedResults,
            count($results),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.recommendations.show', compact('competition'))->with('results', $paginator);
    }

    private function calculateMoora($competition)
    {
        $categoryId = $competition->category_id;

        $students = User::where('role_id', 3)
            ->whereHas('detailStudent')
            ->with('detailStudent')
            ->get();

        if ($students->isEmpty()) {
            return [
                'decisionMatrix' => [],
                'normalizedMatrix' => [],
                'results' => [],
            ];
        }

        $decisionMatrix = [];
        $levelMapping = ['regional' => 1, 'nasional' => 2, 'internasional' => 3];

        foreach ($students as $student) {
            $detailStudent = $student->detailStudent;

            $jumlahPrestasi = Achievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)->count();
            $jumlahPrestasi = $jumlahPrestasi == 0 ? 1 : $jumlahPrestasi;
            $benefitPrestasi = $jumlahPrestasi * 2;

            $jumlahPrestasiDisetujui = Achievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)
                ->where('achievement_verified', 'approved')->count();
            $jumlahPrestasiDisetujui = $jumlahPrestasiDisetujui == 0 ? 1 : $jumlahPrestasiDisetujui;

            $maxLevelAchievement = Achievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)
                ->where('achievement_verified', 'approved')
                ->whereIn('achievement_level', array_keys($levelMapping))
                ->orderByRaw("CASE achievement_level
                WHEN 'internasional' THEN 3
                WHEN 'nasional' THEN 2
                WHEN 'regional' THEN 1
                ELSE 0 END DESC")->first();
            $maxLevel = $maxLevelAchievement && $maxLevelAchievement->achievement_level
                ? $levelMapping[$maxLevelAchievement->achievement_level]
                : 1;

            $bestRankingQuery = Achievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)
                ->where('achievement_verified', 'approved')
                ->whereNotNull('achievement_ranking')
                ->where('achievement_ranking', '>', 0);
            $bestRanking = $bestRankingQuery->exists()
                ? $bestRankingQuery->min('achievement_ranking')
                : 8;

            $ipk = StudentPeriod::where('detail_student_id', $detailStudent->detail_student_id)
                ->orderByDesc('period_id')->value('ipk') ?? 1;

            $skillSesuaiKategori = StudentSkill::where('detail_student_id', $detailStudent->detail_student_id)
                ->whereHas('skill', function ($query) use ($categoryId) {
                    $query->where('category_id', $categoryId);
                })->count();
            $skillSesuaiKategori = $skillSesuaiKategori == 0 ? 1 : $skillSesuaiKategori;

            $totalSkill = StudentSkill::where('detail_student_id', $detailStudent->detail_student_id)->count();
            $totalSkill = $totalSkill == 0 ? 1 : $totalSkill;

            $semester = StudentPeriod::where('detail_student_id', $detailStudent->detail_student_id)
                ->max('period_id') ?? 1;
            $semester = $semester == 0 ? 1 : $semester;

            $preUniJumlah = PreUniversityAchievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)->count();
            $preUniJumlah = $preUniJumlah == 0 ? 1 : $preUniJumlah;

            $preUniBestRankQuery = PreUniversityAchievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)
                ->whereNotNull('pre_university_achievement_ranking')
                ->where('pre_university_achievement_ranking', '>', 0);
            $preUniBestRank = $preUniBestRankQuery->exists()
                ? $preUniBestRankQuery->min('pre_university_achievement_ranking')
                : 8;

            $maxLevelPreUni = PreUniversityAchievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)
                ->whereIn('pre_university_achievement_level', array_keys($levelMapping))
                ->orderByRaw("CASE pre_university_achievement_level
                WHEN 'internasional' THEN 3
                WHEN 'nasional' THEN 2
                WHEN 'regional' THEN 1
                ELSE 0 END DESC")->first();
            $preUniMaxLevel = $maxLevelPreUni && $maxLevelPreUni->pre_university_achievement_level
                ? $levelMapping[$maxLevelPreUni->pre_university_achievement_level]
                : 1;

            $decisionMatrix[] = [
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

        $weights = [
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
                $max = $maxValues[$key];
                $min = $minValues[$key];
                $range = $max - $min;

                if ($range == 0) {
                    $normalized[$key] = 0.5;
                } else {
                    if (in_array($key, ['Best Ranking', 'Semester', 'Pre-University Best Rank'])) {
                        $normalized[$key] = ($max - $val) / $range;
                    } else {
                        $normalized[$key] = ($val - $min) / $range;
                    }
                }
            }

            $normalizedMatrix[] = [
                'student' => $row['student'],
                'normalized' => $normalized,
                'raw_data' => $row,
            ];
        }

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

        usort($results, fn($a, $b) => $b['score'] <=> $a['score']);

        return [
            'decisionMatrix' => $decisionMatrix,
            'normalizedMatrix' => $normalizedMatrix,
            'results' => $results,
        ];
    }

    public function exportToExcel($competitionId)
    {
        $competition = Competition::findOrFail($competitionId);


        $resultsData = $this->calculateMoora($competition);

        return Excel::download(
            new MooraExport(
                $competition,
                $resultsData['decisionMatrix'],
                $resultsData['normalizedMatrix'],
                $resultsData['results']
            ),
            'moora_step_by_step.xlsx'
        );
    }
}
