<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createTransaction(Request $request)
    {
        // Validasi request
        $request->validate([
            'total_price' => 'required|numeric',
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
        ]);
        
        // Ambil semua order berdasarkan ID yang dikirim
        $orders = Order::whereIn('id', $request->order_ids)->get();

        if ($orders->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'Pesanan tidak ditemukan.']);
        }
        
        // Buat ID unik untuk transaksi Midtrans
        $transactionCode = 'WARKOP-' . time();

        $item_details = [];
        foreach($orders as $order) {
            $item_details[] = [
                'id' => $order->product_id,
                'price' => $order->price,
                'quantity' => $order->quantity,
                'name' => $order->product->name,
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id' => $transactionCode,
                'gross_amount' => $request->total_price,
            ],
            'item_details' => $item_details,
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'phone' => auth()->user()->phone,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            
            // Simpan snap_token ke semua order yang terkait
            Order::whereIn('id', $request->order_ids)->update([
                'snap_token' => $snapToken,
                'order_code' => $transactionCode, // Gunakan kode transaksi yang sama
            ]);

            // Redirect ke halaman pembayaran
            return view('payment', compact('snapToken'));

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function notificationHandler(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                // Cari pesanan berdasarkan order_code
                Order::where('order_code', $request->order_id)->update(['payment_status' => 'paid']);
            }
        }
        
        return response()->json(['message' => 'Notification processed.']);
    }
}
