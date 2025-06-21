@extends('layouts.app')

{{-- Menambahkan CSS untuk styling dan animasi form yang konsisten --}}
@push('styles')
<style>
    .form-control.dark-input, .form-select.dark-input {
        background-color: #3a3a3a;
        color: white;
        border-color: #555;
        transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .form-control.dark-input:focus, .form-select.dark-input:focus {
        background-color: #4a4a4a;
        color: white;
        border-color: var(--accent-yellow);
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
    }
    .form-label.styled {
        color: var(--accent-yellow);
        font-weight: 500;
    }
</style>
@endpush

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Edit Menu: {{ $product->name }}</h1>

    <div class="card product-card">
        <div class="card-body p-4 p-md-5">
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
                    <label for="name" class="form-label styled">Nama Menu</label>
                    <input type="text" class="form-control dark-input" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label styled">Deskripsi</label>
                    <textarea class="form-control dark-input" id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label styled">Harga</label>
                    <input type="number" class="form-control dark-input" id="price" name="price" value="{{ old('price', $product->price) }}" required step="500">
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label styled">Gambar Menu Baru (Opsional)</label>
                    <input class="form-control dark-input" type="file" id="image" name="image">
                    <small class="form-text" style="color: var(--text-muted-custom);">Kosongkan jika tidak ingin mengganti gambar.</small>
                    @if ($product->image)
                        <div class="mt-3">
                            <p class="styled mb-2">Gambar saat ini:</p>
                            <img src="{{ asset('storage/products/' . $product->image) }}" alt="Current Image" style="width: 150px; height: auto; border-radius: 8px;">
                        </div>
                    @endif
                </div>
                
                <div class="mt-4 d-flex justify-content-between">
                    {{-- Tombol Hapus di kiri --}}
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('delete-form').submit();">
                        Hapus Menu
                    </button>
                    {{-- Tombol Simpan & Batal di kanan --}}
                    <div>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>

            {{-- Form tersembunyi khusus untuk aksi Hapus --}}
            <form id="delete-form" action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-none" onsubmit="return confirm('Apakah Anda benar-benar yakin ingin menghapus menu ini secara permanen?');">
                @csrf
                @method('DELETE')
            </form>

        </div>
    </div>
</div>
@endsection