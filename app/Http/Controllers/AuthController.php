<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordEmail;
use App\Mail\VerifyEmail;
use App\Models\Department;
use App\Models\DetailStudent;
use App\Models\DetailSupervisor;
use App\Models\StudyProgram;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

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
                'admin' => redirect()->route('admin.dashboard'),
                'supervisor' => redirect()->route('supervisor.dashboard'),
                'student' => redirect()->route('student.dashboard'),
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
            'role_id' => 3, // student
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

        return redirect()->route('login')->with('success', 'Registration successful. You can now login.');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function verifyEmail($userId)
    {
        $user = User::findOrFail($userId);

        if (!request()->hasValidSignature()) {
            abort(401);
        }

        $user->email_verified_at = Carbon::now();
        $user->save();

        return redirect()->route('login')->with('success', 'Email successfully verified.');
    }

    public function showForgotPasswordForm(){
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = DetailStudent::where('detail_student_email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['Email not found.'],
            ]);
        }

        $token = Str::random(60);

        DB::table('password_reset_tokens')->insert([
            'email' => $user->detail_student_email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        $resetUrl = route('password.reset', ['token' => $token, 'email' => $user->detail_student_email]);

        Mail::to($user->detail_student_email)->send(new ResetPasswordEmail($resetUrl));

        return back()->with('status', 'We have emailed your password reset link!');
    }

    public function showResetPasswordForm($token, $email)
    {
        return view('auth.reset-password', compact('token', 'email'));
    }

    public function resetPassword(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        // dd($resetRecord);

        if (!$resetRecord) {
            throw ValidationException::withMessages([
                'email' => ['This password reset link is invalid or expired.'],
            ]);
        }

        // $detailStudent = DetailStudent::with('user')->where('detail_student_email', $request->email)->first();
        // $detailStudent = DetailStudent::with('user')->where('detail_student_email', $request->email)->first();
        // dd($detailStudent);

        $user = DetailStudent::where('detail_student_email', $request->email)->first()->user;
        // dd($user);

        $user->user_password = Hash::make($request->password);

        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Your password has been reset!');
    }
}
