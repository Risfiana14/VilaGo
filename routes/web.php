<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VillaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [VillaController::class, 'index'])->name('home');