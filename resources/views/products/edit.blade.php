@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Produk: {{ $product->name }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH') {{-- Atau 'PUT'. Penting untuk form update! --}}

        <div class="mb-3">
            <label for="name" class="form-label">Nama Produk</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" required>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Gambar Produk</label>
            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image">
            <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            {{-- Tampilkan gambar yang ada saat ini --}}
            @if ($product->image)
                <div class="mt-2">
                    <p>Gambar saat ini:</p>
                    <img src="{{ asset('storage/products/' . $product->image) }}" alt="Current Image" style="width: 150px; height: auto;">
                </div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Perbarui Produk</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection