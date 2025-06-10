<?php

namespace App\Http\Controllers;

use App\Models\Product; // Pastikan menggunakan model Product
use Illuminate\Http\Request;

class PesanController extends Controller
{
    /**
     * Menampilkan halaman pesan dengan data produk.
     */
    public function index()
    {
        // Mengambil semua produk dari database
        $products = Product::all();

        // Mengirim data produk ke tampilan pesan.blade.php
        return view('pesan', compact('products'));
    }
}
