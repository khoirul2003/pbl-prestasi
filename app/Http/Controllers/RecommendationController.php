<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\PreUniversityAchievement;
use App\Models\StudentPeriod;
use App\Models\StudentSkill;
use App\Models\User;
use App\Models\Competition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        foreach ($students as $student) {
            $detailStudent = $student->detailStudent;

            $jumlahPrestasi = Achievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)
                ->count();

            $jumlahPrestasiDisetujui = Achievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)
                ->where('achievement_verified', 'approved')
                ->count();

            $levelMapping = [
                'regional' => 1,
                'nasional' => 2,
                'internasional' => 3
            ];

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

            $maxLevel = $maxLevelAchievement ? $levelMapping[$maxLevelAchievement->achievement_level] : 0;

            $bestRanking = Achievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)
                ->where('achievement_verified', 'approved')
                ->whereNotNull('achievement_ranking')
                ->where('achievement_ranking', '>', 0)
                ->min('achievement_ranking') ?? 6;

            $ipk = StudentPeriod::where('detail_student_id', $detailStudent->detail_student_id)
                ->orderByDesc('period_id')
                ->value('ipk') ?? 0;

            $skillSesuaiKategori = StudentSkill::where('detail_student_id', $detailStudent->detail_student_id)
                ->whereHas('skill', function ($query) use ($categoryId) {
                    $query->where('category_id', $categoryId);
                })
                ->count();

            $totalSkill = StudentSkill::where('detail_student_id', $detailStudent->detail_student_id)
                ->count();

            $latestPeriodId = StudentPeriod::where('detail_student_id', $detailStudent->detail_student_id)
                ->max('period_id') ?? 1;

            $preUniJumlah = PreUniversityAchievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)
                ->count();

            $preUniBestRank = PreUniversityAchievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)
                ->whereNotNull('pre_university_achievement_ranking')
                ->where('pre_university_achievement_ranking', '>', 0)
                ->min('pre_university_achievement_ranking') ?? 6;

            $maxLevelPreUni = PreUniversityAchievement::where('user_id', $student->user_id)
                ->where('category_id', $categoryId)
                ->whereIn('pre_university_achievement_level', array_keys($levelMapping))
                ->orderByRaw("CASE pre_university_achievement_level
                    WHEN 'internasional' THEN 3
                    WHEN 'nasional' THEN 2
                    WHEN 'regional' THEN 1
                    ELSE 0 END DESC")
                ->first();

            $preUniMaxLevel = $maxLevelPreUni ? $levelMapping[$maxLevelPreUni->pre_university_achievement_level] : 0;

            $decisionMatrix[] = [
                'student' => $student,
                'jumlah_prestasi' => $jumlahPrestasi,
                'jumlah_prestasi_disetujui' => $jumlahPrestasiDisetujui,
                'level_kompetisi' => $maxLevel,
                'peringkat_kompetisi' => $bestRanking,
                'ipk' => (float) $ipk,
                'skill_sesuai_kategori' => $skillSesuaiKategori,
                'total_skill' => $totalSkill,
                'semester' => $latestPeriodId,
                'pre_uni_jumlah' => $preUniJumlah,
                'pre_uni_peringkat' => $preUniBestRank,
                'pre_uni_level' => $preUniMaxLevel,
            ];
        }

        if (empty($decisionMatrix)) {
            return view('admin.recommendations.show', [
                'competition' => $competition,
                'results' => []
            ]);
        }

        $weights = [
            'jumlah_prestasi' => 0.1,
            'jumlah_prestasi_disetujui' => 0.15,
            'level_kompetisi' => 0.15,
            'peringkat_kompetisi' => 0.15,
            'ipk' => 0.1,
            'skill_sesuai_kategori' => 0.18,
            'total_skill' => 0.05,
            'semester' => 0.03,
            'pre_uni_jumlah' => 0.03,
            'pre_uni_peringkat' => 0.03,
            'pre_uni_level' => 0.03,
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
                    if (in_array($key, ['peringkat_kompetisi', 'semester', 'pre_uni_peringkat'])) {
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

        usort($results, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        $topResults = array_slice($results, 0, 5);

        foreach ($topResults as $result) {
            DB::table('recommendation_results')->updateOrInsert(
                [
                    'competition_id' => $competition->competition_id,
                    'user_id' => $result['student']->user_id
                ],
                [
                    'recommendation_result_score' => $result['score'],
                    'updated_at' => now(),
                    'created_at' => now()
                ]
            );
        }


        return view('admin.recommendations.show', compact('competition', 'results'));
    }
}
