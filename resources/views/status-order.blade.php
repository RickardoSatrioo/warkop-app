@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            {{-- Menggunakan style card yang konsisten dengan tema --}}
            <div class="card product-card text-center p-4 p-md-5">
                <div class="card-body">
                    
                    {{-- Icon Ceklis untuk feedback visual --}}
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="var(--accent-yellow)" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                    </div>

                    <h1 class="card-title">Pembayaran Berhasil!</h1>
                    <p class="lead mt-3" style="color: var(--text-muted-custom);">
                        Terima kasih telah melakukan pemesanan. Pesanan Anda sedang kami proses dan akan segera kami siapkan.
                    </p>

                    <div class="mt-5">
                        <a href="{{ route('dashboard') }}" class="btn btn-custom-yellow btn-lg">Kembali ke Menu Utama</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection