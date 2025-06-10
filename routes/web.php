<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard dapat diakses tanpa login
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Hanya untuk user yang login
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout dan Pesan
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::get('/pesan', [PesanController::class, 'index'])->name('pesan');

    // Tambah ke keranjang
    Route::post('/add-to-cart/{productId}', [DashboardController::class, 'addToCart'])->name('add-to-cart');

    // Proses order dan pembayaran Midtrans
    Route::post('/pesanan', [OrderController::class, 'store'])->name('create-order');
    
    // Halaman bayar Midtrans (ditampilkan setelah create-order)
    Route::get('/bayar', [OrderController::class, 'bayar'])->name('bayar');

    // Handle sukses pembayaran dari Midtrans
    Route::post('/pembayaran-sukses', [OrderController::class, 'pembayaranSukses'])->name('pembayaran-sukses');

    // Halaman status order setelah pembayaran berhasil
    Route::get('/status-order', function () {
        return view('status-order');
    })->name('status-order');
});

// Autentikasi
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

require __DIR__.'/auth.php';
