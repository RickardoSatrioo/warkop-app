@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('content')
<div class="container">
    
    <header class="text-center my-5">
        <h1>Menu Andalan Kami</h1>
        <p class="lead" style="color: var(--text-muted-custom);">Selamat datang di Warkop Digital, temukan hidangan favorit Anda di bawah ini!</p>
    </header>
    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row gy-4">
        @forelse ($products as $product)
            <div class="col-lg-4 col-md-6">
                {{-- Menambahkan class 'product-card' untuk styling --}}
                <div class="card product-card h-100">

                    @php
                        $imageName = Str::slug($product->name) . '.jpg';
                        $imageUrl = asset('images/products/' . $imageName);
                    @endphp

                    <img src="{{ $imageUrl }}" 
                         class="card-img-top" 
                         style="height: 250px; object-fit: cover;" 
                         alt="{{ $product->name }}"
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=Gambar+Segera+Hadir';">

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text flex-grow-1">{{ $product->description }}</p>
                        {{-- Menambahkan class 'price-text' untuk styling harga --}}
                        <p class="price-text mt-3 mb-0"><b>Harga:</b> Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col text-center">
                <h3 class="mt-5">Mohon Maaf...</h3>
                <p class="lead" style="color: var(--text-muted-custom);">Saat ini belum ada produk yang tersedia.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection