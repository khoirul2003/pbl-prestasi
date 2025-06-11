<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Category;
use App\Models\PreUniversityAchievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab');
        $categories = Category::all();

        if ($tab === 'pre') {
            $achievements = PreUniversityAchievement::with('category')
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $achievements = Achievement::with('category')
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('student.achievements.index', compact('achievements', 'categories', 'tab'));
    }

    public function show($id)
    {
        $achievement = Achievement::with('category')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('student.achievements.partials.show', compact('achievement'));
    }

    public function showPre($id)
    {
        $achievement = PreUniversityAchievement::with('category')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('student.achievements.partials.show_pre', compact('achievement'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'achievement_title' => 'required|string|max:255',
            'achievement_description' => 'nullable|string',
            'achievement_ranking' => 'nullable|string|max:100',
            'achievement_level' => 'required|in:regional,nasional,internasional',
            'achievement_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $fileName = null;
        if ($request->hasFile('achievement_document')) {
            $file = $request->file('achievement_document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('documents/achievements'), $fileName);
        }

        Achievement::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'achievement_title' => $request->achievement_title,
            'achievement_description' => $request->achievement_description,
            'achievement_ranking' => $request->achievement_ranking,
            'achievement_level' => $request->achievement_level,
            'achievement_document' => $fileName,
            'achievement_verified' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Achievement created successfully.');
    }

    public function storePre(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'pre_university_achievement_title' => 'required|string|max:255',
            'pre_university_achievement_description' => 'nullable|string',
            'pre_university_achievement_ranking' => 'nullable|string|max:100',
            'pre_university_achievement_level' => 'required|in:regional,nasional,internasional',
            'pre_university_achievement_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $fileName = null;
        if ($request->hasFile('pre_university_achievement_document')) {
            $file = $request->file('pre_university_achievement_document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('documents/pre_achievements'), $fileName);
        }

        PreUniversityAchievement::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'pre_university_achievement_title' => $request->pre_university_achievement_title,
            'pre_university_achievement_description' => $request->pre_university_achievement_description,
            'pre_university_achievement_ranking' => $request->pre_university_achievement_ranking,
            'pre_university_achievement_level' => $request->pre_university_achievement_level,
            'pre_university_achievement_document' => $fileName,
        ]);

        return redirect()->back()->with('success', 'Pre-University Achievement created successfully.');
    }

    public function update(Request $request, $id)
    {
        $achievement = Achievement::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'achievement_title' => 'required|string|max:255',
            'achievement_description' => 'nullable|string',
            'achievement_ranking' => 'nullable|string|max:100',
            'achievement_level' => 'required|in:regional,nasional,internasional',
            'achievement_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $fileName = $achievement->achievement_document;
        if ($request->hasFile('achievement_document')) {
            if ($fileName && file_exists(public_path('documents/achievements/' . $fileName))) {
                unlink(public_path('documents/achievements/' . $fileName));
            }
            $file = $request->file('achievement_document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('documents/achievements'), $fileName);
        }

        $achievement->update([
            'category_id' => $request->category_id,
            'achievement_title' => $request->achievement_title,
            'achievement_description' => $request->achievement_description,
            'achievement_ranking' => $request->achievement_ranking,
            'achievement_level' => $request->achievement_level,
            'achievement_document' => $fileName,
        ]);

        return redirect()->back()->with('success', 'Achievement updated successfully.');
    }

    public function updatePre(Request $request, $id)
    {
        $achievement = PreUniversityAchievement::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'pre_university_achievement_title' => 'required|string|max:255',
            'pre_university_achievement_description' => 'nullable|string',
            'pre_university_achievement_ranking' => 'nullable|string|max:100',
            'pre_university_achievement_level' => 'required|in:regional,nasional,internasional',
            'pre_university_achievement_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $fileName = $achievement->pre_university_achievement_document;
        if ($request->hasFile('pre_university_achievement_document')) {
            if ($fileName && file_exists(public_path('documents/pre_achievements/' . $fileName))) {
                unlink(public_path('documents/pre_achievements/' . $fileName));
            }

            $file = $request->file('pre_university_achievement_document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('documents/pre_achievements'), $fileName);
        }

        $achievement->update([
            'category_id' => $request->category_id,
            'pre_university_achievement_title' => $request->pre_university_achievement_title,
            'pre_university_achievement_description' => $request->pre_university_achievement_description,
            'pre_university_achievement_ranking' => $request->pre_university_achievement_ranking,
            'pre_university_achievement_level' => $request->pre_university_achievement_level,
            'pre_university_achievement_document' => $fileName,
        ]);

        return redirect()->back()->with('success', 'Pre-University Achievement updated successfully.');
    }

    public function destroy($id)
    {
        $achievement = Achievement::where('user_id', Auth::id())->findOrFail($id);
        if ($achievement->achievement_document) {
            $filePath = public_path('documents/achievements/' . $achievement->achievement_document);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $achievement->delete();
        return redirect()->back()->with('success', 'Achievement deleted successfully.');
    }

    public function destroyPre($id)
    {
        $achievement = PreUniversityAchievement::where('user_id', Auth::id())->findOrFail($id);
        if ($achievement->pre_university_achievement_document) {
            $filePath = public_path('documents/pre_achievements/' . $achievement->pre_university_achievement_document);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $achievement->delete();
        return redirect()->back()->with('success', 'Pre-University Achievement deleted successfully.');
    }
}
