<?php

namespace App\Http\Controllers;

use App\Models\DetailStudent;
use App\Models\StudyProgram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DetailStudentController extends Controller
{
    public function index()
    {
        $students = User::with('detailStudent', 'role')
            ->where('role_id', 3)
            ->paginate(10);

        return view('users.student.index', compact('students'));
    }

    // Form tambah student baru
    public function create()
    {
        $studyPrograms = StudyProgram::all();
        return view('users.student.create', compact('studyPrograms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_username' => 'required|string|unique:users,user_username|max:255',
            'user_password' => 'required|string|min:6|confirmed',
            'study_program_id' => 'required|exists:study_programs,study_program_id',
            'detail_student_nim' => 'required|string|unique:detail_students,detail_student_nim',
            'detail_student_gender' => 'required|in:male,female',
            'detail_student_dob' => 'required|date',
            'detail_student_address' => 'required|string|max:255',
            'detail_student_phone_no' => 'required|string|max:255',
            'detail_student_email' => 'required|email|unique:detail_students,detail_student_email',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'role_id' => 3,
                'user_name' => $request->user_name,
                'user_username' => $request->user_username,
                'user_password' => Hash::make($request->user_password),
            ]);

            $dataDetail = $request->only([
                'study_program_id',
                'detail_student_nim',
                'detail_student_gender',
                'detail_student_dob',
                'detail_student_address',
                'detail_student_phone_no',
                'detail_student_email',
            ]);

            $dataDetail['user_id'] = $user->user_id;

            DetailStudent::create($dataDetail);

            DB::commit();

            return redirect()->route('students.index')->with('success', 'Student berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    // Form edit student + detail
    public function edit($id)
    {
        $user = User::with('detailStudent')->findOrFail($id);
        $studyPrograms = StudyProgram::all();
        return view('users.student.edit', compact('user', 'studyPrograms'));
    }

    public function update(Request $request, $id)
    {
        $user = User::with('detailStudent')->findOrFail($id);

        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_username' => "required|string|max:255|unique:users,user_username,{$id},user_id",
            'user_password' => 'nullable|string|min:6|confirmed',
            'study_program_id' => 'required|exists:study_programs,study_program_id',
            'detail_student_nim' => "required|string|unique:detail_students,detail_student_nim,{$user->detailStudent->detail_student_id},detail_student_id",
            'detail_student_gender' => 'required|in:male,female',
            'detail_student_dob' => 'required|date',
            'detail_student_address' => 'required|string|max:255',
            'detail_student_phone_no' => 'required|string|max:255',
            'detail_student_email' => "required|email|unique:detail_students,detail_student_email,{$user->detailStudent->detail_student_id},detail_student_id",
            'detail_student_photo' => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $user->user_name = $request->user_name;
            $user->user_username = $request->user_username;
            if ($request->filled('user_password')) {
                $user->user_password = Hash::make($request->user_password);
            }
            $user->save();

            $detail = $user->detailStudent;

            $detail->study_program_id = $request->study_program_id;
            $detail->detail_student_nim = $request->detail_student_nim;
            $detail->detail_student_gender = $request->detail_student_gender;
            $detail->detail_student_dob = $request->detail_student_dob;
            $detail->detail_student_address = $request->detail_student_address;
            $detail->detail_student_phone_no = $request->detail_student_phone_no;
            $detail->detail_student_email = $request->detail_student_email;

            if ($request->hasFile('detail_student_photo')) {
                $file = $request->file('detail_student_photo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('photos/students'), $filename);
                $detail->detail_student_photo = $filename;
            }

            $detail->save();

            DB::commit();

            return redirect()->route('students.index')->with('success', 'Student berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('students.index')->with('success', 'Student berhasil dihapus');
    }
}
