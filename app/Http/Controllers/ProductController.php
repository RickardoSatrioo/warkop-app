<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Menampilkan semua produk
    public function index()
    {
        $products = Product::all();
        return view('dashboard', compact('products'));
    }

    // Menampilkan form untuk menambah produk
    public function create()
    {
        return view('products.create');
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        // 1. Validasi data, termasuk gambar
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // 2. Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('products', $imageName, 'public');
            $validatedData['image'] = $imageName;
        }

        // 3. Simpan produk ke database
        Product::create($validatedData);

        // 4. Redirect ke halaman dashboard
        return redirect()->route('dashboard')->with('success', 'Produk berhasil ditambahkan.');
    }

    // Metode edit(), update(), dan destroy() telah dihapus.
}