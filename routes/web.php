<?php

use App\Http\Controllers\AttendanceController;
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
    Route::post('/student/scan', [AttendanceController::class, 'scan']);

    Route::get('/popup/success', fn() => view('components.popups.success-att-popup'));
    Route::get('/popup/expired', fn() => view('components.popups.expired-att-popup'));
    Route::get('/popup/scanned', fn() => view('components.popups.scanned-att-popup'));
    Route::get('/popup/failed', fn() => view('components.popups.failed-att-popup'));
    Route::get('/popup/error', fn() => view('components.popups.error-att-popup'));
});


Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher/{page}', [AuthController::class, 'contentTeacher'])->name('teacher.page');
    Route::post('teacher/attendanceqrcode/create', [QRController::class, 'createQR'])->name('qr.create');
    Route::get('teacher/attendanceqrcode/show', [QRController::class, 'showQR'])->name('qr.show');
    Route::post('teacher/attendanceqrcode/end', [QRController::class, 'endQR'])->name('qr.end');
});
