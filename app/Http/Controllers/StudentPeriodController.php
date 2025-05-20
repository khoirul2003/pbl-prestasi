<?php

namespace App\Http\Controllers;

use App\Models\StudentPeriod;
use Illuminate\Http\Request;

class StudentPeriodController extends Controller
{
    public function index()
    {
        $student_periods = StudentPeriod::with(['period', 'detail_student'])->get();
        return view('admin.student_periods.index', compact('student_periods'));
    }
}
