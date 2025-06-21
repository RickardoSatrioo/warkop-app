@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card product-card">
                <div class="card-body p-4 p-md-5">
                    <h1 class="text-center mb-4">Edit Profil</h1>

                    {{-- Menampilkan pesan sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Menampilkan pesan error validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        {{-- Nama Lengkap --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold" style="color: var(--accent-yellow);">Nama Lengkap</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required style="background-color: #3a3a3a; color: white; border-color: #555;">
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold" style="color: var(--accent-yellow);">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required style="background-color: #3a3a3a; color: white; border-color: #555;">
                        </div>

                        {{-- Nomor Telepon --}}
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold" style="color: var(--accent-yellow);">Nomor Telepon</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required style="background-color: #3a3a3a; color: white; border-color: #555;">
                        </div>

                        {{-- Alamat --}}
                        <div class="mb-3">
                            <label for="address" class="form-label fw-bold" style="color: var(--accent-yellow);">Alamat</label>
                            <textarea id="address" name="address" class="form-control" required style="background-color: #3a3a3a; color: white; border-color: #555; height: 100px;">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <hr class="my-4" style="border-color: #444;">
                        
                        <p style="color: var(--text-muted-custom);">Isi bagian di bawah ini hanya jika Anda ingin mengubah kata sandi.</p>
                        
                        {{-- Kata Sandi Baru --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold" style="color: var(--accent-yellow);">Kata Sandi Baru</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan kata sandi baru" style="background-color: #3a3a3a; color: white; border-color: #555;">
                        </div>

                        {{-- Konfirmasi Kata Sandi Baru --}}
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-bold" style="color: var(--accent-yellow);">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ketik ulang kata sandi baru" style="background-color: #3a3a3a; color: white; border-color: #555;">
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="mt-4 d-flex justify-content-end gap-2">
                             <a href="{{ route('dashboard') }}" class="btn btn-secondary">Batal</a>
                             <button type="submit" class="btn btn-custom-yellow">Perbarui Profil</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection