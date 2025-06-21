@extends('layouts.app')

@section('content')
<div class="container my-5">
    <header class="text-center mb-5">
        <h1>Dashboard Pemilik</h1>
        <p class="lead" style="color: var(--text-muted-custom);">Ringkasan penjualan dan performa Warkop Digital.</p>
    </header>

    {{-- Kartu Ringkasan --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card product-card h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Pendapatan Hari Ini</h5>
                    <p class="display-5 fw-bold" style="color: var(--text-light);">Rp{{ number_format($pendapatanHariIni, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card product-card h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Transaksi Sukses Hari Ini</h5>
                    <p class="display-5 fw-bold" style="color: var(--text-light);">{{ $transaksiHariIni }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card product-card h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Pendapatan</h5>
                    <p class="display-5 fw-bold" style="color: var(--text-light);">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik Penjualan --}}
    <div class="card product-card mb-5">
        <div class="card-body p-4">
            <h4 class="card-title mb-3">Grafik Penjualan (7 Hari Terakhir)</h4>
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    {{-- Laporan Transaksi Terakhir --}}
    <div class="card product-card">
        <div class="card-body p-4">
            <h4 class="card-title mb-3">10 Transaksi Terakhir</h4>
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Kode Pesanan</th>
                            <th>Pemesan</th>
                            <th>Total Belanja</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentTransactions as $code => $orders)
                            <tr>
                                <td>#{{ $code }}</td>
                                <td>{{ $orders->first()->user->name ?? 'N/A' }}</td>
                                <td>Rp{{ number_format($orders->sum(fn($o) => $o->price * $o->quantity), 0, ',', '.') }}</td>
                                <td><span class="badge bg-success">{{ ucfirst($orders->first()->status) }}</span></td>
                                <td>{{ $orders->first()->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
{{-- Sertakan library Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart');

    new Chart(ctx, {
        type: 'line', // Tipe grafik: garis
        data: {
            labels: {!! json_encode($chartLabels) !!}, // Label dari controller
            datasets: [{
                label: 'Pendapatan',
                data: {!! json_encode($chartData) !!}, // Data dari controller
                backgroundColor: 'rgba(255, 193, 7, 0.2)',
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 2,
                tension: 0.3, // Membuat garis sedikit melengkung
                fill: true,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#fff' // Warna teks di sumbu Y
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)' // Warna garis grid
                    }
                },
                x: {
                    ticks: {
                        color: '#fff' // Warna teks di sumbu X
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: '#fff' // Warna teks legenda
                    }
                }
            }
        }
    });
</script>
@endpush