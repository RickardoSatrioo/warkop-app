<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Menampilkan semua transaksi
    public function index()
    {
        $transactions = Transaction::all(); // Ambil semua data transaksi
        return view('transactions.index', compact('transactions')); // Kirim data ke view
    }

    // Menampilkan form untuk menambah transaksi
    public function create()
    {
        $orders = Order::all(); // Ambil semua pesanan untuk memilih pesanan
        return view('transactions.create', compact('orders'));
    }

    // Menyimpan transaksi baru
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'order_id' => 'required|exists:orders,id', // Pastikan order_id valid
            'total_amount' => 'required|numeric',
            'payment_method' => 'required|in:cash,credit,qr',
        ]);

        // Simpan transaksi ke database
        Transaction::create($request->all());

        // Redirect ke halaman daftar transaksi
        return redirect()->route('transactions.index');
    }

    // Menampilkan form untuk mengedit transaksi
    public function edit(Transaction $transaction)
    {
        $orders = Order::all(); // Ambil semua pesanan untuk memilih pesanan
        return view('transactions.edit', compact('transaction', 'orders'));
    }

    // Memperbarui transaksi
    public function update(Request $request, Transaction $transaction)
    {
        // Validasi data
        $request->validate([
            'order_id' => 'required|exists:orders,id', // Pastikan order_id valid
            'total_amount' => 'required|numeric',
            'payment_method' => 'required|in:cash,credit,qr',
        ]);

        // Perbarui transaksi
        $transaction->update($request->all());

        // Redirect ke halaman daftar transaksi
        return redirect()->route('transactions.index');
    }

    // Menghapus transaksi
    public function destroy(Transaction $transaction)
    {
        // Hapus transaksi
        $transaction->delete();

        // Redirect ke halaman daftar transaksi
        return redirect()->route('transactions.index');
    }
}
