<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BursarDashboardController;
use App\Http\Controllers\ParentDashboardController;
use App\Http\Controllers\SchoolAdminDashboardController;
use App\Http\Controllers\SuperAdminDashboardController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\TeacherProfileController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Or if using custom routes
Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

// SuperAdmin Dashboard
Route::get('/admin/dashboard', function () {
    return view('dashboards.superadmin');
})->middleware(['auth', 'role:SuperAdmin']);

// SchoolAdmin Dashboard
Route::get('/school/dashboard', function () {
    return view('dashboards.schooladmin');
})->middleware(['auth', 'role:SchoolAdmin']);

// Teacher Dashboard
Route::get('/teacher/dashboard', function () {
    return view('dashboards.teacher');
})->middleware(['auth', 'role:Teacher']);

// Student Dashboard
Route::get('/student/dashboard', function () {
    return view('dashboards.student');
})->middleware(['auth', 'role:Student']);

// Parent Dashboard
Route::get('/parent/dashboard', function () {
    return view('dashboards.parent');
})->middleware(['auth', 'role:Parent']);

// Bursar Dashboard
Route::get('/bursar/dashboard', function () {
    return view('dashboards.bursar');
})->middleware(['auth', 'role:Bursar']);

// Fallback dashboard for authenticated users without specific roles
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth']);

// Teacher Profile Routes
Route::middleware(['auth', 'role:Teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboards.teacher');
    Route::get('/teacher/profile', [TeacherProfileController::class, 'show'])->name('teacher.teacher-profile');
    Route::put('/teacher/profile', [TeacherProfileController::class, 'update'])->name('teacher.teacher-profile.update');
    Route::put('/profile/picture', [TeacherProfileController::class, 'updateProfilePicture'])->name('profile.picture.update');
    Route::delete('/profile/picture', [TeacherProfileController::class, 'removeProfilePicture'])->name('profile.picture.remove');
    Route::put('/teacher/profile', [TeacherProfileController::class, 'updateProfessional'])->name('teacher.teacher-profile.update');
    Route::put('/teacher/profile/password', [TeacherProfileController::class, 'updatePassword'])->name('teacher.teacher-profile.password');
});