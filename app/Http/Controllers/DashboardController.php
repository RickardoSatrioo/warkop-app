<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan data produk.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua data produk dari database
        $products = Product::all();

        // Mengirim data produk ke view dashboard
        return view('dashboard', compact('products'));
    }
}
