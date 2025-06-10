<!-- resources/views/create-order.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Konfirmasi Pesanan</h1>
        <p>Berikut adalah daftar produk yang akan Anda pesan:</p>

        <!-- Menampilkan daftar produk di keranjang -->
        <ul class="list-group">
            @foreach ($cart as $productId => $product)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h5>{{ $product['name'] }}</h5>
                        <p>{{ $product['quantity'] }} x Rp{{ number_format($product['price'], 2, ',', '.') }}</p>
                    </div>
                    <span class="badge bg-primary rounded-pill">Rp{{ number_format($product['price'] * $product['quantity'], 2, ',', '.') }}</span>
                </li>
            @endforeach
        </ul>

        <!-- Tombol untuk menyelesaikan pesanan -->
        <form action="{{ route('store-order') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="btn btn-success">Selesaikan Pesanan</button>
        </form>
    </div>
@endsection
