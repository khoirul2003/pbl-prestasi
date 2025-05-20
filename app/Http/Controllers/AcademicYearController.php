<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{

    public function index()
    {
        $academic_years = AcademicYear::all();
        return view('admin.academic_years.index', compact('academic_years'));
    }
}
