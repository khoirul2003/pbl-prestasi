<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DetailStudent;
use App\Models\DetailSupervisor;
use App\Models\StudyProgram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginId = $request->login_id;
        $password = $request->password;

        $user = User::where('user_username', $loginId)->first();

        if (!$user) {
            $detailSupervisor = DetailSupervisor::where('detail_supervisor_nip', $loginId)->first();
            $user = $detailSupervisor ? $detailSupervisor->user : null;
        }

        if (!$user) {
            $detailStudent = DetailStudent::where('detail_student_nim', $loginId)->first();
            $user = $detailStudent ? $detailStudent->user : null;
        }

        if (!$user || !Hash::check($password, $user->user_password)) {
            throw ValidationException::withMessages([
                'login_id' => ['Login credentials are incorrect.'],
            ]);
        }

        Auth::login($user);

        return match ($user->role->role_name) {
            'Admin' => redirect()->route('admin.dashboard'),
            'Supervisor' => redirect()->route('supervisor.dashboard'),
            'Student' => redirect()->route('student.dashboard'),
            default => abort(403),
        };
    }

    public function showRegisterForm()
    {
        $studyPrograms = StudyProgram::all();
        return view('auth.register', compact('studyPrograms'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'role' => 'required|in:student',
            'user_name' => 'required|string|max:255',
            'user_username' => 'required|string|max:255|unique:users,user_username',
            'user_password' => 'required|string|min:8|confirmed',

            'study_program_id' => 'required|exists:study_programs,study_program_id',

            'detail_student_nim' => 'required|unique:detail_students,detail_student_nim',
            'detail_student_gender' => 'required|in:male,female',
            'detail_student_dob' => 'required|date',
            'detail_student_address' => 'required|string|max:255',
            'detail_student_phone_no' => 'required|string|max:255',
            'detail_student_email' => 'required|email',
        ]);

        $user = User::create([
            'role_id' => 3,  // student role_id tetap 3
            'user_name' => $request->user_name,
            'user_username' => $request->user_username,
            'user_password' => Hash::make($request->user_password),
        ]);

        DetailStudent::create([
            'user_id' => $user->user_id,
            'study_program_id' => $request->study_program_id,
            'detail_student_nim' => $request->detail_student_nim,
            'detail_student_gender' => $request->detail_student_gender,
            'detail_student_dob' => $request->detail_student_dob,
            'detail_student_address' => $request->detail_student_address,
            'detail_student_phone_no' => $request->detail_student_phone_no,
            'detail_student_email' => $request->detail_student_email,
            'detail_student_photo' => null,
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
