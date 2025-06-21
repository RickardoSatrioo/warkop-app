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

    {{-- gy-5 memberikan jarak vertikal yang lebih besar antar baris kartu --}}
    <div class="row gy-5">
        @forelse ($products as $product)
            <div class="col-lg-4 col-md-6">
                {{-- Menggunakan class 'product-card' yang stylenya sudah terpusat di layout --}}
                <div class="product-card">

                    {{-- === PERBAIKAN DI SINI === --}}
                    @php
                        // Logika diperbaiki untuk mengambil gambar dari database.
                        // Cek apakah produk memiliki record gambar di database.
                        // Jika ada, buat URL ke folder 'storage/products'.
                        // Jika tidak ada, gunakan URL gambar placeholder.
                        $imageUrl = $product->image
                                    ? asset('storage/products/' . $product->image)
                                    : 'https://via.placeholder.com/400x300?text=Gambar+Segera+Hadir';
                    @endphp
                    {{-- ========================= --}}

                    {{-- Wrapper untuk efek zoom gambar yang rapi --}}
                    <div class="card-img-wrapper">
                        {{-- 'src' sekarang menggunakan $imageUrl yang sudah diperbaiki --}}
                        <img src="{{ $imageUrl }}" 
                             class="card-img-top" 
                             style="height: 250px; object-fit: cover;" 
                             alt="{{ $product->name }}"
                             onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=Gambar+Segera+Hadir';">
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        
                        <p class="price-text">
                            Harga: <span class="price-value">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col text-center py-5">
                <h3 class="mt-5">Mohon Maaf...</h3>
                <p class="lead" style="color: var(--text-muted-custom);">Saat ini belum ada produk yang tersedia.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection