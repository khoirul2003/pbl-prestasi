<?php

namespace App\Http\Controllers;

use App\Models\RecommendationResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentRecommendationController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $recommendations = RecommendationResult::with('competition')
            ->where('user_id', $userId)
            ->orderByDesc('recommendation_result_score')
            ->get();

        return view('student.recommendations.index', compact('recommendations'));
    }
}
