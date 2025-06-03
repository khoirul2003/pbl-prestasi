<?php

namespace App\Http\Controllers;

use App\Models\DetailSupervisor;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    public function index()
    {
        return view('supervisor.dashboard');
    }

    public function profile()
    {
        $supervisor = DetailSupervisor::with([
            'user',
            'department',
            'supervisorSkills.skill',
        ])->where('user_id', auth()->id())->firstOrFail();


        return view('supervisor.profile.index', compact('supervisor'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|max:100',
            'detail_supervisor_email' => 'required|email',
            'detail_supervisor_gender' => 'required|in:Male,Female',
            'detail_supervisor_dob' => 'required|date',
            'detail_supervisor_phone_no' => 'required|string|max:20',
            'detail_supervisor_address' => 'required|string|max:255',
            'detail_supervisor_photo' => 'nullable|image|max:2048',
        ]);

        $supervisor = DetailSupervisor::with('user')->where('user_id', auth()->id())->firstOrFail();

        $supervisor->user->user_name = $request->user_name;
        $supervisor->user->save();

        if ($request->hasFile('detail_supervisor_photo')) {
            $photo = $request->file('detail_supervisor_photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('photos/supervisors'), $photoName);
            $supervisor->detail_supervisor_photo = $photoName;
        }

        $supervisor->update([
            'detail_supervisor_email' => $request->detail_supervisor_email,
            'detail_supervisor_gender' => $request->detail_supervisor_gender,
            'detail_supervisor_dob' => $request->detail_supervisor_dob,
            'detail_supervisor_phone_no' => $request->detail_supervisor_phone_no,
            'detail_supervisor_address' => $request->detail_supervisor_address,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
