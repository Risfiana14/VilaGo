<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VillaController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\SettingController;

// Rute Tamu/Guest (Auth)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Khusus User Terautentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});

// Rute Khusus ADMIN (Dilindungi Middleware Admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [VillaController::class, 'index'])->name('home');
    Route::resource('villas', VillaController::class);
    Route::resource('bookings', BookingController::class);
    Route::patch('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::get('/guests', [GuestController::class, 'index'])->name('guests.index');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::resource('facilities', FacilityController::class)->only(['index', 'store', 'destroy']);
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings/{setting}', [SettingController::class, 'update'])->name('settings.update');
});