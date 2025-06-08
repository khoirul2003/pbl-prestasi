<?php

namespace App\Http\Controllers;

use App\Models\DetailStudent;
use App\Models\DetailSupervisor;
use App\Models\RecommendationResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupervisorRecommendationController extends Controller
{
    public function index()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the user is a supervisor by accessing the related DetailSupervisor
        if ($user->detailSupervisor) {
            $supervisorId = $user->detailSupervisor->detail_supervisor_id;

            // Fetch recommendation results for the supervisor
            $recommendations = RecommendationResult::with(['competition', 'detailStudent'])
                ->where('detail_supervisor_id', $supervisorId)
                ->get();

            // Pass recommendations and supervisor details to the view
            return view('supervisor.recommendations.index', compact('recommendations', 'user'));
        }

        // If the user is not a supervisor, show an error message within the same view
        $errorMessage = "You do not have the necessary permissions to view this page.";

        // Pass the error message to the view
        return view('supervisor.recommendations.index', compact('errorMessage', 'user'));
    }
}
