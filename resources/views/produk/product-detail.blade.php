@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <style>
        body {
            background: #f8f9fa;
        }

        .product-wrapper {
            background: #fff;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .05);
        }

        .main-img {
            width: 100%;
            height: 420px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            transition: .3s;
        }

        .thumb-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: .2s;
        }

        .thumb-img:hover {
            border: 2px solid rgb(230, 104, 45);
            transform: scale(1.05);
        }

        .title {
            font-size: 22px;
            font-weight: 700;
        }

        .price {
            font-size: 26px;
            font-weight: 800;
            color: #987456;
        }

        .btn-cart {
            background: white;
            border: 1px solid #987456;
            color: #987456;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            transition: .3s;
        }

        .btn-cart:hover {
            background: #987456;
            color: #fff;
        }

        .btn-buy {
            background: #987456;
            border: none;
            color: #fff;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            transition: .3s;
        }

        .btn-buy:hover {
            background: #CEACA1;
        }

        .info-box {
            font-size: 14px;
            margin-bottom: 10px;
            color: #555;
        }

        .badge-star {
            background: orange;
            color: #fff;
            font-size: 12px;
            padding: 3px 8px;
            border-radius: 6px;
            margin-right: 5px;
        }

        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        /* notif */
        .toast-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;

            display: flex;
            justify-content: center;
            align-items: center;

            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(5px);

            z-index: 9999;
        }

        /* Box tengah */
        .toast-box {
            background: rgba(60, 60, 60, 0.95);
            color: #fff;
            padding: 25px 35px;
            border-radius: 12px;
            text-align: center;
            min-width: 280px;
        }

        /* Icon centang */
        .check-icon {
            width: 60px;
            height: 60px;
            background: #00b894;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 28px;
            color: #fff;
        }

        .image-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
        }

        .out-of-stock-overlay {
            position: absolute;
            inset: 0;

            background: rgba(0, 0, 0, .55);

            display: flex;
            justify-content: center;
            align-items: center;

            border-radius: 12px;
        }

        .overlay-content {
            text-align: center;
            color: white;
        }

        .overlay-content i {
            font-size: 60px;
            margin-bottom: 15px;
        }

        .overlay-content h3 {
            font-weight: 700;
            margin-bottom: 8px;
        }

        .overlay-content p {
            margin: 0;
            opacity: .9;
        }

        /* Tombol saat stok habis */
        .btn-cart:disabled,
        .btn-buy:disabled {
            background: #d9d9d9 !important;
            border: 1px solid #d9d9d9 !important;
            color: #888 !important;
            cursor: not-allowed;
            opacity: 1;
        }

        /* Hilangkan efek hover saat disabled */
        .btn-cart:disabled:hover,
        .btn-buy:disabled:hover {
            background: #d9d9d9 !important;
            color: #888 !important;
        }

        .review-wrapper {
            background: #fff;
            border-radius: 14px;
            padding: 25px;
            margin-top: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .05);
        }

        .review-media {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 15px;
        }

        .review-media img,
        .review-media video {
            width: 170px;
            height: 170px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #ddd;
            background: #f8f8f8;
        }
    </style>

    @php
        $totalReview = $product->reviews->count();
        $averageRating = round($product->reviews->avg('rating'), 1);

        $star5 = $product->reviews->where('rating', 5)->count();
        $star4 = $product->reviews->where('rating', 4)->count();
        $star3 = $product->reviews->where('rating', 3)->count();
        $star2 = $product->reviews->where('rating', 2)->count();
        $star1 = $product->reviews->where('rating', 1)->count();
    @endphp

    <div class="container my-4">

        <div class="product-wrapper">
            <div class="row g-4">

                <!-- LEFT IMAGE -->
                <div class="col-md-6">

                    <div class="image-wrapper">

                        <img src="{{ asset('storage/' . $product->image) }}" class="main-img" alt="{{ $product->name }}">

                        @if ($product->stock <= 0)
                            <div class="out-of-stock-overlay">

                                <div class="overlay-content">
                                    <i class="bi bi-x-circle-fill"></i>

                                    <h3>Stok Produk Habis</h3>

                                    <p>Maaf, produk ini sedang tidak tersedia.</p>

                                </div>
                            </div>
                        @endif

                    </div>

                </div>

                <!-- RIGHT INFO -->
                <div class="col-md-6">

                    <span class="title">{{ $product->name }}</span>

                    <div class="mt-2">
                        <span class="text-warning">
                            ★ {{ $averageRating ?: 0 }}
                        </span>

                        <small class="text-muted">
                            | {{ $totalReview }} Penilaian
                        </small>
                    </div>

                    <div class="mt-3 price">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>

                    <hr>

                    <div class="info-box">
                        <strong>Deskripsi:</strong><br>

                        @if ($product->description)
                            <ul class="mt-2 ps-2">
                                @foreach (explode("\n", $product->description) as $desc)
                                    @if (str_starts_with($desc, '-'))
                                        <li>{{ ltrim($desc, '- ') }}</li>
                                    @else
                                        <p class="mb-1">{{ $desc }}</p>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <p>Tidak ada deskripsi produk</p>
                        @endif
                    </div>

                    {{-- Stok --}}
                    <div class="info-box">
                        <strong>Stok :</strong>

                        @if ($product->stock > 0)
                            {{ $product->stock }}
                        @else
                            <span class="text-danger fw-bold">
                                0 Habis
                            </span>
                        @endif
                    </div>

                    @if ($product->stock > 0)
                        <div class="info-box">
                            <strong>Kuantitas:</strong>

                            <div class="d-flex align-items-center gap-2 mt-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm"
                                    onclick="decreaseQty()">-</button>

                                <input type="number" id="qty" name="qty" value="1" min="1"
                                    max="{{ $product->stock }}" class="form-control text-center" style="width: 80px;">

                                <button type="button" class="btn btn-outline-secondary btn-sm"
                                    onclick="increaseQty()">+</button>
                            </div>
                        </div>
                    @endif

                    <!-- BUTTON ACTION -->
                    <div class="d-flex gap-2">

                        <!-- Keranjang -->
                        <form action="{{ url('/cart/add') }}" method="POST" class="flex-fill">
                            @csrf

                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <input type="hidden" name="image" value="{{ $product->image }}">
                            <input type="hidden" name="qty" id="qtyInput" value="1">

                            <button type="submit"
                                class="btn-cart w-100 d-flex align-items-center justify-content-center gap-2"
                                {{ $product->stock <= 0 ? 'disabled' : '' }}>

                                <i class="bi bi-cart-plus"></i>
                                Keranjang

                            </button>

                        </form>

                        <!-- Beli Sekarang -->
                        <form action="{{ url('/checkout/buy-now') }}" method="POST" class="flex-fill">
                            @csrf

                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <input type="hidden" name="image" value="{{ $product->image }}">
                            <input type="hidden" name="qty" id="buyQty" value="1">

                            <button type="submit"
                                class="btn-buy w-100 d-flex align-items-center justify-content-center gap-2"
                                {{ $product->stock <= 0 ? 'disabled' : '' }}>

                                <i class="bi bi-bag-check"></i>
                                Beli Sekarang

                            </button>

                        </form>

                    </div>

                    <!-- Tombol Kembali -->
                    <a href="{{ url('/produk') }}" class="btn btn-light w-100 mt-2">
                        Kembali
                    </a>

                </div>
            </div>
        </div>

        <div class="my-4"></div>


        {{-- Penilaian Produk --}}
        <div class="review-wrapper">
            <h4 class="fw-bold mb-3">Penilaian Produk</h4>

            <div class="d-flex align-items-center gap-4 mb-4">

                {{-- Ringkasan Rating --}}
                <div class="d-flex align-items-center gap-4 mb-4">
                    <div>
                        <h2 class="text-warning fw-bold mb-1">
                            {{ number_format($averageRating, 1) }}/5
                        </h2>
                        <p class="text-muted mb-0">
                            {{ $totalReview }} Penilaian
                        </p>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-outline-warning btn-sm">5★ ({{ $star5 }})</button>
                        <button class="btn btn-outline-warning btn-sm">4★ ({{ $star4 }})</button>
                        <button class="btn btn-outline-warning btn-sm">3★ ({{ $star3 }})</button>
                        <button class="btn btn-outline-warning btn-sm">2★ ({{ $star2 }})</button>
                        <button class="btn btn-outline-warning btn-sm">1★ ({{ $star1 }})</button>
                    </div>
                </div>

                <hr>

            </div>

            @forelse($product->reviews as $review)

                <div class="border-bottom py-4">

                    <div class="d-flex">

                        {{-- Foto Profil --}}
                        <img src="{{ $review->user->photo ? asset('storage/' . $review->user->photo) : asset('images/default-user.png') }}"
                            width="55" height="55" class="rounded-circle me-3" style="object-fit:cover;">

                        <div class="flex-grow-1">

                            {{-- Nama --}}
                            <strong>{{ $review->user->name }}</strong>

                            {{-- Rating --}}
                            <div class="text-warning">
                                @for ($i = 1; $i <= 5; $i++)
                                    {{ $i <= $review->rating ? '★' : '☆' }}
                                @endfor
                            </div>

                            {{-- Tanggal --}}
                            <small class="text-muted">
                                {{ $review->created_at->format('d M Y') }}
                            </small>

                            {{-- Komentar --}}
                            <p class="mt-2 mb-3">
                                {{ $review->comment }}
                            </p>

                            {{-- Foto & Video Review --}}
                            @if ($review->image || $review->video)
                                <div class="review-media">

                                    @if ($review->image)
                                        <img src="{{ asset('storage/' . $review->image) }}" alt="Foto Review">
                                    @endif

                                    @if ($review->video)
                                        <video controls>
                                            <source src="{{ asset('storage/' . $review->video) }}">
                                        </video>
                                    @endif

                                </div>
                            @endif

                        </div>

                    </div>

                </div>

            @empty

                <p class="text-muted">
                    Belum ada penilaian untuk produk ini.
                </p>
            @endforelse

        </div>
    </div>

    <script>
        const qty = document.getElementById('qty');
        const qtyInput = document.getElementById('qtyInput');
        const buyQty = document.getElementById('buyQty');
        const maxStock = {{ $product->stock }};

        function syncQty() {
            qtyInput.value = qty.value;
            buyQty.value = qty.value;
        }

        function increaseQty() {
            let value = parseInt(qty.value) || 1;

            if (value < maxStock) {
                qty.value = value + 1;
            }

            syncQty();
        }

        function decreaseQty() {
            let value = parseInt(qty.value) || 1;

            if (value > 1) {
                qty.value = value - 1;
            }

            syncQty();
        }

        qty.addEventListener('input', function() {
            let value = parseInt(qty.value) || 1;

            if (value < 1) qty.value = 1;
            if (value > maxStock) qty.value = maxStock;

            syncQty();
        });

        syncQty();
    </script>

    <script>
        const toast = document.getElementById("toastOverlay");

        if (toast) {
            setTimeout(() => {
                toast.style.display = "none";
            }, 2000);
        }
    </script>
@endsection
