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
    
    public function addToCart(Request $request, $productId)
{
    $product = Product::findOrFail($productId);

    // Ambil cart yang ada di session atau buat baru
    $cart = session()->get('cart', []);

    // Cek apakah produk sudah ada di keranjang
    if (isset($cart[$productId])) {
        $cart[$productId]['quantity'] += 1;  // Tambah jumlah produk
    } else {
        $cart[$productId] = [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
        ];
    }

    // Simpan kembali ke session
    session()->put('cart', $cart);

    return redirect()->route('dashboard');  // Kembali ke dashboard setelah menambahkan produk
}

}
