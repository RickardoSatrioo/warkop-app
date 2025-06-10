<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua data produk dari database
        $products = Product::all();

        return view('checkout', compact('products'));
    }
}
