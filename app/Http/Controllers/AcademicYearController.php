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

    public function create()
    {
        return view('admin.academic_years.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'academic_year' => 'required|string|max:255|unique:academic_years,academic_year',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $academicYear = new AcademicYear([
            'academic_year' => $request->academic_year,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        $academicYear->save();

        return redirect()->route('admin.academic_years.index')
            ->with('success', 'Academic year created successfully.');
    }

    public function edit($id)
    {
        $academicYear = AcademicYear::findOrFail($id);
        return view('admin.academic_years.edit', compact('academicYear'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'academic_year' => 'required|string|max:255|unique:academic_years,academic_year,' . $id . ',academic_year_id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $academicYear = AcademicYear::findOrFail($id);
        $academicYear->update([
            'academic_year' => $request->academic_year,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('admin.academic_years.index')
            ->with('success', 'Academic year updated successfully.');
    }

    public function destroy($id)
    {
        $academicYear = AcademicYear::findOrFail($id);
        $academicYear->delete();

        return redirect()->route('admin.academic_years.index')
            ->with('success', 'Academic year deleted successfully.');
    }
}
