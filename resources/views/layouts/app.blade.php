<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Warkop Digital') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root { --main-red: #A91D3A; --accent-yellow: #FFC107; --dark-bg: #1a1a1a; --card-bg: #2b2b2b; --text-light: #f8f9fa; --text-muted-custom: #adb5bd; }
        body { background-color: var(--dark-bg); color: var(--text-light); font-family: 'Roboto', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; color: var(--accent-yellow); font-weight: 700; }
        .navbar-custom { background-color: var(--main-red); padding-top: 1rem; padding-bottom: 1rem; border-bottom: 4px solid var(--accent-yellow); }
        .navbar-custom .navbar-brand { font-family: 'Poppins', sans-serif; color: #ffffff; font-size: 1.75rem; }
        .navbar-custom .navbar-brand:hover { color: var(--accent-yellow); }
        .navbar-custom .nav-link { color: #ffffff; font-weight: 500; }
        .navbar-custom .nav-link:hover { color: var(--accent-yellow); }
        .btn-custom-yellow { background-color: var(--accent-yellow); color: #000000; font-weight: 500; border: none; transition: all 0.3s ease; }
        .btn-custom-yellow:hover { background-color: #ffca2c; color: #000000; transform: translateY(-2px); }
        .footer-custom { background-color: var(--main-red); color: white; padding: 1.5rem 0; margin-top: 4rem; text-align: center; }

       .product-card {
    background-color: var(--card-bg);
    border: 1px solid #444; /* Garis batas tipis untuk definisi */
    border-radius: 15px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%; /* Memastikan kartu memiliki tinggi yang sama dalam satu baris */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.product-card:hover {
    transform: translateY(-10px);
    border-color: var(--accent-yellow);
    box-shadow: 0 12px 35px rgba(255, 193, 7, 0.15);
}

.product-card .card-img-wrapper {
    overflow: hidden; /* Penting untuk efek zoom */
}

.product-card .card-img-top {
    border-bottom: 3px solid var(--accent-yellow);
    transition: transform 0.4s ease-in-out;
}

.product-card:hover .card-img-top {
    transform: scale(1.08);
}

.product-card .card-body {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    flex-grow: 1; /* Membuat body kartu mengisi sisa ruang */
}

.product-card .card-title {
    color: var(--accent-yellow);
    font-size: 1.5rem;
}

.product-card .card-text {
    color: var(--text-muted-custom);
    flex-grow: 1; /* Mendorong harga ke bagian bawah */
}

.product-card .price-text {
    font-family: 'Poppins', sans-serif;
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--text-light);
    margin-top: auto; /* Selalu menempel di bawah */
}

.product-card .price-text .price-value {
    color: var(--accent-yellow);
}
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Warkop Digital</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                        <li class="nav-item me-2">
                            <a class="nav-link" href="{{ route('login') }}">Login / Register</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Halo, {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->hasRole('admin'))
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                    
                    {{-- ================= PERBAIKAN DI SINI ================= --}}
                    {{-- Tampilkan tombol ini jika user adalah tamu ATAU user yang login bukan admin --}}
                    @if(Auth::guest() || !Auth::user()->hasRole('admin'))
                        <li class="nav-item ms-lg-3">
                            {{-- Link ini selalu ke 'pesan'. Laravel akan otomatis redirect ke login jika perlu --}}
                            <a href="{{ route('pesan') }}" class="btn btn-custom-yellow">Pesan Sekarang</a>
                        </li>
                    @endif
                    {{-- ====================================================== --}}
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <footer class="footer-custom">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Warkop Digital. Semua Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
