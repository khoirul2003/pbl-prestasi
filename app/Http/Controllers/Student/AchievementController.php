<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Category; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AchievementController extends Controller
{
    public function index()
    {
        $achievements = Achievement::with('category')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();


        $categories = Category::all();

        return view('student.achievements.index', compact('achievements', 'categories'));
    }

    public function show($id)
    {
        $achievement = Achievement::with('category')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('student.achievements.show', compact('achievement'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'achievement_title' => 'required|string|max:255',
            'achievement_description' => 'nullable|string',
            'achievement_ranking' => 'nullable|string|max:100',
            'achievement_level' => 'nullable|string|max:100',
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
            'achievement_verified' => false,
        ]);

        return redirect()->back()->with('success', 'Achievement created successfully.');
    }


    public function update(Request $request, $id)
    {
        $achievement = Achievement::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'achievement_title' => 'required|string|max:255',
            'achievement_description' => 'nullable|string',
            'achievement_ranking' => 'nullable|string|max:100',
            'achievement_level' => 'nullable|string|max:100',
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
}
