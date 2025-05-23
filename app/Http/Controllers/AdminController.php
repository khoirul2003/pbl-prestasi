<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Category;
use App\Models\Competition;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $studentCount = User::where('role_id', 3)->count(); 
        $supervisorCount = User::where('role_id', 2)->count();
        $achievementCount = Achievement::count();
        $competitionCount = Competition::count();

        $achievementStats = DB::table('achievements')
            ->join('categories', 'achievements.category_id', '=', 'categories.category_id')
            ->select('categories.category_name', DB::raw('count(*) as total'))
            ->groupBy('categories.category_name')
            ->get();

        $trendYears = DB::table('achievements')
            ->select(DB::raw('DISTINCT YEAR(achievements.created_at) as year'))
            ->orderBy('year')
            ->pluck('year')
            ->toArray();

        $trendData = [];
        $categories = Category::all();
        foreach ($categories as $category) {
            $trendData[$category->category_name] = [];
            foreach ($trendYears as $year) {
                $count = Achievement::whereYear('created_at', $year)
                    ->where('category_id', $category->category_id)
                    ->count();
                $trendData[$category->category_name][] = $count;
            }
        }

        $verificationStatus = DB::table('achievements')
            ->select('achievement_verified', DB::raw('count(*) as total'))
            ->groupBy('achievement_verified')
            ->get();

        $studentDistribution = DB::table('detail_students')
            ->join('study_programs', 'detail_students.study_program_id', '=', 'study_programs.study_program_id')
            ->select('study_programs.study_program_name', DB::raw('count(*) as total'))
            ->groupBy('study_programs.study_program_name')
            ->get();

        $recentAchievements = DB::table('achievements')
            ->join('users', 'achievements.user_id', '=', 'users.user_id')
            ->join('categories', 'achievements.category_id', '=', 'categories.category_id')
            ->select('users.user_name as student_name', 'categories.category_name', 'achievements.achievement_title', 'achievements.created_at as achievement_year')
            ->orderBy('achievements.created_at', 'desc')
            ->limit(10)
            ->get();

        $upcomingCompetitions = Competition::where('competition_registration_deadline', '>', now())
            ->orderBy('competition_registration_deadline', 'asc')
            ->limit(5)
            ->get();

        $topStudents = DB::table('achievements')
            ->join('users', 'achievements.user_id', '=', 'users.user_id')
            ->select('users.user_name as student_name', DB::raw('count(*) as achievement_count'))
            ->groupBy('users.user_name')
            ->orderByDesc('achievement_count')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'studentCount',
            'supervisorCount',
            'achievementCount',
            'competitionCount',
            'achievementStats',
            'recentAchievements',
            'upcomingCompetitions',
            'topStudents',
            'trendYears',
            'trendData',
            'verificationStatus',
            'studentDistribution'
        ));
    }
}
