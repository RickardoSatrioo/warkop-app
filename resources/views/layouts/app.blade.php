<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Warkop Digital</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <!-- Menampilkan tombol Login atau Nama Pengguna -->
                @guest
                    <!-- Jika belum login, tampilkan tombol Login -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                @else
                    <!-- Jika sudah login, tampilkan nama pengguna -->
                    <li class="nav-item">
                        <span class="nav-link">Halo, {{ Auth::user()->name }}</span>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>

    <!-- Konten Halaman -->
    <div class="container mt-4">
        @yield('content')  <!-- Konten halaman lainnya akan dimasukkan di sini -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
