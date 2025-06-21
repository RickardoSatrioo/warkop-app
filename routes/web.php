<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PemilikController; // <-- Tambahkan ini

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/pesan', [PesanController::class, 'index'])->name('pesan');
    Route::post('/create-order', [PesanController::class, 'createOrder'])->name('create-order');
    Route::get('/order/confirmation', [PesanController::class, 'showConfirmation'])->name('order.confirmation');
    Route::post('/payment/create', [PaymentController::class, 'createTransaction'])->name('payment.create');
    Route::get('/order/status/{order_code}', function ($order_code) {
        $orders = App\Models\Order::where('order_code', $order_code)->where('user_id', auth()->id())->with('product')->get();
        if ($orders->isEmpty()) { abort(404, 'Pesanan tidak ditemukan.'); }
        return view('status-order', compact('orders'));
    })->name('order.status');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::post('/midtrans/notification', [PaymentController::class, 'notificationHandler'])->name('midtrans.notification');

Route::middleware('auth')->group(function () {
    // Grup untuk Admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::post('/orders/{order_code}/update-status', [AdminController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::resource('products', ProductController::class);
    });

    // === RUTE BARU UNTUK PEMILIK ===
    Route::middleware('role:pemilik')->prefix('pemilik')->name('pemilik.')->group(function () {
        Route::get('/dashboard', [PemilikController::class, 'index'])->name('dashboard');
    });
    // =============================
});

require __DIR__.'/auth.php';