@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Checkout</h1>

    <h3>Produk yang Anda Pilih:</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($selectedProducts as $selectedProduct)
                <tr>
                    <td>{{ $selectedProduct['product']->name }}</td>
                    <td>{{ $selectedProduct['quantity'] }}</td>
                    <td>Rp{{ number_format($selectedProduct['product']->price, 2, ',', '.') }}</td>
                    <td>Rp{{ number_format($selectedProduct['total'], 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tombol untuk melanjutkan pembayaran -->
    <div class="text-center">
        <button class="btn btn-success">Lanjutkan Pembayaran</button>
    </div>
</div>
@endsection
