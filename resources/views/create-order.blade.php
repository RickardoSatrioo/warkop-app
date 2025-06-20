@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="text-center">Konfirmasi Pesanan</h1>
        <p class="text-center lead" style="color: var(--text-muted-custom);">Berikut adalah rincian pesanan Anda.</p>

        {{-- Rincian Pesanan --}}
        <div class="card product-card mt-4">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach ($newlyCreatedOrders as $order)
                        <li class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">{{ $order->product->name }}</h5>
                                <small>{{ $order->quantity }} x Rp{{ number_format($order->price, 0, ',', '.') }}</small>
                            </div>
                            <span>Rp{{ number_format($order->price * $order->quantity, 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                     <li class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-center fw-bold border-top-2 pt-3">
                        <h5 class="mb-0" style="color: var(--accent-yellow);">Total Pembayaran</h5>
                        <h5 class="mb-0" style="color: var(--accent-yellow);">Rp{{ number_format($totalPrice, 0, ',', '.') }}</h5>
                    </li>
                </ul>
            </div>
        </div>
        
        {{-- Form Pembayaran dan Catatan --}}
        <form action="{{ route('payment.create') }}" method="POST" class="mt-3 text-center">
            @csrf
            {{-- Kirim total harga dan ID pesanan-pesanan yang baru dibuat --}}
            <input type="hidden" name="total_price" value="{{ $totalPrice }}">
            @foreach ($newlyCreatedOrders as $order)
                <input type="hidden" name="order_ids[]" value="{{ $order->id }}">
            @endforeach

            {{-- === FITUR BARU DI SINI: Kotak Catatan Pesanan === --}}
            <div class="card product-card mt-4">
                <div class="card-body text-start p-4">
                    <div class="mb-0">
                        <label for="notes" class="form-label h5" style="color: var(--accent-yellow);">Catatan untuk Penjual (Opsional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Contoh: Jangan pedas, tidak pakai bawang, dll." style="background-color: #3a3a3a; color: white; border-color: #555;"></textarea>
                    </div>
                </div>
            </div>
            {{-- =============================================== --}}

            <button type="submit" class="btn btn-custom-yellow btn-lg mt-4">Lanjutkan ke Pembayaran</button>
        </form>
    </div>
@endsection