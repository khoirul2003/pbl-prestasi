<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $query = Achievement::with('user', 'category');

        if ($request->has('status')) {
            if ($request->status === 'pending') {
                $query->where('achievement_verified', 'pending');
            } elseif ($request->status === 'processed') {
                $query->whereIn('achievement_verified', ['approved', 'rejected']);
            }
        }

        $achievements = $query->paginate(10);

        return view('admin.achievements.index', compact('achievements'));
    }

    public function show($id)
    {
        $achievement = Achievement::with('user', 'category')->findOrFail($id);
        return view('admin.achievements.show', compact('achievement'));
    }

    public function approve($id)
    {
        $achievement = Achievement::findOrFail($id);

        if ($achievement->achievement_verified !== 'pending') {
            return redirect()->back()->with('error', 'This achievement has already been processed.');
        }

        $achievement->achievement_verified = 'approved';
        $achievement->save();

        return redirect()->route('achievements.index', ['status' => 'pending'])->with('success', 'Achievement approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_description' => 'required|string|max:1000',
        ]);

        $achievement = Achievement::findOrFail($id);

        if ($achievement->achievement_verified !== 'pending') {
            return redirect()->back()->with('error', 'This achievement has already been processed.');
        }

        $achievement->update([
            'achievement_verified' => 'rejected',
            'achievement_reject_description' => $request->rejection_description,
        ]);

        return redirect()->route('achievements.index', ['status' => 'pending'])
            ->with('success', 'Achievement rejected successfully.');
    }

    public function achievementReport()
    {
        $achievements = Achievement::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(10); 
        return view('admin.reports.achievement', compact('achievements'));
    }
}
