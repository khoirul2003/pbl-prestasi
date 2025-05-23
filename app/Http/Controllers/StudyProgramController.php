<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\StudyProgram;
use Illuminate\Http\Request;

class StudyProgramController extends Controller
{
    public function index()
    {
        // Eager load department data
        $study_programs = StudyProgram::with('departments')->get();
        // Ambil semua department untuk dropdown form add/edit modal
        $departments = Department::all();

        return view('admin.study_programs.index', compact('study_programs', 'departments'));
    }   

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,department_id',
            'study_program_name' => 'required|string|max:255',
        ]);

        StudyProgram::create([
            'department_id' => $request->department_id,
            'study_program_name' => $request->study_program_name,
        ]);

        return redirect()->route('study_programs.index')->with('success', 'Study Program created successfully.');
    }

    public function show($id)
    {
        $study_program = StudyProgram::with('departments')->findOrFail($id);
        return response()->json($study_program);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,department_id',
            'study_program_name' => 'required|string|max:255',
        ]);

        $study_program = StudyProgram::findOrFail($id);
        $study_program->update([
            'department_id' => $request->department_id,
            'study_program_name' => $request->study_program_name,
        ]);

        return redirect()->route('study_programs.index')->with('success', 'Study Program updated successfully.');
    }

    public function destroy($id)
    {
        $study_program = StudyProgram::findOrFail($id);
        $study_program->delete();

        return redirect()->route('study_programs.index')->with('success', 'Study Program deleted successfully.');
    }
}
