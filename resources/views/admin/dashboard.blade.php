@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Mengadopsi struktur header dari contoh referensi --}}
    <header class="text-center my-5">
        <h1>Dashboard Admin</h1>
        <p class="lead" style="color: var(--text-muted-custom);">
            Selamat datang, {{ Auth::user()->name }}! Kelola semua pesanan yang masuk di sini.
        </p>
    </header>

    {{-- Opsi untuk menampilkan notifikasi sukses --}}
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">Daftar Pesanan Masuk</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Kode Pesanan</th>
                            <th>Nama Pemesan</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Status Pesanan</th>
                            <th>Status Pembayaran</th>
                            <th>Tanggal Pesan</th>
                            <th>Aksi</th> {{-- Kolom baru untuk tindakan admin --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->order_code ?: 'N/A' }}</td>
                                <td>{{ $order->user->name ?? 'User Dihapus' }}</td>
                                <td>{{ $order->product->name ?? 'Produk Dihapus' }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>Rp{{ number_format($order->total_price ?? ($order->price * $order->quantity), 0, ',', '.') }}</td>
                                <td>
                                    @if($order->status === 'dibayar' || $order->status === 'selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($order->status === 'konfirmasi' || $order->status === 'pending')
                                        <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                                    @elseif($order->status === 'dibatalkan')
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @else
                                        <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($order->payment_status === 'paid')
                                        <span class="badge bg-primary">Lunas</span>
                                    @else
                                        {{-- Menggunakan 'bg-danger' untuk perhatian lebih --}}
                                        <span class="badge bg-danger">Belum Lunas</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</td>
                                <td>
                                    {{-- Tombol aksi untuk melihat detail atau mengelola pesanan --}}
                                    <a href="{{-- route('admin.orders.show', $order->id) --}}" class="btn btn-sm btn-info">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                {{-- Menyesuaikan colspan karena ada penambahan kolom Aksi --}}
                                <td colspan="10" class="text-center py-4">Belum ada pesanan yang masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection