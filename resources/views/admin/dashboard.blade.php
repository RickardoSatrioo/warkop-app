@extends('layouts.app')

@section('content')
<div class="container my-5">
    <header class="text-center mb-5">
        <h1>Dashboard Admin</h1>
        <p class="lead" style="color: var(--text-muted-custom);">
            Selamat datang, {{ Auth::user()->name }}! Kelola semua pesanan yang masuk di sini.
        </p>
    </header>

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    {{-- Looping untuk setiap grup pesanan berdasarkan order_code --}}
    @forelse ($ordersByCode as $code => $orders)
        <div class="card product-card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h5 class="mb-0">
                        {{-- === PERUBAHAN DI SINI: Cek apakah kode pesanan ada === --}}
                        @if ($code)
                            Pesanan <span class="text-warning">#{{ $code }}</span>
                        @else
                            Pesanan <span class="text-danger">#KODE INVALID</span>
                        @endif
                    </h5>
                    <small class="text-muted">Pemesan: {{ $orders->first()->user->name ?? 'User Dihapus' }} | Tanggal: {{ $orders->first()->created_at->format('d M Y, H:i') }}</small>
                </div>
                <div class="mt-2 mt-md-0">
                    {{-- === PERUBAHAN DI SINI: Hanya tampilkan form jika kode valid === --}}
                    @if ($code)
                        <form action="{{ route('admin.orders.updateStatus', $code) }}" method="POST" class="d-flex align-items-center">
                            @csrf
                            <select name="status" class="form-select form-select-sm me-2" style="width: 180px;">
                                @php
                                    $statuses = ['menunggu konfirmasi', 'di masak', 'di antar', 'selesai', 'dibatalkan'];
                                    $currentStatus = $orders->first()->status;
                                @endphp
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" @if($status == $currentStatus) selected @endif>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </form>
                    @else
                        {{-- Tampilkan pesan jika kode tidak valid --}}
                        <span class="badge bg-secondary">Data Lama / Tidak Valid</span>
                    @endif
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Total Harga</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->product->name ?? 'Produk Dihapus' }}</td>
                                    <td>{{ $order->quantity }}</td>
                                    <td>Rp{{ number_format($order->price, 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format($order->price * $order->quantity, 0, ',', '.') }}</td>
                                    <td style="min-width: 200px;">{{ $order->notes ?: '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="card product-card">
            <div class="card-body text-center p-5">
                <h4 class="card-title">Belum ada pesanan yang masuk.</h4>
            </div>
        </div>
    @endforelse
</div>
@endsection