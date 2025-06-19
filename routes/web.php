<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// 🟢 Halaman utama (public)
Route::get('/', function () {
    return view('welcome');
});

// 🟢 Dashboard umum, bisa diakses tanpa login
Route::get('/dashboard', [ProductController::class, 'index'])->name('dashboard');

// 🟡 Autentikasi
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

require __DIR__.'/auth.php';

// 🔐 Middleware auth
Route::middleware('auth')->group(function () {
    // 🛡 Admin dashboard
    Route::middleware('role:admin')->get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // 🛡 Sander dashboard
    Route::middleware('role:sander')->get('/sander', function () {
        return view('sander.dashboard');
    })->name('sander.dashboard');

    // 🛡 User dashboard
    Route::middleware('role:user')->get('/dashboard-user', [DashboardController::class, 'index'])->name('dashboard.user');

    // 👤 Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🛒 Checkout dan pesan
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::get('/pesan', [PesanController::class, 'index'])->name('pesan');
    Route::post('/add-to-cart/{productId}', [DashboardController::class, 'addToCart'])->name('add-to-cart');

    // 💸 Order dan pembayaran
    Route::post('/pesanan', [OrderController::class, 'store'])->name('create-order');
    Route::get('/bayar', [OrderController::class, 'bayar'])->name('bayar');
    Route::post('/pembayaran-sukses', [OrderController::class, 'pembayaranSukses'])->name('pembayaran-sukses');
    Route::get('/status-order', function () {
        return view('status-order');
    })->name('status-order');

    Route::resource('products', ProductController::class);
});
