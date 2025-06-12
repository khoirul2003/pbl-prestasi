<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\DetailSupervisor;
use App\Models\RecommendationResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupervisorController extends Controller
{
    public function index()
    {
        $supervisor = DetailSupervisor::with('user')
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Fetch top student rankings based on achievements
        $studentRankings = User::join('achievements', 'users.user_id', '=', 'achievements.user_id')
            ->select('users.user_name', DB::raw('COUNT(achievements.achievement_id) as achievement_count'))
            ->groupBy('users.user_name')
            ->orderByDesc('achievement_count')
            ->limit(10)
            ->get();

        // Fetch competitions with open registration
        $openCompetitions = Competition::where('competition_registration_deadline', '>', now())
            ->orderBy('competition_registration_deadline', 'asc')
            ->get();

        // Count the number of students under this supervisor's mentorship using recommendation_results
        $studentsUnderSupervisionCount = RecommendationResult::where('detail_supervisor_id', $supervisor->detail_supervisor_id)
            ->distinct('user_id')  // Ensure we count each student only once
            ->count('user_id');

        // Count the number of competitions this supervisor is mentoring
        $competitionsUnderMentorshipCount = RecommendationResult::where('detail_supervisor_id', $supervisor->detail_supervisor_id)
            ->distinct('competition_id')  // Ensure we count each competition only once
            ->count('competition_id');

        return view('supervisor.dashboard', compact(
            'supervisor',
            'studentRankings',
            'openCompetitions',
            'studentsUnderSupervisionCount',
            'competitionsUnderMentorshipCount'
        ));
    }

    public function profile()
    {
        $supervisor = DetailSupervisor::with([
            'user',
            'department',
            'supervisorSkills.skill',
        ])->where('user_id', auth()->id())->firstOrFail();


        return view('supervisor.profile.index', compact('supervisor'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|max:100',
            'detail_supervisor_email' => 'required|email',
            'detail_supervisor_gender' => 'required|in:Male,Female',
            'detail_supervisor_dob' => 'required|date',
            'detail_supervisor_phone_no' => 'required|string|max:20',
            'detail_supervisor_address' => 'required|string|max:255',
            'detail_supervisor_photo' => 'nullable|image|max:2048',
        ]);

        $supervisor = DetailSupervisor::with('user')->where('user_id', auth()->id())->firstOrFail();

        $supervisor->user->user_name = $request->user_name;
        $supervisor->user->save();

        if ($request->hasFile('detail_supervisor_photo')) {
            $photo = $request->file('detail_supervisor_photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('photos/supervisors'), $photoName);
            $supervisor->detail_supervisor_photo = $photoName;
        }

        $supervisor->update([
            'detail_supervisor_email' => $request->detail_supervisor_email,
            'detail_supervisor_gender' => $request->detail_supervisor_gender,
            'detail_supervisor_dob' => $request->detail_supervisor_dob,
            'detail_supervisor_phone_no' => $request->detail_supervisor_phone_no,
            'detail_supervisor_address' => $request->detail_supervisor_address,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
