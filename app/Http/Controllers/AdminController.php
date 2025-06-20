<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Import model Order

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin dengan daftar semua pesanan.
     */
    public function index()
    {
        // Mengambil semua pesanan dari database
        // 'with' digunakan untuk mengambil data relasi (user & product) dalam satu query (Eager Loading)
        // 'latest()' untuk mengurutkan dari yang terbaru
        $orders = Order::with('user', 'product')->latest()->get();

        // Mengirim data pesanan ke view
        return view('admin.dashboard', compact('orders'));
    }
}
