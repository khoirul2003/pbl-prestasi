<?php

namespace App\Http\Controllers;

use App\Models\StudyProgram;
use Illuminate\Http\Request;

class StudyProgramController extends Controller
{
    public function index()
    {
        $study_programs = StudyProgram::with('departments')->get();
        return view('admin.study_programs.index', compact('study_programs'));
    }
}
