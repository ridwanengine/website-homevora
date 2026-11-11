@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

    <style>
        /* ================= HERO SECTION ================= */
        .hero-section {
            background: url("{{ asset('images/background home.jpg') }}") center/cover no-repeat;
            padding: 120px 0;
            color: white;
            position: relative;
        }

        .hero-section::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
        }

        .hero-section .container {
            position: relative;
            z-index: 2;
        }

        /* ================= FEATURES FLOATING ================= */
        .features-section {
            margin-top: -55px;
            position: relative;
            z-index: 5;
            background: transparent;
        }

        .features-wrapper {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 25px;
            box-shadow:
                0 10px 40px rgba(0, 0, 0, 0.08),
                0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .feature-box {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 18px;
            border-radius: 20px;
            transition: .35s ease;
            height: 100%;
        }

        .feature-box:hover {
            transform: translateY(-8px);
            background: #fff7f2;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
        }

        .feature-icon {
            min-width: 60px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            flex-shrink: 0;
        }

        /* warna beda tiap icon */
        .icon1 {
            background: linear-gradient(135deg, #ff8a00, #ff5e62);
        }

        .icon2 {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
        }

        .icon3 {
            background: linear-gradient(135deg, #43e97b, #38f9d7);
        }

        .icon4 {
            background: linear-gradient(135deg, #f7971e, #ffd200);
        }

        .feature-title {
            font-size: 15px;
            font-weight: 700;
            color: #222;
            margin-bottom: 5px;
        }

        .feature-text {
            font-size: 13px;
            color: #666;
            line-height: 1.5;
        }

        @media(max-width:768px) {

            .features-section {
                margin-top: 20px;
            }

            .feature-box {
                margin-bottom: 15px;
            }

        }

        /* ================= PRODUCT ================= */
        .product-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            background: #fff;
            transition: 0.3s ease;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.12);
        }

        .product-img {
            height: 220px;
            object-fit: cover;
            width: 100%;
        }

        .product-content {
            padding: 16px;
        }

        .product-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #111;
            text-decoration: none;
            display: inline-block;
        }

        .product-price {
            font-size: 22px;
            font-weight: 700;
            color: #987456;
            margin-bottom: 10px;
        }

        .product-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #555;
            font-size: 13px;
        }

        .sold-text {
            color: #444;
        }

        @media (max-width: 768px) {
            .product-img {
                height: 180px;
            }

            .product-title {
                font-size: 15px;
            }

            .product-price {
                font-size: 18px;
            }

            .product-info {
                font-size: 12px;
            }
        }

        /* ================= PROMO ================= */
        .banner-promo {
            background: linear-gradient(120deg, #f093fb 0%, #f5576c 100%);
            border-radius: 20px;
            padding: 50px;
            color: white;
        }

        /* ================= TESTIMONIAL ================= */
        .testimonial-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin: 10px;
            text-align: center;
        }

        .testimonial-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>


    <!-- ================= HERO ================= -->
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-4 fw-bold mb-3">
                        Temukan Furniture Impian Anda
                    </h1>

                    <p class="lead mb-4">
                        Dekorasi rumah berkualitas dengan desain modern dan harga terjangkau.
                        Wujudkan ruangan impian Anda bersama InteriorShop.
                    </p>

                    <a href="{{ url('produk') }}" class="btn btn-light btn-lg rounded-pill px-4">
                        Belanja Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= FEATURES ================= -->
    <div class="features-section">

        <div class="container">

            <div class="features-wrapper">

                <div class="row">

                    <!-- 1 -->
                    <div class="col-md-3 col-6 mb-3">

                        <div class="feature-box">

                            <div class="feature-icon icon1">
                                <i class="bi bi-house-heart-fill"></i>
                            </div>

                            <div>
                                <div class="feature-title">
                                    Interior Modern
                                </div>

                                <div class="feature-text">
                                    Furniture premium dengan desain modern
                                    untuk ruangan yang elegan.
                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- 2 -->
                    <div class="col-md-3 col-6 mb-3">

                        <div class="feature-box">

                            <div class="feature-icon icon2">
                                <i class="bi bi-patch-check-fill"></i>
                            </div>

                            <div>

                                <div class="feature-title">
                                    Kualitas Premium
                                </div>

                                <div class="feature-text">
                                    Material terbaik, tahan lama,
                                    kuat dan nyaman digunakan.
                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- 3 -->
                    <div class="col-md-3 col-6 mb-3">

                        <div class="feature-box">

                            <div class="feature-icon icon3">
                                <i class="bi bi-truck"></i>
                            </div>

                            <div>

                                <div class="feature-title">
                                    Pengiriman Cepat
                                </div>

                                <div class="feature-text">
                                    Produk dikirim aman dengan
                                    pengemasan terbaik.
                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- 4 -->
                    <div class="col-md-3 col-6 mb-3">

                        <div class="feature-box">

                            <div class="feature-icon icon4">
                                <i class="bi bi-cash-coin"></i>
                            </div>

                            <div>

                                <div class="feature-title">
                                    Harga Terjangkau
                                </div>

                                <div class="feature-text">
                                    Produk berkualitas dengan
                                    promo menarik setiap saat.
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- ================= PROMO ================= -->
    <div class="container my-5">
        <div class="banner-promo">
            <div class="row align-items-center">

                <div class="col-md-8">
                    <h3 class="fw-bold">Diskon hingga 50%</h3>
                    <p class="mb-0">
                        Untuk pembelian pertama minimal belanja Rp 500.000
                    </p>
                </div>

            </div>
        </div>
    </div>


    <!-- ================= PRODUCTS ================= -->
    <div class="container my-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Produk Terbaru</h2>

            <a href="{{ url('/produk') }}" class="text-decoration-none">
                Lihat Semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="row g-4">

            @forelse($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">

                    <div class="card product-card h-100">

                        <a href="{{ url('/produk/' . $product->id) }}">
                            <img src="{{ asset('storage/' . $product->image) }}" class="product-img"
                                alt="{{ $product->name }}">
                        </a>

                        <div class="product-content">

                            <div class="product-title">
                                {{ strtolower($product->name) }}
                            </div>

                            <div class="product-price">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>

                            <div class="product-info">
                                <span>Stok: {{ $product->stock }}</span>

                                <span>
                                    {{ $product->order_items_sum_jumlah ?? 0 }} Terjual
                                </span>
                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12 text-center">
                    Belum ada produk terbaru
                </div>
            @endforelse

        </div>

    </div>


    <!-- ================= NEWSLETTER ================= -->
    <div class="container my-5">
        <div class="bg-light rounded-4 p-5 text-center">

            <h3 class="fw-bold mb-3">
                Dapatkan Penawaran Menarik
            </h3>

            <p class="mb-4">
                Berlangganan newsletter untuk mendapatkan kupon diskon dan info produk terbaru
            </p>

            <div class="row justify-content-center">

                <div class="col-md-6">

                    <div class="input-group">

                        <input type="email" class="form-control form-control-lg" placeholder="Email Anda">

                        <button class="btn btn-orange btn-lg">
                            Berlangganan
                        </button>

                    </div>

                </div>
            </div>

        </div>
    </div>


    <script>
        document.querySelectorAll(".add-to-cart").forEach(button => {

            button.addEventListener("click", function(e) {

                e.preventDefault();

                let productId = this.dataset.id;

                fetch("/cart/add", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            id: productId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert("Produk berhasil masuk keranjang");
                    });

            });

        });
    </script>
@endsection
