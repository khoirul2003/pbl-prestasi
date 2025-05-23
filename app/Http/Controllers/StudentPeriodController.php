<?php

namespace App\Http\Controllers;

use App\Models\DetailStudent;
use App\Models\Period;
use App\Models\StudentPeriod;
use Illuminate\Http\Request;

class StudentPeriodController extends Controller
{
    public function index(Request $request)
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

    // Tampilkan form tambah student period
    public function create()
    {
        $students = DetailStudent::with('user')->get();
        $periods = Period::all();

        return view('student_periods.create', compact('students', 'periods'));
    }

    // Simpan student period baru
    public function store(Request $request)
    {
        $request->validate([
            'detail_student_id' => 'required|exists:detail_students,detail_student_id',
            'period_id' => 'required|exists:periods,period_id',
            'ipk' => 'required|numeric|between:0,4',
        ]);

        StudentPeriod::create($request->only('detail_student_id', 'period_id', 'ipk'));

        return redirect()->route('student_periods.index')->with('success', 'Student period berhasil ditambahkan');
    }

    // Form edit student period
    public function edit($id)
    {
        $studentPeriod = StudentPeriod::findOrFail($id);
        $students = DetailStudent::with('user')->get();
        $periods = Period::all();

        return view('student_periods.edit', compact('studentPeriod', 'students', 'periods'));
    }

    // Update student period
    public function update(Request $request, $id)
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

    // Hapus student period
    public function destroy($id)
    {
        $studentPeriod = StudentPeriod::findOrFail($id);
        $studentPeriod->delete();

        return redirect()->route('student_periods.index')->with('success', 'Student period berhasil dihapus');
    }
}
