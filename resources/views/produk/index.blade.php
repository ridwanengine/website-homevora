@extends('layouts.app')

@section('title', 'Produk')

@section('content')
    <style>
        .product-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
        }

        /* Efek card naik + shadow */
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12) !important;
        }

        /* Optional: efek teks sedikit lebih tegas saat hover */
        .product-card:hover .card-title a {
            color: #000;
            transition: 0.3s;
        }

        .product-title {
            min-height: 48px;
            /* Tinggi untuk 2 baris */
            line-height: 24px;
            overflow: hidden;
        }

        /* Produk habis */
        .out-of-stock img {
            filter: grayscale(100%);
            opacity: .55;
        }

        /* Badge HABIS */
        .stock-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #dc3545;
            color: white;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 20px;
            z-index: 10;
            letter-spacing: .5px;
        }
    </style>

    <div class="container my-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Produk</h2>
        </div>

        <div class="row g-5">

            @forelse ($products as $product)
                <div class="col-md-3 col-sm-6 d-flex">

                    <div class="card product-card h-100 w-100 shadow-sm border-0">

                        <!-- IMAGE -->
                        <div class="position-relative {{ $product->stock == 0 ? 'out-of-stock' : '' }}">

                            @if ($product->stock == 0)
                                <span class="stock-badge">
                                    HABIS
                                </span>
                            @endif

                            <a href="{{ url('/produk/' . $product->id) }}">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top product-img"
                                        style="height: 200px; object-fit: cover;" alt="{{ $product->name }}">
                                @else
                                    <img src="https://via.placeholder.com/300x200" class="card-img-top product-img"
                                        style="height: 200px; object-fit: cover;">
                                @endif
                            </a>

                        </div>

                        <!-- BODY -->
                        <div class="card-body d-flex flex-column">

                            <!-- NAME -->
                            <h6 class="card-title product-title">
                                <a href="{{ url('/produk/' . $product->id) }}"
                                    class="text-decoration-none text-dark fw-semibold">
                                    {{ $product->name }}
                                </a>
                            </h6>

                            <!-- PRICE (ORANGE) -->
                            <div class="mb-2">
                                <span class="fw-bold" style="color: #987456; font-size: 16px;">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>

                            <!-- STOCK + TERJUAL -->
                            <div class="d-flex justify-content-between text-muted small mt-auto">

                                @if ($product->stock > 0)
                                    <span>
                                        Stok: {{ $product->stock }}
                                    </span>
                                @else
                                    <span class="text-danger fw-bold">
                                        <i class="bi bi-x-circle-fill"></i>
                                        Stok Habis
                                    </span>
                                @endif

                                <span>
                                    {{ $product->orderItems()->whereHas('order', function ($q) {
                                            $q->where('status', 'completed');
                                        })->sum('jumlah') }}
                                    Terjual
                                </span>

                            </div>

                            <!-- 🔥 FORM ADD TO CART (TARUH DI SINI) -->
                            <form action="{{ url('/cart/add') }}" method="POST" class="mt-auto">
                                @csrf

                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="name" value="{{ $product->name }}">
                                <input type="hidden" name="price" value="{{ $product->price }}">
                                <input type="hidden" name="image" value="{{ $product->image }}">

                            </form>

                        </div>

                    </div>

                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    Tidak ada produk ditemukan
                </div>
            @endforelse

        </div>
    </div>
@endsection
