<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DetailStudentController;
use App\Http\Controllers\DetailSupervisorController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentPeriodController;
use App\Http\Controllers\StudyProgramController;
use App\Http\Controllers\SupervisorController;
use App\Models\Period;
use App\Models\StudentPeriod;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('departments', DepartmentController::class);
    Route::resource('study_programs', StudyProgramController::class);
    Route::resource('academic_years', AcademicYearController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('periods', PeriodController::class);
    Route::resource('student_periods', StudentPeriodController::class);
    Route::resource('supervisors', DetailSupervisorController::class);
    Route::resource('students', DetailStudentController::class);
    Route::resource('competitions', CompetitionController::class);
    Route::resource('skills', SkillController::class);

    Route::get('achievements', [AchievementController::class, 'index'])->name('achievements.index');
    Route::get('achievements/{id}', [AchievementController::class, 'show'])->name('achievements.show');

    Route::post('achievements/{id}/approve', [AchievementController::class, 'approve'])->name('achievements.approve');
    Route::post('achievements/{id}/reject', [AchievementController::class, 'reject'])->name('achievements.reject');
});

Route::prefix('student')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('student.dashboard');
});

Route::prefix('supervisor')->group(function () {
    Route::get('/', [SupervisorController::class, 'index'])->name('supervisor.dashboard');
});
