@extends('layouts.app')

@section('content')
<div class="container my-5">
    <header class="text-center mb-5">
        <h1>Riwayat Pesanan Saya</h1>
        <p class="lead" style="color: var(--text-muted-custom);">Lihat semua transaksi yang pernah Anda lakukan.</p>
    </header>

    @forelse ($ordersByCode as $code => $orders)
        {{-- Setiap pesanan akan menjadi link ke halaman status --}}
        <a href="{{ route('order.status', ['order_code' => $code]) }}" class="text-decoration-none">
            <div class="card product-card mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1">Pesanan #{{ $code }}</h5>
                            <small class="text-muted">{{ $orders->first()->created_at->format('d F Y, H:i') }}</small>
                        </div>
                        <div>
                            @php
                                $currentStatus = $orders->first()->status;
                                $badgeClass = 'bg-info';
                                if ($currentStatus === 'selesai') $badgeClass = 'bg-success';
                                elseif (in_array($currentStatus, ['menunggu konfirmasi', 'di masak'])) $badgeClass = 'bg-warning text-dark';
                                elseif ($currentStatus === 'dibatalkan') $badgeClass = 'bg-danger';
                            @endphp
                            <span class="badge {{ $badgeClass }} fs-6">{{ ucfirst($currentStatus) }}</span>
                        </div>
                    </div>
                    <hr>
                    <ul class="list-unstyled">
                        @foreach($orders as $item)
                            <li class="d-flex justify-content-between text-white">
                                <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                                <span>Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span class="h5" style="color: var(--text-light);">Total</span>
                        <span class="h5" style="color: var(--accent-yellow);">Rp{{ number_format($orders->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </a>
    @empty
        <div class="card product-card text-center p-5">
            <h4 class="card-title">Anda belum memiliki riwayat pesanan.</h4>
            <p class="text-muted">Ayo mulai memesan sekarang!</p>
            <div class="mt-3">
                <a href="{{ route('pesan') }}" class="btn btn-custom-yellow">Pesan Sekarang</a>
            </div>
        </div>
    @endforelse

</div>
@endsection