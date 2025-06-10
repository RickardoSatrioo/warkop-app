@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Halaman Pesan</h1>
    <p>Berikut adalah produk yang dapat Anda pesan:</p>

    <ul class="list-group">
        @foreach ($products as $product)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <h5>{{ $product->name }}</h5>
                    <p>{{ $product->description }}</p>
                </div>
                <span class="badge bg-primary rounded-pill">Rp{{ number_format($product->price, 2, ',', '.') }}</span>

                <!-- Tombol pengatur jumlah -->
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-outline-secondary" onclick="decreaseQuantity({{ $product->id }})">-</button>
                    <input type="number" id="quantity-{{ $product->id }}" class="form-control mx-2" value="0" min="0" style="width: 60px; text-align: center;" onchange="syncQuantity({{ $product->id }})">
                    <button type="button" class="btn btn-outline-secondary" onclick="increaseQuantity({{ $product->id }})">+</button>
                </div>
            </li>
        @endforeach
    </ul>

    <!-- Form pesanan -->
    <form action="{{ route('create-order') }}" method="POST">
        @csrf
        @foreach ($products as $product)
            <input type="hidden" name="products[{{ $product->id }}][id]" value="{{ $product->id }}">
            <input type="hidden" name="products[{{ $product->id }}][quantity]" id="quantity-{{ $product->id }}-hidden" value="0">
        @endforeach
        <button type="submit" class="btn btn-success mt-4">Buat Pesanan</button>
    </form>

    <!-- Script sinkronisasi jumlah -->
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
            hiddenInput.value = quantityInput.value;
        }
    </script>
</div>
@endsection
