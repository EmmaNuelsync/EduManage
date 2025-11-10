<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BursarDashboardController;
use App\Http\Controllers\ParentDashboardController;
use App\Http\Controllers\SchoolAdminDashboardController;
use App\Http\Controllers\SuperAdminDashboardController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\TeacherDashboardController;

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