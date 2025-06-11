<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DetailStudent;
use App\Models\DetailSupervisor;
use App\Models\StudyProgram;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Default to 'student' if no role is provided
        $role = $request->get('role', 'student');

        // Fetch users based on the role (student or supervisor)
        if ($role == 'student') {
            $users = User::with('detailStudent', 'role')
                ->whereHas('role', function ($query) {
                    $query->where('role_name', 'student');
                })
                ->paginate(10);
        } else {
            $users = User::with('detailSupervisor', 'role')
                ->whereHas('role', function ($query) {
                    $query->where('role_name', 'supervisor');
                })
                ->paginate(10);
        }

        // Return the index view with the users and role
        return view('admin.users.index', compact('users', 'role'));
    }

    // Form to add a new user (either student or supervisor)
    public function create($role)
    {
        $viewData = [];

        if ($role == 'student') {  // Student
            $viewData['studyPrograms'] = StudyProgram::all();
            return view('users.student.create', $viewData);
        } else {  // Supervisor
            $viewData['departments'] = Department::all();
            return view('users.supervisor.create', $viewData);
        }
    }

    public function store(Request $request, $role)
    {
        // Get the role_id dynamically
        $roleModel = Role::where('role_name', $role)->first();

        if (!$roleModel) {
            return back()->withErrors(['error' => 'Role not found'])->withInput();
        }

        // Validation rules for both students and supervisors
        $validationRules = [
            'user_name' => 'required|string|max:255',
            'user_username' => 'required|string|unique:users,user_username|max:255',
            'user_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ],
        ];

        // Additional validation rules for students
        if ($role == 'student') {
            $validationRules = array_merge($validationRules, [
                'study_program_id' => 'required|exists:study_programs,study_program_id',
                'detail_student_nim' => 'required|string|unique:detail_students,detail_student_nim',
                'detail_student_gender' => 'required|in:male,female',
                'detail_student_dob' => 'required|date',
                'detail_student_address' => 'required|string|max:255',
                'detail_student_phone_no' => 'required|string|max:255',
                'detail_student_email' => 'required|email|unique:detail_students,detail_student_email',
                'detail_student_photo' => 'nullable|image|max:2048', // added validation for photo upload
            ]);
        } else {
            // Additional validation rules for supervisors
            $validationRules = array_merge($validationRules, [
                'department_id' => 'required|exists:departments,department_id',
                'detail_supervisor_nip' => 'required|string|unique:detail_supervisors,detail_supervisor_nip',
                'detail_supervisor_gender' => 'required|in:male,female',
                'detail_supervisor_dob' => 'required|date',
                'detail_supervisor_address' => 'required|string|max:255',
                'detail_supervisor_phone_no' => 'required|string|max:255',
                'detail_supervisor_email' => 'required|email|unique:detail_supervisors,detail_supervisor_email',
                'detail_supervisor_photo' => 'nullable|image|max:2048', // added validation for photo upload
            ]);
        }

        // Validate the incoming request
        $request->validate($validationRules);

        DB::beginTransaction();

        try {
            // Create the user with the role_id
            $user = User::create([
                'role_id' => $roleModel->role_id,  // Save the role_id
                'user_name' => $request->user_name,
                'user_username' => $request->user_username,
                'user_password' => Hash::make($request->user_password),
            ]);

            // Handle photo upload for student or supervisor
            if ($role == 'student' && $request->hasFile('detail_student_photo')) {
                $photo = $request->file('detail_student_photo');
                $filename = time() . '_' . $photo->getClientOriginalName();
                $photo->move(public_path('photos/students'), $filename);
                $photoPath = 'photos/students/' . $filename;
            } elseif ($role == 'supervisor' && $request->hasFile('detail_supervisor_photo')) {
                $photo = $request->file('detail_supervisor_photo');
                $filename = time() . '_' . $photo->getClientOriginalName();
                $photo->move(public_path('photos/supervisors'), $filename);
                $photoPath = 'photos/supervisors/' . $filename;
            }

            // Save details based on the role
            if ($role == 'student') {
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
                $dataDetail['detail_student_photo'] = $photoPath ?? null;

                DetailStudent::create($dataDetail);
            } else {
                $dataDetail = $request->only([
                    'department_id',
                    'detail_supervisor_nip',
                    'detail_supervisor_gender',
                    'detail_supervisor_dob',
                    'detail_supervisor_address',
                    'detail_supervisor_phone_no',
                    'detail_supervisor_email',
                ]);
                $dataDetail['user_id'] = $user->user_id;
                $dataDetail['detail_supervisor_photo'] = $photoPath ?? null;

                DetailSupervisor::create($dataDetail);
            }

            DB::commit();

            return redirect()->route('admin.users.index', ['role' => $role])
                ->with('success', ucfirst($role) . ' berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($roleName, $id)
    {
        $user = User::with(['detailStudent', 'detailSupervisor'])->findOrFail($id);
        $viewData = [
            'user' => $user
        ];

        if ($roleName == 'student') {
            $viewData['studyPrograms'] = StudyProgram::all();
            return view('users.student.edit', $viewData);
        } else {
            $viewData['departments'] = Department::all();
            return view('users.supervisor.edit', $viewData);
        }
    }

    public function update(Request $request, $roleName, $id)
    {
        // Ambil data user beserta detailnya
        $user = User::with(['detailStudent', 'detailSupervisor'])->findOrFail($id);

        // Validasi untuk semua pengguna
        $validationRules = [
            'user_name' => 'required|string|max:255',
            'user_username' => "required|string|max:255|unique:users,user_username,{$id},user_id",
            'user_password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ],
        ];

        // Validasi untuk Student
        if ($roleName == 'student') {
            $validationRules = array_merge($validationRules, [
                'study_program_id' => 'required|exists:study_programs,study_program_id',
                'detail_student_nim' => "required|string|unique:detail_students,detail_student_nim,{$user->detailStudent->detail_student_id},detail_student_id",
                'detail_student_gender' => 'required|in:male,female',
                'detail_student_dob' => 'required|date',
                'detail_student_address' => 'required|string|max:255',
                'detail_student_phone_no' => 'required|string|max:255',
                'detail_student_email' => "required|email|unique:detail_students,detail_student_email,{$user->detailStudent->detail_student_id},detail_student_id",
                'detail_student_photo' => 'nullable|image|max:2048',
            ]);
        } else {  // Supervisor
            $validationRules = array_merge($validationRules, [
                'department_id' => 'required|exists:departments,department_id',
                'detail_supervisor_nip' => "required|string|unique:detail_supervisors,detail_supervisor_nip,{$user->detailSupervisor->detail_supervisor_id},detail_supervisor_id",
                'detail_supervisor_gender' => 'required|in:male,female',
                'detail_supervisor_dob' => 'required|date',
                'detail_supervisor_address' => 'required|string|max:255',
                'detail_supervisor_phone_no' => 'required|string|max:255',
                'detail_supervisor_email' => "required|email|unique:detail_supervisors,detail_supervisor_email,{$user->detailSupervisor->detail_supervisor_id},detail_supervisor_id",
            ]);
        }

        // Validasi input
        $request->validate($validationRules);

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Update data user
            $user->user_name = $request->user_name;
            $user->user_username = $request->user_username;

            // Hanya update password jika diisi
            if ($request->filled('user_password')) {
                $user->user_password = Hash::make($request->user_password);
            }
            $user->save();

            // Update detail user berdasarkan role
            if ($roleName == 'student') {  // Jika Student
                $detail = $user->detailStudent ?? new DetailStudent();  // Jika tidak ada detailStudent, buat instance baru
                $detail->study_program_id = $request->study_program_id;
                $detail->detail_student_nim = $request->detail_student_nim;
                $detail->detail_student_gender = $request->detail_student_gender;
                $detail->detail_student_dob = $request->detail_student_dob;
                $detail->detail_student_address = $request->detail_student_address;
                $detail->detail_student_phone_no = $request->detail_student_phone_no;
                $detail->detail_student_email = $request->detail_student_email;

                // Jika ada foto, simpan foto baru
                if ($request->hasFile('detail_student_photo')) {
                    $file = $request->file('detail_student_photo');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('photos/students'), $filename);
                    $detail->detail_student_photo = $filename;
                }

                $detail->save();
            } else {  // Supervisor
                $detail = $user->detailSupervisor ?? new DetailSupervisor();  // Jika tidak ada detailSupervisor, buat instance baru
                $detail->department_id = $request->department_id;
                $detail->detail_supervisor_nip = $request->detail_supervisor_nip;
                $detail->detail_supervisor_gender = $request->detail_supervisor_gender;
                $detail->detail_supervisor_dob = $request->detail_supervisor_dob;
                $detail->detail_supervisor_address = $request->detail_supervisor_address;
                $detail->detail_supervisor_phone_no = $request->detail_supervisor_phone_no;
                $detail->detail_supervisor_email = $request->detail_supervisor_email;

                // Jika ada foto, simpan foto baru
                if ($request->hasFile('detail_supervisor_photo')) {
                    $file = $request->file('detail_supervisor_photo');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('photos/supervisors'), $filename);
                    $detail->detail_supervisor_photo = $filename;
                }

                $detail->save();
            }

            DB::commit();

            return redirect()->route($roleName == 'student' ? 'admin.students.index' : 'admin.supervisors.index')
                ->with('success', $roleName == 'student' ? 'Student berhasil diperbarui' : 'Supervisor berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($roleName, $id)
    {
        $user = User::findOrFail($id);

        DB::beginTransaction();

        try {
            if ($roleName == 'student') {
                if ($user->detailStudent) {
                    $user->detailStudent->delete();
                }
            } else if ($roleName == 'supervisor') {
                if ($user->detailSupervisor) {
                    $user->detailSupervisor->delete();
                }
            }

            $user->delete();

            DB::commit();

            return redirect()->route('admin.users.index', ['role' => $roleName])
                ->with('success', $roleName == 'student' ? 'Student berhasil dihapus' : 'Supervisor berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()])->withInput();
        }
    }
}

