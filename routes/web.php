<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/pesan', [PesanController::class, 'index'])->name('pesan');
    
    Route::post('/create-order', [PesanController::class, 'createOrder'])->name('create-order');
    
    Route::get('/order/confirmation', [PesanController::class, 'showConfirmation'])->name('order.confirmation');
    
    Route::post('/payment/create', [PaymentController::class, 'createTransaction'])->name('payment.create');

    // === TAMBAHKAN RUTE DI BAWAH INI ===
    // Rute untuk menampilkan halaman status pesanan setelah pembayaran berhasil.
    Route::get('/order/status', function () {
        return view('status-order');
    })->name('order.status');
    // ===================================
});

// Rute untuk notifikasi dari Midtrans (webhook)
Route::post('/midtrans/notification', [PaymentController::class, 'notificationHandler'])->name('midtrans.notification');

// Rute lain-lain
Route::middleware('auth')->group(function () {
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        
        Route::resource('products', ProductController::class);
    });
});

require __DIR__.'/auth.php';