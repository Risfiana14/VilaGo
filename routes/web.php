<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VillaController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\SettingController;

// 1. Rute Otentikasi (Auth)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 2. Rute Pelanggan / User Terautentikasi (Sudah Login)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    // Rute Detail Vila untuk Tamu/User
    Route::get('/villas/{villa}', [VillaController::class, 'show'])->name('villas.show');
    
    // Riwayat Pemesanan & Upload Pembayaran Pelanggan
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('user.my_bookings');
    Route::post('/my-bookings/{id}/upload-payment', [BookingController::class, 'uploadPayment'])->name('user.upload_payment');
    Route::patch('/my-bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('user.cancel_booking');

    // Tamu Membuat Booking
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

    // Modul Pengaturan Akun (Profil, Email, & Password)
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
});

// 3. Rute Khusus ADMIN (Protected Middleware Admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [VillaController::class, 'index'])->name('home');
    Route::resource('villas', VillaController::class)->except(['show']);
    
    // Kelola Booking Khusus Admin (Menggunakan URL /admin/bookings)
    Route::get('/admin/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/admin/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/admin/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/admin/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/admin/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::patch('/admin/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');

    // Modul Admin Lainnya
    Route::get('/guests', [GuestController::class, 'index'])->name('guests.index');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::resource('facilities', FacilityController::class)->only(['index', 'store', 'destroy']);
});