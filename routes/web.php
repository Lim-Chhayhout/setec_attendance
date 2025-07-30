<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QRController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout.post');
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/{page}', [AuthController::class, 'contentStudent'])->name('student.page');
});

Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher/{page}', [AuthController::class, 'contentTeacher'])->name('teacher.page');
    Route::post('teacher/attendanceqrcode', [QRController::class, 'generatePost'])->name('generate.post');
});