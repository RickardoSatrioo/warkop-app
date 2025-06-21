@extends('layouts.app')

@push('styles')
<style>
    .status-tracker-container {
        padding: 2rem 0;
    }

    .status-tracker {
        display: flex;
        justify-content: space-between;
        position: relative;
    }

    /* Garis Latar Belakang (Abu-abu) */
    .status-tracker::before {
        content: '';
        position: absolute;
        top: 20px; /* Posisi vertikal di tengah dot */
        left: 0;
        right: 0;
        height: 4px;
        background-color: #444; /* Warna garis yang belum aktif */
        transform: translateY(-50%);
        z-index: 1;
    }

    /* Garis Progres (Kuning) */
    .tracker-progress {
        position: absolute;
        top: 20px;
        left: 0;
        height: 4px;
        background-color: var(--accent-yellow); /* Warna progres aktif */
        z-index: 2;
        transform: translateY(-50%);
        transition: width 0.5s ease-in-out;
    }

    .status-step {
        position: relative;
        z-index: 3;
        text-align: center;
        width: 25%; /* Bagian yang sama untuk setiap step */
    }

    .status-dot {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #444; /* Warna dot belum aktif */
        color: var(--text-muted-custom);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid var(--card-bg); /* Memberi efek "terpotong" pada garis */
        margin: 0 auto 15px;
        font-weight: bold;
        transition: all 0.4s ease;
    }

    /* Style untuk dot yang sedang aktif atau sudah selesai */
    .status-step.active .status-dot,
    .status-step.completed .status-dot {
        background-color: var(--accent-yellow);
        color: #000;
    }
    
    .status-label {
        font-size: 0.9rem;
        color: var(--text-muted-custom);
        font-weight: 500;
    }
    
    .status-step.active .status-label,
    .status-step.completed .status-label {
        color: var(--text-light);
    }
</style>
@endpush

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-9">
            <div class="card product-card text-center p-4 p-md-5">
                <div class="card-body">
                    <h1 class="card-title">Status Pesanan Anda</h1>
                    <p class="lead" style="color: var(--text-muted-custom);">
                        Pesanan #{{ $orders->first()->order_code }}
                    </p>

                    @php
                        // Daftar semua kemungkinan status
                        $statuses = ['menunggu konfirmasi', 'di masak', 'di antar', 'selesai'];
                        // Status pesanan saat ini
                        $currentStatus = $orders->first()->status;
                        // Cari index dari status saat ini
                        $currentIndex = array_search($currentStatus, $statuses);
                        // Jika status tidak ditemukan (misal: dibatalkan), anggap saja di awal
                        $currentIndex = $currentIndex === false ? -1 : $currentIndex;

                        // Hitung lebar progress bar. (Total step - 1) untuk pembagian
                        $progressWidth = $currentIndex > 0 ? ($currentIndex / (count($statuses) - 1)) * 100 : 0;
                    @endphp

                    <div class="status-tracker-container">
                        <div class="status-tracker">
                            {{-- DIV BARU UNTUK GARIS PROGRES --}}
                            <div class="tracker-progress" style="width: {{ $progressWidth }}%;"></div>
                            
                            @foreach ($statuses as $index => $status)
                                @php
                                    $stepClass = '';
                                    if ($index < $currentIndex) {
                                        $stepClass = 'completed'; // Status sudah dilewati
                                    } elseif ($index == $currentIndex) {
                                        $stepClass = 'active'; // Status saat ini
                                    }
                                @endphp
                                <div class="status-step {{ $stepClass }}">
                                    <div class="status-dot">
                                        {{-- Jika status sudah selesai, tampilkan ikon ceklis --}}
                                        @if($index < $currentIndex || ($status == 'selesai' && $currentIndex >= $index))
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z"/>
                                            </svg>
                                        @else
                                            {{-- Jika belum, tampilkan angka --}}
                                            {{ $index + 1 }}
                                        @endif
                                    </div>
                                    <div class="status-label">{{ ucfirst($status) }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4 style="color: var(--accent-yellow);">Rincian Pesanan</h4>
                        <ul class="list-group list-group-flush text-start mt-3">
                            @foreach($orders as $order)
                            <li class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-center">
                                <span>{{ $order->product->name }} (x{{ $order->quantity }})</span>
                                <span>Rp{{ number_format($order->price * $order->quantity, 0, ',', '.') }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="mt-5">
                        <a href="{{ route('dashboard') }}" class="btn btn-custom-yellow btn-lg">Kembali ke Menu Utama</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection