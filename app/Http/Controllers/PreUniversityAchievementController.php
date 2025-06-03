<?php

namespace App\Http\Controllers;

use App\Models\PreUniversityAchievement;
use Illuminate\Http\Request;

class PreUniversityAchievementController extends Controller
{
    public function index()
    {
        $preUniversityAchievements = PreUniversityAchievement::with('user', 'category')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.pre_university_achievements.index', compact('preUniversityAchievements'));
    }

    public function show($id)
    {
        $preUniversityAchievement = PreUniversityAchievement::with('user', 'category')->findOrFail($id);
        return view('admin.pre_university_achievements.show', compact('preUniversityAchievement'));
    }
}
