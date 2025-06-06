<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\DetailStudent;
use App\Models\Period;
use App\Models\StudentPeriod;
use Illuminate\Http\Request;

class AcademicController extends Controller
{
    public function index()
    {
        $academic_years = AcademicYear::paginate(10);
        $student_periods = StudentPeriod::with(['detailStudent.user', 'period'])->paginate(10);
        $periods = Period::with('academic_year')->paginate(10);

        return view('admin.academics.index', compact('academic_years', 'student_periods', 'periods'));
    }

    public function indexAcademicYear()
    {
        $academic_years = AcademicYear::all();
        return view('admin.academic_years.index', compact('academic_years'));
    }

    public function createAcademicYear()
    {
        return view('admin.academic_years.create');
    }

    public function storeAcademicYear(Request $request)
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

    public function editAcademicYear($id)
    {
        $academicYear = AcademicYear::findOrFail($id);
        return view('admin.academic_years.edit', compact('academicYear'));
    }

    public function updateAcademicYear(Request $request, $id)
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

    public function destroyAcademicYear($id)
    {
        $academicYear = AcademicYear::findOrFail($id);
        $academicYear->delete();

        return redirect()->route('admin.academic_years.index')
            ->with('success', 'Academic year deleted successfully.');
    }


    public function indexStudentPeriod(Request $request)
    {
        $query = StudentPeriod::with(['detailStudent.user', 'period']);

        if ($search = $request->input('search')) {
            $query->whereHas('detailStudent.user', function ($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                    ->orWhere('user_username', 'like', "%{$search}%");
            });
        }

        $studentPeriods = $query->paginate(10);

        return view('admin.student_periods.index', compact('studentPeriods'));
    }

    public function createStudentPeriod()
    {
        $students = DetailStudent::with('user')->get();
        $periods = Period::all();

        return view('student_periods.create', compact('students', 'periods'));
    }

    public function storeStudentPeriod(Request $request)
    {
        $request->validate([
            'detail_student_id' => 'required|exists:detail_students,detail_student_id',
            'period_id' => 'required|exists:periods,period_id',
            'ipk' => 'required|numeric|between:0,4',
        ]);

        StudentPeriod::create($request->only('detail_student_id', 'period_id', 'ipk'));

        return redirect()->route('student_periods.index')->with('success', 'Student period berhasil ditambahkan');
    }

    public function editStudentPeriod($id)
    {
        $studentPeriod = StudentPeriod::findOrFail($id);
        $students = DetailStudent::with('user')->get();
        $periods = Period::all();

        return view('student_periods.edit', compact('studentPeriod', 'students', 'periods'));
    }

    public function updateStudentPeriod(Request $request, $id)
    {
        $studentPeriod = StudentPeriod::findOrFail($id);

        $request->validate([
            'detail_student_id' => 'required|exists:detail_students,detail_student_id',
            'period_id' => 'required|exists:periods,period_id',
            'ipk' => 'required|numeric|between:0,4',
        ]);

        $studentPeriod->update($request->only('detail_student_id', 'period_id', 'ipk'));

        return redirect()->route('student_periods.index')->with('success', 'Student period berhasil diperbarui');
    }

    public function destroyStudentPeriod($id)
    {
        $studentPeriod = StudentPeriod::findOrFail($id);
        $studentPeriod->delete();

        return redirect()->route('student_periods.index')->with('success', 'Student period berhasil dihapus');
    }


    public function indexPeriod(Request $request)
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

    public function createPeriod()
    {
        $academicYears = AcademicYear::all();
        return view('admin.periods.create', compact('academicYears'));
    }

    public function storePeriod(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'period_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        Period::create([
            'academic_year_id' => $request->academic_year_id,
            'period_name' => $request->period_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('periods.index')->with('success', 'Period created successfully.');
    }

    public function editPeriod(Period $period)
    {
        $academicYears = AcademicYear::all();
        return view('admin.periods.edit', compact('period', 'academicYears'));
    }

    public function updatePeriod(Request $request, Period $period)
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

    public function destroyPeriod(Period $period)
    {
        $period->delete();
        return redirect()->route('periods.index')->with('success', 'Period deleted successfully.');
    }
}
