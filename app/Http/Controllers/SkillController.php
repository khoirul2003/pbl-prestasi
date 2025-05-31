<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\Category;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::with('category')->paginate(10);
        $categories = Category::all();
        return view('admin.skills.index', compact('skills', 'categories'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('admin.skills.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'skill_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,category_id',
        ]);

        Skill::create([
            'skill_name' => $request->skill_name,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('skills.index')->with('success', 'Skill created successfully.');
    }

    public function show($id)
    {
        $skill = Skill::with('category')->findOrFail($id);
        return view('admin.skills.show', compact('skill'));
    }

    public function edit($id)
    {
        $skill = Skill::findOrFail($id);
        $categories = Category::all();
        return view('admin.skills.edit', compact('skill', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'skill_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,category_id',
        ]);

        $skill = Skill::findOrFail($id);
        $skill->update([
            'skill_name' => $request->skill_name,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('skills.index')->with('success', 'Skill updated successfully.');
    }

    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);
        $skill->delete();

        return redirect()->route('skills.index')->with('success', 'Skill deleted successfully.');
    }
}
