@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1>Edit Menu: {{ $product->name }}</h1>

    <div class="card product-card">
        <div class="card-body p-4">
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

            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Menu</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" required step="500">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar Menu Baru (Opsional)</label>
                    <input class="form-control" type="file" id="image" name="image">
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                    @if ($product->image)
                        <div class="mt-2">
                            <p>Gambar saat ini:</p>
                            <img src="{{ asset('storage/products/' . $product->image) }}" alt="Current Image" style="width: 150px; height: auto; border-radius: 8px;">
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Perbarui Menu</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection