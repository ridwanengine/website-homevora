<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'InteriorShop - Furniture & Dekorasi Rumah')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- favicon --}}
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        .logo-nav {
            height: 35px;
            margin-right: 8px;
        }

        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: white !important;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: #2c3e50 !important;
        }

        .navbar-brand span {
            color: #866347;
        }

        .nav-link {
            font-weight: 500;
            color: #2c3e50 !important;
            transition: 0.3s;
        }

        .nav-link:hover {
            color: #987456 !important;
        }

        .btn-orange {
            background-color: #987456;
            color: white;
            border-radius: 25px;
            padding: 8px 20px;
            transition: 0.3s;
        }

        .btn-orange:hover {
            background-color: #CEACA1;
            color: rgb(0, 0, 0);
        }

        .search-box {
            border-radius: 25px;
            border: 1px solid #ddd;
            padding: 8px 15px;
        }

        .search-box:focus {
            border-color: #478655;
            box-shadow: none;
        }

        .cart-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 50px;
            background: linear-gradient(135deg, #ffffff, #f7f7f7);
            border: 1px solid #e5e5e5;
            color: #333;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.25s ease;
            position: relative;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .cart-pill i {
            font-size: 18px;
        }

        .cart-pill:hover {
            background: #987456;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .cart-count {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #ff3b3b;
            color: #fff;
            font-size: 11px;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
            border: 2px solid #fff;
        }

        /* Footer */
        .footer-custom {
            background: linear-gradient(135deg, #111827, #1f2937);
            color: white;
        }

        .footer-title {
            font-weight: 600;
            margin-bottom: 18px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            text-decoration: none;
            color: #cbd5e1;
            transition: .3s;
        }

        .footer-links a:hover {
            color: #ffffff;
            padding-left: 6px;
        }

        .social-icons a {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, .08);
            color: white;
            border-radius: 50%;
            margin-right: 10px;
            transition: .3s;
            text-decoration: none;
        }

        .social-icons a:hover {
            background: #ffffff;
            color: #111827;
            transform: translateY(-4px);
        }

        .text-light-emphasis {
            color: #cbd5e1 !important;
        }
    </style>

    @stack('styles')
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('Home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-nav">
                Home<span>Vora</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('Home') ? 'active' : '' }}" href="{{ route('Home') }}">
                            <i class="bi bi-house-door"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('produk.index') }}">
                            <i class="bi bi-box-seam"></i> Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">
                            <i class="bi bi-info-circle"></i> Tentang
                        </a>
                    </li>
                </ul>

                <form class="d-flex me-3" method="GET" action="{{ route('products.search') }}">

                    <input class="form-control search-box" type="search" name="search"
                        placeholder="Cari furniture...">

                    <button class="btn btn-orange ms-2" type="submit">
                        <i class="bi bi-search"></i>
                    </button>

                </form>

                <div class="d-flex gap-3 align-items-center">

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="cart-pill position-relative">
                        <i class="bi bi-cart3"></i>
                        <span>Cart</span>
                    </a>

                    @auth
                        <!-- Jika SUDAH LOGIN -->
                        <a href="{{ route('Profil') }}" class="cart-pill d-flex align-items-center gap-2">
                            <i class="bi bi-person-circle fs-5"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                    @else
                        <!-- Jika BELUM LOGIN -->
                        <a href="{{ route('login') }}" class="cart-pill">
                            <i class="bi bi-person"></i>
                            <span>Login</span>
                        </a>
                    @endauth

                </div>


            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-custom pt-5 pb-3">
        <div class="container">
            <div class="row gy-4">

                <!-- Brand -->
                <div class="col-lg-7">
                    <h4 class="fw-bold mb-3">
                        <i class="bi bi-house-heart-fill me-2"></i>HomeVora
                    </h4>

                    <p class="text-light-emphasis">
                        Menyediakan furniture dan dekorasi rumah berkualitas
                        untuk membantu menciptakan ruangan impian Anda dengan
                        desain modern dan elegan.
                    </p>

                    <div class="social-icons mt-4">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                        <a href="#"><i class="bi bi-pinterest"></i></a>
                    </div>
                </div>

                <!-- Navigasi -->
                <div class="col-lg-2">
                    <h6 class="footer-title">Navigasi</h6>

                    <ul class="footer-links">
                        <li><a href="/">Beranda</a></li>
                        <li><a href="/produk">Produk</a></li>
                        <li><a href="/about">Tentang Kami</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div class="col-lg-3">
                    <h6 class="footer-title">Hubungi Kami</h6>

                    <ul class="footer-links">
                        <li>
                            <i class="bi bi-geo-alt-fill me-2"></i>
                            Palopo, Indonesia
                        </li>

                        <li>
                            <i class="bi bi-envelope-fill me-2"></i>
                            info@homevora.com
                        </li>

                        <li>
                            <i class="bi bi-telephone-fill me-2"></i>
                            (021) 1234-5678
                        </li>
                    </ul>
                </div>

            </div>

            <hr class="border-secondary my-4">

            <div class="text-center small">
                © {{ date('Y') }} HomeVora • All Rights Reserved
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            confirmButtonColor: '#866347'
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: "{{ session('error') }}",
            confirmButtonColor: '#866347'
        });
    </script>
@endif

</html>
