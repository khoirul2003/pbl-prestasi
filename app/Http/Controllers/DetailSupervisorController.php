<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DetailSupervisor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DetailSupervisorController extends Controller
{
    public function index()
    {
        $supervisors = User::with('detailSupervisor', 'role')
            ->where('role_id', 2)
            ->paginate(10);

        return view('admin.users.supervisor.index', compact('supervisors'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('users.supervisor.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
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
            'department_id' => 'required|exists:departments,department_id',
            'detail_supervisor_nip' => 'required|string|unique:detail_supervisors,detail_supervisor_nip',
            'detail_supervisor_gender' => 'required|in:male,female',
            'detail_supervisor_dob' => 'required|date',
            'detail_supervisor_address' => 'required|string|max:255',
            'detail_supervisor_phone_no' => 'required|string|max:255',
            'detail_supervisor_email' => 'required|email|unique:detail_supervisors,detail_supervisor_email',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'role_id' => 2,
                'user_name' => $request->user_name,
                'user_username' => $request->user_username,
                'user_password' => Hash::make($request->user_password),
            ]);

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

            DetailSupervisor::create($dataDetail);

            DB::commit();

            return redirect()->route('supervisors.index')->with('success', 'Supervisor berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $user = User::with('detailSupervisor')->findOrFail($id);
        $departments = Department::all();
        return view('users.supervisor.edit', compact('user', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $user = User::with('detailSupervisor')->findOrFail($id);

        $request->validate([
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

            'department_id' => 'required|exists:departments,department_id',
            'detail_supervisor_nip' => "required|string|unique:detail_supervisors,detail_supervisor_nip,{$user->detailSupervisor->detail_supervisor_id},detail_supervisor_id",
            'detail_supervisor_gender' => 'required|in:male,female',
            'detail_supervisor_dob' => 'required|date',
            'detail_supervisor_address' => 'required|string|max:255',
            'detail_supervisor_phone_no' => 'required|string|max:255',
            'detail_supervisor_email' => "required|email|unique:detail_supervisors,detail_supervisor_email,{$user->detailSupervisor->detail_supervisor_id},detail_supervisor_id",
            'detail_supervisor_photo' => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $user->user_name = $request->user_name;
            $user->user_username = $request->user_username;
            if ($request->filled('user_password')) {
                $user->user_password = Hash::make($request->user_password);
            }
            $user->save();

            $detail = $user->detailSupervisor;

            $detail->department_id = $request->department_id;
            $detail->detail_supervisor_nip = $request->detail_supervisor_nip;
            $detail->detail_supervisor_gender = $request->detail_supervisor_gender;
            $detail->detail_supervisor_dob = $request->detail_supervisor_dob;
            $detail->detail_supervisor_address = $request->detail_supervisor_address;
            $detail->detail_supervisor_phone_no = $request->detail_supervisor_phone_no;
            $detail->detail_supervisor_email = $request->detail_supervisor_email;

            if ($request->hasFile('detail_supervisor_photo')) {
                $file = $request->file('detail_supervisor_photo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('photos/supervisors'), $filename);
                $detail->detail_supervisor_photo = $filename;
            }

            $detail->save();

            DB::commit();

            return redirect()->route('supervisors.index')->with('success', 'Supervisor berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('supervisors.index')->with('success', 'Supervisor berhasil dihapus');
    }
}
