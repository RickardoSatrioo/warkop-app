@extends('layouts.app')

{{-- Menambahkan sedikit CSS untuk styling dan animasi form --}}
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
    <h1 class="mb-4">Tambah Menu Baru</h1>

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

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    {{-- PERBAIKAN: Gaya Label --}}
                    <label for="name" class="form-label styled">Nama Menu</label>
                    {{-- PERBAIKAN: Gaya Input --}}
                    <input type="text" class="form-control dark-input" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label styled">Deskripsi</label>
                    <textarea class="form-control dark-input" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label styled">Harga</label>
                    <input type="number" class="form-control dark-input" id="price" name="price" value="{{ old('price') }}" required step="500">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label styled">Gambar Menu</label>
                    <input class="form-control dark-input" type="file" id="image" name="image">
                </div>

                {{-- PERBAIKAN: Posisi dan warna tombol --}}
                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Menu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection