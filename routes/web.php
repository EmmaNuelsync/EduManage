<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BursarDashboardController;
use App\Http\Controllers\ParentDashboardController;
use App\Http\Controllers\SchoolAdminDashboardController;
use App\Http\Controllers\SuperAdminDashboardController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\TeacherProfileController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\StudentResourceController;
use App\Http\Controllers\SchoolController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Or if using custom routes for authentication
Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

// SuperAdmin Dashboard
Route::get('/superadmin/dashboard', function () {
    return view('dashboards.superadmin');
})->name('dashboards.superadmin')->middleware(['auth', 'superadmin']);

// Default dashboard route (for all authenticated users)
Route::get('/dashboard', function () {
    // Redirect users based on their role
    if (auth()->user()->isSuperAdmin()) {
        return redirect()->route('dashboards.superadmin');
    }
    
    // Add other role redirects here as needed
    return view('dashboard');
})->name('dashboard')->middleware('auth');

// SchoolAdmin Dashboard
// Route::get('/school/dashboard', function () {
//     return view('dashboards.schooladmin');
// })->middleware(['auth', 'role:SchoolAdmin']);

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


//Student Profile Routes
Route::middleware(['auth', 'role:Student'])->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('dashboards.student');
    Route::get('/student/profile', [StudentProfileController::class, 'show'])->name('student.student-profile');
    Route::put('/student/profile', [StudentProfileController::class, 'updatePersonal'])->name('student.student-profile.update-personal');
    Route::put('/student/profile/academic', [StudentProfileController::class, 'updateAcademic'])->name('student.student-profile.update-academic');
    Route::put('/student/profile/password', [StudentProfileController::class, 'updatePassword'])->name('student.student-profile.password');
    Route::put('/student/profile/picture', [StudentProfileController::class, 'updatePicture'])->name('student.profile.picture.update');
    Route::delete('/student/profile/picture', [StudentProfileController::class, 'removePicture'])->name('student.profile.picture.remove');
});

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

// Resource Routes
Route::middleware(['auth', 'role:Teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
    Route::get('/resources/create', [ResourceController::class, 'create'])->name('resources.create');
    Route::post('/resources', [ResourceController::class, 'store'])->name('resources.store');
    Route::get('/resources/{resource}', [ResourceController::class, 'show'])->name('resources.show');
    Route::get('/resources/{resource}/download', [ResourceController::class, 'download'])->name('resources.download');
    Route::get('/resources/{resource}/edit', [ResourceController::class, 'edit'])->name('resources.edit');
    Route::put('/resources/{resource}', [ResourceController::class, 'update'])->name('resources.update');
    Route::delete('/resources/{resource}', [ResourceController::class, 'destroy'])->name('resources.destroy');
    Route::get('/resources/stats', [ResourceController::class, 'getStats'])->name('resources.stats');
});

// Student Resources Routes
Route::middleware(['auth', 'role:Student'])->prefix('student')->group(function () {
    Route::get('/resources', [StudentResourceController::class, 'index'])->name('student.resources.index');
    Route::get('/resources/{id}', [StudentResourceController::class, 'show'])->name('student.resources.show');
    Route::get('/resources/{id}/download', [StudentResourceController::class, 'download'])->name('student.resources.download');
    Route::get('/resources/history', [StudentResourceController::class, 'history'])->name('student.resources.history');
});

//School Routes
Route::resource('schools', SchoolController::class)->middleware(['auth', 'superadmin']);