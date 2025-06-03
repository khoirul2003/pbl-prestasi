<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AdminCompetitionRequestController;
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
use App\Http\Controllers\StudentCompetitionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentPeriodController;
use App\Http\Controllers\StudentRecommendationController;
use App\Http\Controllers\StudyProgramController;
use App\Http\Controllers\SupervisorCompetitionController;
use App\Http\Controllers\SupervisorController;
use App\Models\Period;
use App\Models\StudentPeriod;
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

    Route::resource('pre_university_achievements', PreUniversityAchievementController::class)
        ->only(['index', 'show']);

    Route::get('recommendations', [RecommendationController::class, 'index'])->name('admin.recommendations.index');
    Route::get('recommendations/{competition}', [RecommendationController::class, 'showRecommendations'])->name('admin.recommendations.show');

    Route::get('requests', [AdminCompetitionRequestController::class, 'index'])->name('admin.requests.index');
    Route::patch('requests/{id}', [AdminCompetitionRequestController::class, 'updateStatus'])->name('admin.requests.update');
    Route::get('requests/{id}', [AdminCompetitionRequestController::class, 'show'])->name('admin.requests.show');
    Route::get('/admin/request/document/{filename}', [AdminCompetitionRequestController::class, 'viewDocument'])->name('admin.request.document');
});

Route::middleware('auth')->prefix('student')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('student.dashboard');
    Route::get('/profile', [StudentController::class, 'profile'])->name('student.profile');
    Route::post('/profile/update', [StudentController::class, 'updateProfile'])->name('student.profile.update');
    Route::get('/recommendations', [StudentRecommendationController::class, 'index'])->name('student.recommendations.index');

    Route::get('/achievements', [StudentAchievementController::class, 'index'])->name('student.achievements.index');
    Route::get('/achievements/{id}', [StudentAchievementController::class, 'show'])->name('student.achievements.show');
    Route::post('/achievements', [StudentAchievementController::class, 'store'])->name('student.achievements.store');
    Route::put('/achievements/{id}', [StudentAchievementController::class, 'update'])->name('student.achievements.update');
    Route::delete('/achievements/{id}', [StudentAchievementController::class, 'destroy'])->name('student.achievements.destroy');

    Route::get('competitions', [StudentCompetitionController::class, 'index'])->name('student.competitions.index');
    Route::get('competitions/create', [StudentCompetitionController::class, 'create'])->name('student.competitions.create');
    Route::post('competitions', [StudentCompetitionController::class, 'store'])->name('student.competitions.store');
    Route::get('competitions/{id}/edit', [StudentCompetitionController::class, 'edit'])->name('student.competitions.edit');
    Route::put('competitions/{id}', [StudentCompetitionController::class, 'update'])->name('student.competitions.update');
    Route::delete('competitions/{id}', [StudentCompetitionController::class, 'destroy'])->name('student.competitions.destroy');
});

Route::middleware('auth')->prefix('supervisor')->group(function () {
    Route::get('/', [SupervisorController::class, 'index'])->name('supervisor.dashboard');

    Route::get('competitions', [SupervisorCompetitionController::class, 'index'])->name('supervisor.competitions.index');
    Route::get('competitions/create', [SupervisorCompetitionController::class, 'create'])->name('supervisor.competitions.create');
    Route::post('competitions', [SupervisorCompetitionController::class, 'store'])->name('superviosr.competitions.store');
});
