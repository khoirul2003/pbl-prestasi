<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SupervisorController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('departments', DepartmentController::class);
    Route::resource('categories', CategoryController::class);
});

Route::prefix('student')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('student.dashboard');
});

Route::prefix('supervisor')->group(function () {
    Route::get('/', [SupervisorController::class, 'index'])->name('supervisor.dashboard');
});
