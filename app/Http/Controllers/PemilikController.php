<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PemilikController extends Controller
{
    public function index()
    {
        // === PERUBAHAN LOGIKA DI SINI ===
        // Semua perhitungan sekarang berdasarkan status 'selesai'.

        // --- Data untuk Kartu Ringkasan ---
        // Pendapatan hari ini dihitung dari pesanan yang statusnya 'selesai' PADA HARI INI.
        $pendapatanHariIni = Order::where('status', 'selesai')
                                  ->whereDate('updated_at', Carbon::today())
                                  ->sum(DB::raw('price * quantity'));

        // Transaksi hari ini dihitung dari pesanan yang statusnya 'selesai' PADA HARI INI.
        $transaksiHariIni = Order::where('status', 'selesai')
                                 ->whereDate('updated_at', Carbon::today())
                                 ->distinct('order_code')
                                 ->count();
        
        // Total pendapatan dari semua pesanan yang pernah selesai.
        $totalPendapatan = Order::where('status', 'selesai')->sum(DB::raw('price * quantity'));

        // --- Data untuk Grafik Penjualan 7 Hari Terakhir ---
        // Data diambil dari pesanan yang statusnya 'selesai' dalam 7 hari terakhir.
        $salesData = Order::where('status', 'selesai')
            ->where('updated_at', '>=', Carbon::now()->subDays(7))
            ->select(
                DB::raw('DATE(updated_at) as tanggal'), // Dikelompokkan berdasarkan tanggal selesai
                DB::raw('SUM(price * quantity) as total')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();
        
        // Format data agar siap digunakan oleh Chart.js
        $chartLabels = $salesData->pluck('tanggal')->map(function($date) {
            return Carbon::parse($date)->format('d M');
        });
        $chartData = $salesData->pluck('total');

        // --- Data untuk Tabel Transaksi ---
        // Menampilkan 10 transaksi terakhir yang sudah 'selesai'
        $recentTransactions = Order::where('status', 'selesai')
                                  ->with('user', 'product')
                                  ->latest('updated_at') // Diurutkan berdasarkan kapan pesanan selesai
                                  ->get()
                                  ->groupBy('order_code')
                                  ->take(10);

        return view('pemilik.dashboard', compact(
            'pendapatanHariIni',
            'transaksiHariIni',
            'totalPendapatan',
            'chartLabels',
            'chartData',
            'recentTransactions'
        ));
    }
}