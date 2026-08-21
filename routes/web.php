<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VillaController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ReportController;

Route::get('/', [VillaController::class, 'index'])->name('home');
Route::resource('villas', VillaController::class);
Route::resource('bookings', BookingController::class);
Route::patch('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
Route::get('/guests', [GuestController::class, 'index'])->name('guests.index');
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');