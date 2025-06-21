<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Menampilkan halaman utama manajemen produk (menu).
     */
    public function index()
    {
        $products = Product::latest()->get(); // Ambil produk terbaru
        return view('admin.products.index', compact('products'));
    }

    /**
     * Menampilkan form untuk menambah produk baru.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Simpan gambar ke storage/app/public/products
            $imagePath = $request->file('image')->store('products', 'public');
            $validatedData['image'] = basename($imagePath);
        }

        Product::create($validatedData);

        return redirect()->route('admin.products.index')->with('success', 'Menu baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit produk.
     * Route-model binding akan otomatis mencari produk berdasarkan ID.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Memperbarui data produk di database.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image) {
                Storage::disk('public')->delete('products/' . $product->image);
            }
            // Simpan gambar baru
            $imagePath = $request->file('image')->store('products', 'public');
            $validatedData['image'] = basename($imagePath);
        }

        $product->update($validatedData);

        return redirect()->route('admin.products.index')->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy(Product $product)
    {
        // Hapus gambar terkait dari storage
        if ($product->image) {
            Storage::disk('public')->delete('products/' . $product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Menu berhasil dihapus.');
    }
}