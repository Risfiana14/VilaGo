<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VillaController;
use App\Http\Controllers\BookingController;

Route::get('/', [VillaController::class, 'index'])->name('home');
Route::resource('villas', VillaController::class);
Route::resource('bookings', BookingController::class);
Route::patch('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');