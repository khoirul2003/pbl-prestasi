<?php

use App\Http\Controllers\AcademicController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AchievementController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DetailStudentController;
use App\Http\Controllers\DetailSupervisorController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\PreUniversityAchievementController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\Student\AchievementController as StudentAchievementController;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentPeriodController;
use App\Http\Controllers\StudentRecommendationController;
use App\Http\Controllers\StudyProgramController;

use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/test', 'test')->name('test');



Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.post');

Route::post('logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('departments', DepartmentController::class);
    Route::resource('study_programs', StudyProgramController::class);

    Route::resource('categories', CategoryController::class);

    Route::resource('skills', SkillController::class);

    Route::get('academics', [AcademicController::class, 'index'])->name('admin.academics.index');

    // === Academic Year Routes ===
    Route::get('academic_years', [AcademicController::class, 'indexAcademicYear'])->name('admin.academic_years.index');
    Route::get('academic_years/create', [AcademicController::class, 'createAcademicYear'])->name('admin.academic_years.create');
    Route::post('academic_years', [AcademicController::class, 'storeAcademicYear'])->name('admin.academic_years.store');
    Route::get('academic_years/{id}/edit', [AcademicController::class, 'editAcademicYear'])->name('admin.academic_years.edit');
    Route::put('academic_years/{id}', [AcademicController::class, 'updateAcademicYear'])->name('admin.academic_years.update');
    Route::delete('academic_years/{id}', [AcademicController::class, 'destroyAcademicYear'])->name('admin.academic_years.destroy');

    // === Student Period Routes ===
    Route::get('student_periods', [AcademicController::class, 'indexStudentPeriod'])->name('admin.student_periods.index');
    Route::get('student_periods/create', [AcademicController::class, 'createStudentPeriod'])->name('admin.student_periods.create');
    Route::post('student_periods', [AcademicController::class, 'storeStudentPeriod'])->name('admin.student_periods.store');
    Route::get('student_periods/{id}/edit', [AcademicController::class, 'editStudentPeriod'])->name('admin.student_periods.edit');
    Route::put('student_periods/{id}', [AcademicController::class, 'updateStudentPeriod'])->name('admin.student_periods.update');
    Route::delete('student_periods/{id}', [AcademicController::class, 'destroyStudentPeriod'])->name('admin.student_periods.destroy');

    // === Period Routes ===
    Route::get('periods', [AcademicController::class, 'indexPeriod'])->name('admin.periods.index');
    Route::get('periods/create', [AcademicController::class, 'createPeriod'])->name('admin.periods.create');
    Route::post('periods', [AcademicController::class, 'storePeriod'])->name('admin.periods.store');
    Route::get('periods/{period}/edit', [AcademicController::class, 'editPeriod'])->name('admin.periods.edit');
    Route::put('periods/{period}', [AcademicController::class, 'updatePeriod'])->name('admin.periods.update');
    Route::delete('periods/{period}', [AcademicController::class, 'destroyPeriod'])->name('admin.periods.destroy');

    Route::get('users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('users/create/{role}', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('users/{role}', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('users/{role}/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('users/{role}/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('users/{role}/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // Admin Competition Management
    Route::get('competitions', [CompetitionController::class, 'adminIndex'])->name('admin.competitions.index');
    Route::get('competitions/create', [CompetitionController::class, 'adminCreate'])->name('admin.competitions.create');
    Route::post('competitions', [CompetitionController::class, 'adminStore'])->name('admin.competitions.store');
    Route::get('competitions/{id}', [CompetitionController::class, 'adminShow'])->name('admin.competitions.show');
    Route::get('competitions/{id}/edit', [CompetitionController::class, 'adminEdit'])->name('admin.competitions.edit');
    Route::put('competitions/{id}', [CompetitionController::class, 'adminUpdate'])->name('admin.competitions.update');
    Route::delete('competitions/{id}', [CompetitionController::class, 'adminDestroy'])->name('admin.competitions.destroy');

    // Admin Request Management
    Route::get('requests', [CompetitionController::class, 'adminRequestIndex'])->name('admin.requests.index');
    Route::get('requests/{id}', [CompetitionController::class, 'adminRequestShow'])->name('admin.requests.show');
    Route::patch('requests/{id}', [CompetitionController::class, 'adminUpdateRequestStatus'])->name('admin.requests.update');
    Route::get('/admin/request/document/{filename}', [CompetitionController::class, 'viewDocument'])->name('admin.request.document');

    // Achievement Management
    Route::get('achievements', [AchievementController::class, 'index'])->name('achievements.index');
    Route::get('achievements/{id}', [AchievementController::class, 'show'])->name('achievements.show');
    Route::post('achievements/{id}/approve', [AchievementController::class, 'approve'])->name('achievements.approve');
    Route::post('achievements/{id}/reject', [AchievementController::class, 'reject'])->name('achievements.reject');

    Route::resource('pre_university_achievements', PreUniversityAchievementController::class)
        ->only(['index', 'show']);

    // Recommendations
    Route::get('recommendations', [RecommendationController::class, 'index'])->name('admin.recommendations.index');
    Route::get('recommendations/{competition}', [RecommendationController::class, 'showRecommendations'])->name('admin.recommendations.show');
    Route::get('recommendations/{competition}/export', [RecommendationController::class, 'exportToExcel'])->name('admin.recommendations.export');
});

Route::middleware('auth')->prefix('student')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('student.dashboard');
    Route::get('/profile', [StudentController::class, 'profile'])->name('student.profile');
    Route::post('/profile/update', [StudentController::class, 'updateProfile'])->name('student.profile.update');
    Route::get('/recommendations', [StudentRecommendationController::class, 'index'])->name('student.recommendations.index');

    // Student Achievements
    Route::get('/achievements', [StudentAchievementController::class, 'index'])->name('student.achievements.index');
    Route::get('/achievements/{id}', [StudentAchievementController::class, 'show'])->name('student.achievements.show');
    Route::post('/achievements', [StudentAchievementController::class, 'store'])->name('student.achievements.store');
    Route::put('/achievements/{id}', [StudentAchievementController::class, 'update'])->name('student.achievements.update');
    Route::delete('/achievements/{id}', [StudentAchievementController::class, 'destroy'])->name('student.achievements.destroy');

    // Student Competition Requests
    Route::get('competitions', [CompetitionController::class, 'userIndex'])->name('student.competitions.index');
    Route::get('competitions/create', [CompetitionController::class, 'userCreate'])->name('student.competitions.create');
    Route::post('competitions', [CompetitionController::class, 'userStore'])->name('student.competitions.store');
    Route::get('competitions/{id}/edit', [CompetitionController::class, 'userEdit'])->name('student.competitions.edit');
    Route::put('competitions/{id}', [CompetitionController::class, 'userUpdate'])->name('student.competitions.update');
    Route::delete('competitions/{id}', [CompetitionController::class, 'userDestroy'])->name('student.competitions.destroy');
});

Route::middleware('auth')->prefix('supervisor')->group(function () {
    Route::get('/', [SupervisorController::class, 'index'])->name('supervisor.dashboard');

    Route::get('/profile', [SupervisorController::class, 'profile'])->name('supervisor.profile');
    Route::post('/profile/update', [SupervisorController::class, 'updateProfile'])->name('supervisor.profile.update');

    // Supervisor Competition Requests
    Route::get('competitions', [CompetitionController::class, 'userIndex'])->name('supervisor.competitions.index');
    Route::get('competitions/create', [CompetitionController::class, 'userCreate'])->name('supervisor.competitions.create');
    Route::post('competitions', [CompetitionController::class, 'userStore'])->name('supervisor.competitions.store');
    Route::get('competitions/{id}/edit', [CompetitionController::class, 'userEdit'])->name('supervisor.competitions.edit');
    Route::put('competitions/{id}', [CompetitionController::class, 'userUpdate'])->name('supervisor.competitions.update');
    Route::delete('competitions/{id}', [CompetitionController::class, 'userDestroy'])->name('supervisor.competitions.destroy');
});
