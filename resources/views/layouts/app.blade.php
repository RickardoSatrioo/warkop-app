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
        /* Variabel Warna untuk kemudahan kustomisasi */
        :root {
            --main-red: #A91D3A; /* Merah Tua */
            --accent-yellow: #FFC107; /* Kuning Keemasan */
            --dark-bg: #1a1a1a; /* Abu-abu Sangat Gelap */
            --card-bg: #2b2b2b; /* Abu-abu Gelap untuk Kartu */
            --text-light: #f8f9fa;
            --text-muted-custom: #adb5bd;
        }

        /* Body & Tipografi Dasar */
        body {
            background-color: var(--dark-bg);
            color: var(--text-light);
            font-family: 'Roboto', sans-serif;
        }

        /* Kustomisasi Heading */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            color: var(--accent-yellow);
            font-weight: 700;
        }

        /* Navbar Kustom */
        .navbar-custom {
            background-color: var(--main-red);
            padding-top: 1rem;
            padding-bottom: 1rem;
            border-bottom: 4px solid var(--accent-yellow);
        }
        .navbar-custom .navbar-brand {
            font-family: 'Poppins', sans-serif;
            color: #ffffff;
            font-size: 1.75rem;
        }
        .navbar-custom .navbar-brand:hover {
            color: var(--accent-yellow);
        }
        .navbar-custom .nav-link {
            color: #ffffff;
            font-weight: 500;
        }
        .navbar-custom .nav-link:hover {
            color: var(--accent-yellow);
        }

        /* Tombol Kustom */
        .btn-custom-yellow {
            background-color: var(--accent-yellow);
            color: #000000;
            font-weight: 500;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-custom-yellow:hover {
            background-color: #ffca2c;
            color: #000000;
            transform: translateY(-2px);
        }

        .btn-custom-outline {
            border: 2px solid var(--accent-yellow);
            color: var(--accent-yellow);
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-custom-outline:hover {
            background-color: var(--accent-yellow);
            color: #000000;
        }

        /* Kartu Menu Produk */
        .product-card {
            background-color: var(--card-bg);
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }
        .product-card .card-img-top {
            border-bottom: 3px solid var(--accent-yellow);
            transition: transform 0.3s ease;
        }
        .product-card:hover .card-img-top {
            transform: scale(1.05);
        }
        .product-card .card-body {
            padding: 1.5rem;
        }
        .product-card .card-title {
            color: var(--accent-yellow); /* Judul Kartu */
            font-size: 1.5rem;
        }
        .product-card .card-text {
            color: var(--text-muted-custom);
        }
        .product-card .price-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: #ffffff;
        }
        .product-card .price-text b {
            color: var(--accent-yellow);
        }
        
        /* Footer Kustom */
        .footer-custom {
            background-color: var(--main-red);
            color: white;
            padding: 1.5rem 0;
            margin-top: 4rem;
            text-align: center;
        }

        /* File: resources/views/layouts/app.blade.php */
/* TAMBAHKAN CSS INI DI DALAM TAG <style> YANG SUDAH ADA */

/* Panel untuk setiap item di halaman pesan */
.order-item {
    background-color: var(--card-bg);
    border-radius: 15px;
    padding: 1rem 1.5rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    transition: background-color 0.3s ease;
}
.order-item:hover {
    background-color: #3a3a3a;
}

/* Gambar thumbnail produk di halaman pesan */
.order-item-img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 10px;
    border: 2px solid var(--accent-yellow);
}

/* Pengatur Kuantitas (+/-) */
.quantity-selector .form-control {
    background-color: transparent;
    border: none;
    border-bottom: 2px solid var(--text-muted-custom);
    color: #ffffff;
    border-radius: 0;
    box-shadow: none;
    padding-left: 0;
    padding-right: 0;
}
.quantity-selector .form-control:focus {
    border-color: var(--accent-yellow);
}

.quantity-selector .btn-quantity {
    background-color: var(--accent-yellow);
    color: #000;
    border: none;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
}
.quantity-selector .btn-quantity:hover {
    background-color: #ffca2c;
    color: #000;
}

/* Panel Checkout Terakhir */
.checkout-panel {
    background-color: var(--card-bg);
    border-radius: 15px;
    padding: 2rem;
    margin-top: 3rem;
    border-top: 4px solid var(--main-red);
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
                        <li class="nav-item">
                            <a href="{{ route('pesan') }}" class="btn btn-custom-yellow">Pesan Sekarang</a>
                        </li>
                    @else
                        <li class="nav-item me-2">
                            <a href="{{ route('profile.edit') }}" class="btn btn-custom-outline">
                                Halo, {{ Auth::user()->name }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pesan') }}" class="btn btn-custom-yellow">
                                Pesan Sekarang
                            </a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer-custom">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Warkop Digital. Semua Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>