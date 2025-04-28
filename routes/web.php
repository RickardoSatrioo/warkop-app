<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// Rute untuk halaman utama (welcome page)
Route::get('/', function () {
    return view('welcome');
});

// Rute untuk dashboard yang bisa diakses tanpa login
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
