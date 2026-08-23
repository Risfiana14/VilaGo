<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VillaController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\SettingController;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute yang dapat diakses oleh USER TERAUTENTIKASI (Admin & Tamu)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    // Tamu dapat membuat booking
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
});

// Rute Khusus ADMIN (Dilindungi Middleware Admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [VillaController::class, 'index'])->name('home');
    Route::resource('villas', VillaController::class);
    
    // Kelola booking khusus admin (View, Edit, Delete, Update Status)
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');

    Route::get('/guests', [GuestController::class, 'index'])->name('guests.index');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::resource('facilities', FacilityController::class)->only(['index', 'store', 'destroy']);
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings/{setting}', [SettingController::class, 'update'])->name('settings.update');
});