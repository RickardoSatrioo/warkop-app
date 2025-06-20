@extends('layouts.app')

@section('content')
<div class="container my-5">
    <header class="text-center mb-5">
        <h1>Pesan Makanan & Minuman</h1>
        <p class="lead" style="color: var(--text-muted-custom);">Pilih menu dan tentukan jumlahnya di bawah ini.</p>
    </header>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Memberi ID pada form untuk JavaScript --}}
    <form id="order-form" action="{{ route('create-order') }}" method="POST">
        @csrf

        {{-- Menghapus class 'list-group' dan menggunakan struktur baru --}}
        <ul class="list-unstyled">
            @foreach ($products as $product)
                {{-- Menggunakan class 'order-item' kustom yang baru kita buat --}}
                <li class="order-item">
                    
                    {{-- Menambahkan Gambar Produk untuk visual yang lebih baik --}}
                    @php $imageUrl = asset('images/products/' . (Str::slug($product->name) . '.jpg')); @endphp
                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="order-item-img d-none d-sm-block" onerror="this.style.display='none'">

                    {{-- Info Produk (Nama, Deskripsi, Harga) --}}
                    <div class="flex-grow-1">
                        <h5 class="mb-1">{{ $product->name }}</h5>
                        <p class="mb-2" style="color: var(--text-muted-custom); font-size: 0.9rem;">{{ $product->description }}</p>
                        <p class="price-text mb-0"><b>Rp{{ number_format($product->price, 0, ',', '.') }}</b></p>
                    </div>

                    {{-- Pengatur Jumlah (tampilannya diubah, fungsinya tetap sama) --}}
                    <div class="d-flex align-items-center quantity-selector ms-sm-auto">
                        <button type="button" class="btn btn-quantity" onclick="decreaseQuantity({{ $product->id }})">-</button>
                        <input type="number" id="quantity-{{ $product->id }}" class="form-control mx-2" value="0" min="0" style="width: 50px; text-align: center;" onchange="syncQuantity({{ $product->id }})">
                        <button type="button" class="btn btn-quantity" onclick="increaseQuantity({{ $product->id }})">+</button>
                    </div>
                    
                    {{-- Input tersembunyi untuk form (TIDAK BERUBAH) --}}
                    <input type="hidden" name="products[{{ $product->id }}][quantity]" id="quantity-{{ $product->id }}-hidden" value="0">
                </li>
            @endforeach
        </ul>

        <div class="checkout-panel">
            <h3 class="text-center mb-4">Selesaikan Pesanan Anda</h3>
            <div class="d-grid col-md-6 mx-auto">
                <button id="submit-button" type="submit" class="btn btn-custom-yellow btn-lg py-2 fs-5">Lanjutkan ke Konfirmasi</button>
            </div>
        </div>
    </form>
</div>
@endsection

{{-- SCRIPT ASLI ANDA, TANPA PERUBAHAN FUNGSI SAMA SEKALI --}}
@push('scripts')
<script>
    function increaseQuantity(productId) {
        let quantityInput = document.getElementById('quantity-' + productId);
        let hiddenInput = document.getElementById('quantity-' + productId + '-hidden');
        quantityInput.value = parseInt(quantityInput.value) + 1;
        hiddenInput.value = quantityInput.value;
    }

    function decreaseQuantity(productId) {
        let quantityInput = document.getElementById('quantity-' + productId);
        let hiddenInput = document.getElementById('quantity-' + productId + '-hidden');
        if (parseInt(quantityInput.value) > 0) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
            hiddenInput.value = quantityInput.value;
        }
    }

    function syncQuantity(productId) {
        let quantityInput = document.getElementById('quantity-' + productId);
        let hiddenInput = document.getElementById('quantity-' + productId + '-hidden');
        if (parseInt(quantityInput.value) >= 0) {
             hiddenInput.value = quantityInput.value;
        } else {
            quantityInput.value = 0;
            hiddenInput.value = 0;
        }
    }

    // Script untuk memberikan feedback saat tombol diklik
    document.getElementById('order-form').addEventListener('submit', function() {
        var submitButton = document.getElementById('submit-button');
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
    });
</script>
@endpush
