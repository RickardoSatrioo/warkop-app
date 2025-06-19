@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">

            {{-- Menggunakan class 'product-card' yang sudah kita desain sebelumnya --}}
            <div class="card product-card">
                
                {{-- Menggunakan padding yang lebih besar di dalam kartu --}}
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        {{-- Mengganti header standar dengan heading yang lebih menarik --}}
                        <h2 class="mb-0">Selamat Datang Kembali!</h2>
                        <p style="color: var(--text-muted-custom);">Silakan login untuk melanjutkan</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            {{-- Menambahkan validasi error di input --}}
                            <input type="email" id="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" required value="{{ old('email') }}" placeholder="contoh@email.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required placeholder="Masukkan password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid">
                            {{-- Mengganti class tombol agar sesuai dengan tema --}}
                            <button type="submit" class="btn btn-custom-yellow btn-lg">Login</button>
                        </div>

                        <div class="text-center mt-4">
                            <p style="color: var(--text-muted-custom);">
                                Belum punya akun? 
                                {{-- Menggunakan class 'text-warning' dari Bootstrap untuk warna kuning --}}
                                <a href="{{ route('register') }}" class="fw-bold text-decoration-none text-warning">Daftar di sini</a>
                            </p>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection