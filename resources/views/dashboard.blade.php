<!-- resources/views/dashboard.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard</h1>
    <p>Selamat datang di dashboard, berikut adalah daftar produk kami:</p>

    <!-- Menampilkan daftar produk -->
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text">Harga: Rp{{ number_format($product->price, 2, ',', '.') }}</p>
                      <!--  <a href="#" class="btn btn-primary">Beli Sekarang</a> -->
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
