<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Setelah login, arahkan pengguna ke dashboard sesuai role mereka
        return redirect()->route('dashboard.' . auth()->user()->role);
    }

    // Dashboard untuk mahasiswa
    public function mahasiswaDashboard()
    {
        return view('dashboard.mahasiswa');
    }

    // Dashboard untuk dosen
    public function dosenDashboard()
    {
        return view('dashboard.dosen');
    }

    // Dashboard untuk admin
    public function adminDashboard()
    {
        return view('dashboard.admin');
    }
}
