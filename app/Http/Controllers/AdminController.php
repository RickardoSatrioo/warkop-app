<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin dengan daftar semua pesanan.
     */
    public function index()
    {
        // === PERUBAHAN DI SINI ===
        // Mengambil pesanan dan mengelompokkannya berdasarkan 'order_code'.
        $ordersByCode = Order::with('user', 'product')->latest()->get()->groupBy('order_code');
        // =========================

        return view('admin.dashboard', compact('ordersByCode'));
    }

    /**
     * Method baru untuk memperbarui status pesanan.
     */
    public function updateStatus(Request $request, $order_code)
    {
        $request->validate([
            'status' => 'required|string|in:menunggu konfirmasi,di masak,di antar,selesai,dibatalkan',
        ]);

        // Update status untuk semua item dengan order_code yang sama
        Order::where('order_code', $order_code)->update(['status' => $request->status]);

        return redirect()->route('admin.dashboard')->with('success', 'Status pesanan ' . $order_code . ' berhasil diperbarui!');
    }
}