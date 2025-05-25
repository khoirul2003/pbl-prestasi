<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::all();
        return view('admin.skills.index', compact('skills'));
    }

    public function create()
    {
        return view('admin.skills.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'skill_name' => 'required|string|max:255',
        ]);

        Skill::create([
            'skill_name' => $request->skill_name,
        ]);

        return redirect()->route('skills.index')->with('success', 'Skill created successfully.');
    }

    public function show($id)
    {
        $skill = Skill::findOrFail($id);
        return view('admin.skills.show', compact('skill'));
    }

    public function edit($id)
    {
        $skill = Skill::findOrFail($id);
        return view('admin.skills.edit', compact('skill'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'skill_name' => 'required|string|max:255',
        ]);

        $skill = Skill::findOrFail($id);
        $skill->update([
            'skill_name' => $request->skill_name,
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
