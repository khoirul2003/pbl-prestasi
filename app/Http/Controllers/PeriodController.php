<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    public function index()
    {
        $periods = Period::with('academic_year')->get();
        return view('admin.periods.index', compact('periods'));
    }
}
