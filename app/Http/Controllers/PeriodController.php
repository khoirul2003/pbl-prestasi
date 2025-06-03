<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class PeriodController extends Controller
{

    public function index(Request $request)
    {
        $periods = Period::with('academic_year')
            ->when($request->search, function ($query) use ($request) {
                $query->where('period_name', 'like', '%' . $request->search . '%')
                    ->orWhereHas('academic_year', function ($query) use ($request) {
                        $query->where('academic_year', 'like', '%' . $request->search . '%');
                    });
            })
            ->paginate(10);

        return view('admin.periods.index', compact('periods'));
    }

    public function create()
    {
        $academicYears = AcademicYear::all(); 
        return view('admin.periods.create', compact('academicYears'));
    }

    public function store(Request $request)
    {
        // Validate input data
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'period_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Create a new period
        Period::create([
            'academic_year_id' => $request->academic_year_id,
            'period_name' => $request->period_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('periods.index')->with('success', 'Period created successfully.');
    }


    public function edit(Period $period)
    {
        $academicYears = AcademicYear::all();
        return view('admin.periods.edit', compact('period', 'academicYears'));
    }

    public function update(Request $request, Period $period)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'period_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $period->update([
            'academic_year_id' => $request->academic_year_id,
            'period_name' => $request->period_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('periods.index')->with('success', 'Period updated successfully.');
    }

    public function destroy(Period $period)
    {
        // Delete the period
        $period->delete();
        return redirect()->route('periods.index')->with('success', 'Period deleted successfully.');
    }
}
