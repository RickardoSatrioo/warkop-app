<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use Midtrans\Snap;
use Midtrans\Config;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $products = $request->input('products');
        $user = Auth::user();
        $orderItems = [];
        $total = 0;

        // Simpan semua order yang valid
        foreach ($products as $productData) {
            $productId = $productData['id'];
            $quantity = intval($productData['quantity']);

            if ($quantity > 0) {
                $product = Product::find($productId);
                if ($product) {
                    $orderItems[] = [
                        'id' => $product->id,
                        'price' => $product->price,
                        'quantity' => $quantity,
                        'name' => $product->name,
                    ];

                    $total += $product->price * $quantity;

                    Order::create([
                        'user_id' => $user->id,
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'price' => $product->price * $quantity,
                        'status' => 'konfirmasi',
                    ]);
                }
            }
        }

        if ($total == 0) {
            return redirect()->back()->with('error', 'Tidak ada produk yang dipilih.');
        }

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => uniqid('ORDER-'),
                'gross_amount' => $total,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => $orderItems
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('bayar', compact('snapToken', 'total'));
    }

    public function pembayaranSukses(Request $request)
    {
        Order::where('user_id', Auth::id())
            ->where('status', 'konfirmasi')
            ->update(['status' => 'dibayar']);

        return redirect()->route('status-order');
    }
}
