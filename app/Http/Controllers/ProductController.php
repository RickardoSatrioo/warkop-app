<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Menampilkan semua produk
    public function index()
    {
        $products = Product::all(); // Ambil semua data produk
        return view('products.index', compact('products')); // Kirim data ke view
    }

    // Menampilkan form untuk menambah produk
    public function create()
    {
        return view('products.create');
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        // Simpan produk ke database
        Product::create($request->all());

        // Redirect ke halaman daftar produk
        return redirect()->route('products.index');
    }

    // Menampilkan form untuk mengedit produk
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // Memperbarui produk
    public function update(Request $request, Product $product)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        // Perbarui produk
        $product->update($request->all());

        // Redirect ke halaman daftar produk
        return redirect()->route('products.index');
    }

    // Menghapus produk
    public function destroy(Product $product)
    {
        // Hapus produk
        $product->delete();

        // Redirect ke halaman daftar produk
        return redirect()->route('products.index');
    }
}
