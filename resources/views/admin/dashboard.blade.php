@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="text-center mb-5">
        <h1>Dashboard Admin</h1>
        <p class="lead" style="color: var(--text-muted-custom);">Selamat datang, {{ Auth::user()->name }}!</p>
    </div>

    {{-- Tabel untuk menampilkan daftar pesanan --}}
    <div class="card product-card">
        <div class="card-body">
            <h4 class="card-title mb-4">Daftar Pesanan Masuk</h4>
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID Pesanan</th>
                            <th scope="col">Nama Pemesan</th>
                            <th scope="col">Produk</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Total Harga</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tanggal Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                {{-- Memastikan relasi user tidak null sebelum mengakses nama --}}
                                <td>{{ $order->user->name ?? 'User Dihapus' }}</td>
                                {{-- Memastikan relasi product tidak null sebelum mengakses nama --}}
                                <td>{{ $order->product->name ?? 'Produk Dihapus' }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>Rp{{ number_format($order->price * $order->quantity, 0, ',', '.') }}</td>
                                <td>
                                    @if($order->status == 'dibayar')
                                        <span class="badge bg-success">Dibayar</span>
                                    @elseif($order->status == 'konfirmasi')
                                        <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">Belum ada pesanan yang masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
