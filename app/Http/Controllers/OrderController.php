<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Menampilkan semua pesanan
    public function index()
    {
        $orders = Order::all(); // Ambil semua data pesanan
        return view('orders.index', compact('orders')); // Kirim data ke view
    }

    // Menampilkan form untuk menambah pesanan
    public function create()
    {
        return view('orders.create');
    }

    // Menyimpan pesanan baru
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'product_name' => 'required|string',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        // Simpan pesanan ke database
        Order::create($request->all());

        // Redirect ke halaman daftar pesanan
        return redirect()->route('orders.index');
    }

    // Menampilkan form untuk mengedit pesanan
    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    // Memperbarui pesanan
    public function update(Request $request, Order $order)
    {
        // Validasi data
        $request->validate([
            'product_name' => 'required|string',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        // Perbarui pesanan
        $order->update($request->all());

        // Redirect ke halaman daftar pesanan
        return redirect()->route('orders.index');
    }

    // Menghapus pesanan
    public function destroy(Order $order)
    {
        // Hapus pesanan
        $order->delete();

        // Redirect ke halaman daftar pesanan
        return redirect()->route('orders.index');
    }
}
