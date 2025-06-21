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
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak diizinkan untuk membuat pesanan.');
        }

        $products = Product::all();
        return view('pesan', compact('products'));
    }

    /**
     * Memproses produk yang dipilih dan membuat grup pesanan.
     */
    public function createOrder(Request $request)
    {
        if (Auth::user()->hasRole('admin')) {
            abort(403, 'AKSES DITOLAK. Admin tidak dapat membuat pesanan.');
        }

        $request->validate([
            'products' => 'required|array',
            'products.*.quantity' => 'required|integer|min:0',
        ]);

        $orderIds = [];
        
        $groupOrderCode = 'WARKOP-' . time() . '-' . Auth::id();

        foreach ($request->products as $productId => $details) {
            if ($details['quantity'] > 0) {
                $product = Product::find($productId);
                if ($product) {
                    $order = Order::create([
                        'user_id' => Auth::id(),
                        'product_id' => $product->id,
                        'quantity' => (int)$details['quantity'],
                        'price' => $product->price,
                        // === PERUBAHAN DI SINI ===
                        'status' => 'menunggu konfirmasi', // Status default baru
                        // =========================
                        'payment_status' => 'pending',
                        'order_code' => $groupOrderCode,
                    ]);
                    $orderIds[] = $order->id;
                }
            }
        }

        if (empty($orderIds)) {
            return redirect()->route('pesan')->withErrors(['error' => 'Anda harus memilih setidaknya satu produk.']);
        }
        
        $request->session()->put('order_ids_for_confirmation', $orderIds);
        
        return redirect()->route('order.confirmation');
    }

    /**
     * Menampilkan halaman konfirmasi pesanan.
     */
    public function showConfirmation(Request $request)
    {
        $orderIds = $request->session()->get('order_ids_for_confirmation');

        if (!$orderIds) {
            return redirect()->route('pesan');
        }

        $newlyCreatedOrders = Order::whereIn('id', $orderIds)->with('product')->get();
        
        if ($newlyCreatedOrders->isEmpty()) {
            return redirect()->route('pesan');
        }

        $totalPrice = $newlyCreatedOrders->sum(function($order) {
            return $order->price * $order->quantity;
        });

        return view('create-order', compact('newlyCreatedOrders', 'totalPrice'));
    }
}