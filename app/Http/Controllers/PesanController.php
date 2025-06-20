<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class PesanController extends Controller
{
    /**
     * Menampilkan halaman untuk memilih produk.
     */
    public function index()
    {
        // === PERUBAHAN DI SINI ===
        // Jika pengguna adalah admin, alihkan ke dashboard admin.
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak diizinkan untuk membuat pesanan.');
        }
        // =========================

        $products = Product::all();
        return view('pesan', compact('products'));
    }

    /**
     * Memproses produk yang dipilih (POST), MENYIMPANNYA ke DB dengan status 'pending',
     * LALU REDIRECT ke halaman konfirmasi.
     */
    public function createOrder(Request $request)
    {
        // === PERUBAHAN DI SINI ===
        // Blokir admin agar tidak bisa memproses pesanan.
        if (Auth::user()->hasRole('admin')) {
            abort(403, 'AKSES DITOLAK. Admin tidak dapat membuat pesanan.');
        }
        // =========================

        $request->validate([
            'products' => 'required|array',
            'products.*.quantity' => 'required|integer|min:0',
        ]);

        $orderIds = [];

        foreach ($request->products as $productId => $details) {
            if ($details['quantity'] > 0) {
                $product = Product::find($productId);
                if ($product) {
                    $order = Order::create([
                        'user_id' => Auth::id(),
                        'product_id' => $product->id,
                        'quantity' => (int)$details['quantity'],
                        'price' => $product->price,
                        'status' => 'konfirmasi',
                        'payment_status' => 'pending',
                        'order_code' => 'INV-' . Auth::id() . time() . $product->id, // Placeholder sementara
                    ]);
                    $orderIds[] = $order->id; // Kumpulkan ID pesanan yang baru dibuat
                }
            }
        }

        if (empty($orderIds)) {
            return redirect()->route('pesan')->withErrors(['error' => 'Anda harus memilih setidaknya satu produk.']);
        }
        
        // Simpan ID pesanan ke session untuk diambil di halaman selanjutnya
        $request->session()->put('order_ids_for_confirmation', $orderIds);
        
        // Redirect ke halaman konfirmasi (rute GET)
        return redirect()->route('order.confirmation');
    }

    /**
     * Method baru untuk MENAMPILKAN halaman konfirmasi (GET).
     * Aman untuk di-refresh.
     */
    public function showConfirmation(Request $request)
    {
        // Ambil data ID pesanan dari session
        $orderIds = $request->session()->get('order_ids_for_confirmation');

        // Jika tidak ada data di session (misal: user langsung akses URL), kembalikan ke halaman pesan
        if (!$orderIds) {
            return redirect()->route('pesan');
        }

        // Ambil data order lengkap dari database berdasarkan ID yang ada di session
        // 'with('product')' untuk Eager Loading, mengambil data produk terkait secara efisien
        $newlyCreatedOrders = Order::whereIn('id', $orderIds)->with('product')->get();
        
        // Jika karena suatu hal pesanan tidak ditemukan, kembali ke halaman pesan
        if ($newlyCreatedOrders->isEmpty()) {
            return redirect()->route('pesan');
        }

        // Hitung ulang total harga dari data yang valid di database
        $totalPrice = $newlyCreatedOrders->sum(function($order) {
            return $order->price * $order->quantity;
        });

        // Tampilkan view konfirmasi dengan data yang diperlukan
        return view('create-order', compact('newlyCreatedOrders', 'totalPrice'));
    }
}