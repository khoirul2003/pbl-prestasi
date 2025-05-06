<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');

// Proses login
Route::post('login', [AuthController::class, 'login']);

// Menampilkan form register
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');

// Proses register
Route::post('register', [AuthController::class, 'register']);

// Rute untuk dashboard berdasarkan role
Route::get('dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Dashboard khusus untuk mahasiswa
Route::middleware('auth', 'role:mahasiswa')->group(function () {
    Route::get('dashboard/mahasiswa', [DashboardController::class, 'mahasiswaDashboard'])->name('dashboard.mahasiswa');
});

// Dashboard khusus untuk dosen
Route::middleware('auth', 'role:dosen')->group(function () {
    Route::get('dashboard/dosen', [DashboardController::class, 'dosenDashboard'])->name('dashboard.dosen');
});

// Dashboard khusus untuk admin
Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('dashboard/admin', [DashboardController::class, 'adminDashboard'])->name('dashboard.admin');
});

// Logout
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('admin/users', [AdminController::class, 'index'])->name('admin.users');  // Daftar pengguna
    Route::get('admin/users/{user}', [AdminController::class, 'show'])->name('admin.users.show');  // Daftar pengguna
    Route::get('admin/users/create', [AdminController::class, 'create'])->name('admin.users.create');  // Form tambah pengguna
    Route::post('admin/users', [AdminController::class, 'store'])->name('admin.users.store');  // Proses tambah pengguna
    Route::get('admin/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');  // Form edit pengguna
    Route::put('admin/users/{user}', [AdminController::class, 'update'])->name('admin.users.update');  // Proses edit pengguna
    Route::delete('admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');  // Hapus pengguna
});

// Fitur admin - Manajemen Lomba
Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('admin/competitions', [AdminController::class, 'competitions'])->name('admin.competitions');  // Daftar lomba
    Route::get('admin/competitions/create', [AdminController::class, 'createCompetition'])->name('admin.competitions.create');  // Form tambah lomba
    Route::post('admin/competitions', [AdminController::class, 'storeCompetition'])->name('admin.competitions.store');  // Proses tambah lomba
    Route::get('admin/competitions/{competition}/edit', [AdminController::class, 'editCompetition'])->name('admin.competitions.edit');  // Form edit lomba
    Route::put('admin/competitions/{competition}', [AdminController::class, 'updateCompetition'])->name('admin.competitions.update');  // Proses edit lomba
    Route::delete('admin/competitions/{competition}', [AdminController::class, 'destroyCompetition'])->name('admin.competitions.destroy');  // Hapus lomba
});

// Fitur admin - Laporan Prestasi Mahasiswa
Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('admin/reports', [AdminController::class, 'reports'])->name('admin.reports');  // Laporan prestasi
});
