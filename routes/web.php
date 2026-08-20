<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VillaController;

// Route untuk halaman utama / dashboard
Route::get('/', [VillaController::class, 'index'])->name('home');

// Route resource otomatis mendaftarkan villas.index, villas.create, villas.store, dll.
Route::resource('villas', VillaController::class);