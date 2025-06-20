<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\PaymentController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/pesan', [PesanController::class, 'index'])->name('pesan');
    
    // Rute POST untuk memproses form dari halaman 'pesan'
    Route::post('/create-order', [PesanController::class, 'createOrder'])->name('create-order');
    
    // RUTE BARU (GET) untuk menampilkan halaman konfirmasi dengan aman
    Route::get('/order/confirmation', [PesanController::class, 'showConfirmation'])->name('order.confirmation');
    
    // Rute untuk memproses pembayaran ke Midtrans
    Route::post('/payment/create', [PaymentController::class, 'createTransaction'])->name('payment.create');
});

// Rute untuk notifikasi dari Midtrans (webhook)
Route::post('/midtrans/notification', [PaymentController::class, 'notificationHandler'])->name('midtrans.notification');

// Rute lain-lain
Route::middleware('auth')->group(function () {
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    });
});

require __DIR__.'/auth.php';
