<?php

namespace App\Http\Controllers;

use App\Models\DetailStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        return view('student.dashboard');
    }

    public function profile()
    {
        $student = DetailStudent::with([
            'user',
            'academicYear',
            'studyProgram',
            'studentSkills.skill',
            'studentPeriods.period'
        ])->where('user_id', auth()->id())->firstOrFail();

        $averageIpk = null;
        $latestPeriod = null;
        $semesterCount = 0;

        if ($student->studentPeriods->isNotEmpty()) {
            $sortedPeriods = $student->studentPeriods->sortBy(function ($sp) {
                return $sp->period->start_date;
            })->values();

            $semesterCount = $sortedPeriods->count();
            $latestPeriod = $sortedPeriods->last()->period;

            $averageIpk = $student->studentPeriods->avg('ipk');
        }

        return view('student.profile.index', compact('student', 'averageIpk', 'latestPeriod', 'semesterCount'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|max:100',
            'detail_student_email' => 'required|email',
            'detail_student_gender' => 'required|in:Male,Female',
            'detail_student_dob' => 'required|date',
            'detail_student_phone_no' => 'required|string|max:20',
            'detail_student_address' => 'required|string|max:255',
            'detail_student_photo' => 'nullable|image|max:2048',
        ]);

        $student = DetailStudent::with('user')->where('user_id', auth()->id())->firstOrFail();

        $student->user->user_name = $request->user_name;
        $student->user->save();

        if ($request->hasFile('detail_student_photo')) {
            $photo = $request->file('detail_student_photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('photos/students'), $photoName);
            $student->detail_student_photo = $photoName;
        }

        $student->update([
            'detail_student_email' => $request->detail_student_email,
            'detail_student_gender' => $request->detail_student_gender,
            'detail_student_dob' => $request->detail_student_dob,
            'detail_student_phone_no' => $request->detail_student_phone_no,
            'detail_student_address' => $request->detail_student_address,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
