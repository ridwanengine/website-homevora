@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')

    <style>
        .order-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            transition: .3s;
        }

        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .1);
        }

        .product-item {
            padding: 15px 0;
            border-bottom: 1px solid #f1f1f1;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .product-image {
            width: 85px;
            height: 85px;
            object-fit: cover;
            border-radius: 12px;
        }

        .label-title {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .order-number {
            font-size: 13px;
            color: #6c757d;
            font-weight: 600;
        }

        .total-price {
            font-size: 24px;
            font-weight: 700;
            color: #dc3545;
        }

        .status-badge {
            font-size: 13px;
            padding: 8px 14px;
        }

        .product-name {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .card-footer {
            background: #fff;
            border-top: 1px solid #eee;
        }

        .empty-order {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-order i {
            font-size: 60px;
            color: #adb5bd;
        }

        .btn-purple {
            background: #6f42c1;
            color: #fff;
            border: none;
        }

        .btn-purple:hover {
            background: #5a35a3;
            color: #fff;
        }

        .btn-outline-purple {
            border: 1px solid #6f42c1;
            color: #6f42c1;
        }

        .btn-outline-purple:hover {
            background: #6f42c1;
            color: #fff;
        }

        .order-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 140px;
            height: 40px;
            padding: 0 16px;
            gap: 6px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            transition: .2s ease;
        }

        .order-btn:hover {
            transform: translateY(-2px);
        }

        .btn-main {
            background: #ff5722;
            border: none;
            color: white;
        }

        .btn-main:hover {
            background: #e64a19;
            color: white;
        }

        .btn-soft {
            background: #fff;
            border: 1px solid #dee2e6;
            color: #495057;
        }

        .btn-soft:hover {
            background: #f8f9fa;
        }

        .btn-success-soft {
            background: #e8fff1;
            color: #198754;
            border: 1px solid #198754;
        }

        .btn-success-soft:hover {
            background: #198754;
            color: #fff;
        }

        .btn-purple {
            background: #6f42c1;
            color: white;
            border: none;
        }

        .btn-purple:hover {
            background: #5b35a0;
            color: white;
        }

        /* Style untuk tabs */
        .order-tabs {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 24px;
            border-bottom: 2px solid #f1f1f1;
            padding-bottom: 12px;
        }

        .order-tabs .tab-link {
            padding: 8px 20px;
            border-radius: 20px;
            text-decoration: none;
            color: #6c757d;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            background: transparent;
            border: none;
            cursor: pointer;
        }

        .order-tabs .tab-link:hover {
            background: #f8f9fa;
            color: #212529;
        }

        .order-tabs .tab-link.active {
            background: #987456;
            color: white;
        }

        .order-tabs .tab-link .badge-tab {
            background: rgba(108, 117, 125, 0.15);
            color: #6c757d;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 12px;
            margin-left: 6px;
        }

        .order-tabs .tab-link.active .badge-tab {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .order-tabs .tab-link .badge-tab.danger {
            background: #dc3545;
            color: white;
        }

        /* Empty state untuk setiap tab */
        .tab-empty-state {
            display: none;
            text-align: center;
            padding: 60px 20px;
        }

        .tab-empty-state i {
            font-size: 60px;
            color: #adb5bd;
        }

        .tab-empty-state h5 {
            margin-top: 16px;
            font-weight: 600;
        }

        .tab-empty-state p {
            color: #6c757d;
        }

        /* Toast notification */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast-custom {
            background: #28a745;
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideInRight 0.5s ease;
            min-width: 300px;
        }

        .toast-custom.error {
            background: #dc3545;
        }

        .toast-custom i {
            font-size: 24px;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        /* Review section style */
        .review-product-card {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 16px;
            transition: all 0.3s ease;
        }

        .review-product-card:hover {
            border-color: #987456;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .review-product-card .product-info {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f1f1f1;
        }

        .review-product-card .product-info img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
        }

        .review-product-card .product-info .details {
            margin-left: 12px;
            flex: 1;
        }

        .review-product-card .product-info .details h6 {
            margin: 0;
            font-weight: 600;
        }

        .review-product-card .product-info .details small {
            color: #6c757d;
        }

        .review-fields {
            padding-left: 62px;
        }

        /* ================= Review Detail Modal ================= */
        .review-modal .modal-dialog {
            max-width: 620px;
        }

        .review-modal .modal-content {
            border: none;
            border-radius: 18px;
            overflow: hidden;
        }

        .review-modal .modal-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f1f1;
        }

        .review-modal .modal-body {
            padding: 20px;
        }

        .review-modal .modal-footer {
            border-top: 1px solid #f1f1f1;
            padding: 14px 20px;
        }

        .review-product {
            display: flex;
            align-items: center;
            gap: 15px;
            padding-bottom: 16px;
            border-bottom: 1px solid #eee;
        }

        .review-product img {
            width: 65px;
            height: 65px;
            border-radius: 10px;
            object-fit: cover;
        }

        .review-user {
            display: flex;
            align-items: center;
            margin-top: 18px;
        }

        .review-user img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
        }

        .review-comment {
            margin-top: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 12px;
            font-size: 14px;
            line-height: 1.6;
        }

        .review-media {
            width: 100%;
            height: 170px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #dee2e6;
        }

        .review-empty {
            width: 100%;
            height: 170px;
            border: 1px dashed #ced4da;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 14px;
            background: #fafafa;
        }

        .review-date {
            border-top: 1px solid #eee;
            margin-top: 18px;
            padding-top: 14px;
            color: #6c757d;
            font-size: 14px;
        }
    </style>

    <div class="container py-4">

        <h3 class="fw-bold mb-3">
            <i class="bi bi-bag-check me-2"></i>
            Pesanan Saya
        </h3>

        <!-- TABS FILTER -->
        <div class="order-tabs" id="orderTabs">
            <button class="tab-link active" data-status="all">
                Semua
                <span class="badge-tab">{{ $orders->count() }}</span>
            </button>
            <button class="tab-link" data-status="pending">
                Belum Bayar
                <span class="badge-tab danger">{{ $orders->where('status', 'pending')->count() }}</span>
            </button>
            <button class="tab-link" data-status="processing">
                Diproses
                <span class="badge-tab">{{ $orders->where('status', 'processing')->count() }}</span>
            </button>
            <button class="tab-link" data-status="shipped">
                Dikirim
                <span class="badge-tab">{{ $orders->where('status', 'shipped')->count() }}</span>
            </button>
            <button class="tab-link" data-status="completed">
                Selesai
                <span class="badge-tab">{{ $orders->where('status', 'completed')->count() }}</span>
            </button>
            <button class="tab-link" data-status="cancelled">
                Dibatalkan
                <span class="badge-tab danger">{{ $orders->where('status', 'cancelled')->count() }}</span>
            </button>
        </div>

        {{-- <--- Alert ---> --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Toast Notification -->
        {{-- <div class="toast-container" id="toastContainer"></div> --}}

        <!-- Container untuk orders -->
        <div id="ordersContainer">
            @if ($orders->isEmpty())
                <div class="card shadow-sm" id="emptyStateAll">
                    <div class="empty-order">
                        <i class="bi bi-cart-x"></i>
                        <h5 class="mt-3">Belum Ada Pesanan</h5>
                        <p class="text-muted">
                            Kamu belum melakukan pemesanan.
                        </p>
                    </div>
                </div>
            @else
                @foreach ($orders as $order)
                    @php
                        $totalBelanja = $order->items->sum(function ($item) {
                            return $item->jumlah * $item->price;
                        });

                        $statusText = [
                            'pending' => 'Belum Dibayar',
                            'processing' => 'Diproses',
                            'shipped' => 'Dikiriman',
                            'completed' => 'Pesanan Selesai',
                            'cancelled' => 'Pesanan Dibatalkan',
                        ];
                    @endphp

                    <div class="card shadow-sm mb-4 order-card order-item" data-status="{{ $order->status }}">
                        {{-- HEADER --}}
                        <div class="card-header bg-white py-3">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <div class="row align-items-center gx-4 gy-2">
                                        <!-- Tanggal -->
                                        <div class="col-auto">
                                            <small class="label-title d-block">Tanggal</small>
                                            <div class="info-text">
                                                <i class="bi bi-calendar-event me-1"></i>
                                                {{ $order->created_at->format('d M Y, H:i') }}
                                            </div>
                                        </div>

                                        <!-- Pembayaran -->
                                        <div class="col-auto">
                                            <small class="label-title d-block">Pembayaran</small>
                                            <div class="info-text">
                                                <i class="bi bi-credit-card me-1"></i>
                                                {{ $order->payment_method ?? '-' }}
                                            </div>
                                        </div>

                                        <!-- Status -->
                                        <div class="col-auto">
                                            <small class="label-title d-block">
                                                <i class="bi bi-clock me-1"></i>
                                                Status Pembayaran
                                            </small>
                                            @if ($order->status == 'cancelled')
                                                <div class="text-danger fw-semibold">
                                                    <i class="bi bi-x-circle-fill me-1"></i>
                                                    Pesanan Dibatalkan
                                                </div>
                                            @elseif ($order->payment_status == 'success')
                                                <div class="text-success fw-semibold">
                                                    <i class="bi bi-check-circle-fill me-1"></i>
                                                    Sudah Dibayar
                                                </div>
                                            @else
                                                <div class="payment-countdown" id="countdown-{{ $order->id }}">
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Alamat -->
                                        <div class="col">
                                            <small class="label-title d-block">Alamat Pengiriman</small>
                                            <div class="info-text">
                                                <i class="bi bi-geo-alt me-1"></i>
                                                {{ $order->address ?? 'Alamat belum tersedia' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                                    <span
                                        class="badge rounded-pill status-badge
                                        @if ($order->status == 'pending') bg-warning text-dark
                                        @elseif($order->status == 'processing') bg-info
                                        @elseif($order->status == 'shipped') bg-primary
                                        @elseif($order->status == 'completed') bg-success
                                        @elseif($order->status == 'cancelled') bg-danger
                                        @else bg-secondary @endif
                                    ">
                                        @if ($order->status == 'pending')
                                            <i class="bi bi-clock-history me-1"></i>
                                        @elseif($order->status == 'processing')
                                            <i class="bi bi-arrow-repeat me-1"></i>
                                        @elseif($order->status == 'shipped')
                                            <i class="bi bi-truck me-1"></i>
                                        @elseif($order->status == 'completed')
                                            <i class="bi bi-check-circle me-1"></i>
                                        @elseif ($order->status == 'cancelled')
                                            <i class="bi bi-x-circle me-1"></i>
                                        @endif
                                        {{ $statusText[$order->status] ?? $order->status }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- BODY --}}
                        <div class="card-body">
                            @foreach ($order->items as $item)
                                <div class="product-item d-flex align-items-start">
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="product-image">
                                    <div class="flex-grow-1 ms-3">
                                        <div class="product-name">
                                            {{ $item->product->name }}
                                        </div>
                                        <div class="d-flex justify-content-between mt-3">
                                            <div>
                                                <small class="text-muted d-block">
                                                    Jumlah
                                                </small>
                                                <span class="fw-semibold">
                                                    {{ $item->jumlah }}x
                                                </span>
                                            </div>
                                            <div class="text-end">
                                                <small class="text-muted d-block">
                                                    Harga Satuan
                                                </small>
                                                <span class="fw-semibold">
                                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- FOOTER --}}
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-end">
                                <div class="text-end">
                                    {{-- TOTAL BELANJA --}}
                                    <div class="mb-3">
                                        <small class="text-muted d-block">
                                            Total Belanja
                                        </small>
                                        <div class="fw-bold text-danger" style="font-size: 25px;">
                                            Rp {{ number_format($totalBelanja, 0, ',', '.') }}
                                        </div>
                                    </div>

                                    {{-- TOMBOL SESUAI STATUS --}}
                                    <div class="d-flex gap-2 justify-content-end flex-wrap">
                                        @if ($order->status == 'pending')
                                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger order-btn">
                                                    <i class="bi bi-x-circle me-1"></i>
                                                    Batalkan
                                                </button>
                                            </form>
                                            <a href="{{ route('payment', $order->id) }}"
                                                class="btn btn-warning text-white order-btn">
                                                <i class="bi bi-credit-card me-1"></i>
                                                Bayar Sekarang
                                            </a>
                                        @elseif($order->status == 'processing')
                                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger order-btn">
                                                    <i class="bi bi-x-circle me-1"></i>
                                                    Batalkan
                                                </button>
                                            </form>
                                            <a href="{{ route('orders.detail', $order->id) }}"
                                                class="btn btn-outline-secondary order-btn">
                                                <i class="bi bi-eye me-1"></i>
                                                Lihat Detail
                                            </a>
                                        @elseif($order->status == 'shipped')
                                            <form action="{{ route('orders.received', $order->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-primary order-btn"
                                                    onclick="return confirm('Apakah pesanan sudah diterima?')">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    Pesanan Diterima
                                                </button>
                                            </form>
                                        @elseif($order->status == 'completed')
                                            <a href="{{ route('order.reorder', $order->id) }}"
                                                class="btn btn-outline-primary order-btn">
                                                <i class="bi bi-arrow-repeat me-1"></i>
                                                Beli Lagi
                                            </a>

                                            @php
                                                $hasReview = \App\Models\Review::where('order_id', $order->id)
                                                    ->where('user_id', auth()->id())
                                                    ->exists();
                                            @endphp

                                            @if (!$hasReview)
                                                <button class="btn btn-warning order-btn" data-bs-toggle="modal"
                                                    data-bs-target="#reviewModal{{ $order->id }}">
                                                    <i class="bi bi-star me-1"></i>
                                                    Beri Penilaian
                                                </button>
                                            @else
                                                <button class="btn btn-success-soft order-btn" data-bs-toggle="modal"
                                                    data-bs-target="#showReviewModal{{ $order->id }}">
                                                    <i class="bi bi-eye me-1"></i>
                                                    Tampilkan Penilaian
                                                </button>
                                            @endif
                                        @elseif($order->status == 'cancelled')
                                            <a href="{{ route('order.reorder', $order->id) }}"
                                                class="btn btn-outline-primary order-btn">
                                                <i class="bi bi-arrow-repeat me-1"></i>
                                                Beli Lagi
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MODAL REVIEW --}}
                    <div class="modal fade" id="reviewModal{{ $order->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data"
                                    class="review-form" data-order-id="{{ $order->id }}">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            <i class="bi bi-star-fill text-warning me-2"></i>
                                            Beri Penilaian untuk Pesanan{{ $order->id }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                                        @foreach ($order->items as $item)
                                            <div class="review-product-card">
                                                <div class="product-info">
                                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                                        alt="{{ $item->product->name }}">
                                                    <div class="details">
                                                        <h6>{{ $item->product->name }}</h6>
                                                        <small>Rp {{ number_format($item->price, 0, ',', '.') }} x
                                                            {{ $item->jumlah }}</small>
                                                    </div>
                                                </div>

                                                <div class="review-fields">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Rating</label>
                                                            <select name="rating[{{ $item->product->id }}]"
                                                                class="form-select" required>
                                                                <option value="5">⭐⭐⭐⭐⭐ Sangat Baik</option>
                                                                <option value="4">⭐⭐⭐⭐ Baik</option>
                                                                <option value="3">⭐⭐⭐ Cukup</option>
                                                                <option value="2">⭐⭐ Kurang</option>
                                                                <option value="1">⭐ Buruk</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Komentar</label>
                                                            <textarea name="comment[{{ $item->product->id }}]" class="form-control" rows="2"
                                                                placeholder="Bagikan pengalaman Anda..."></textarea>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-label fw-semibold">Foto
                                                                (Opsional)
                                                            </label>
                                                            <input type="file" name="image[{{ $item->product->id }}]"
                                                                class="form-control" accept="image/*">
                                                            <small class="text-muted">Max 2 MB</small>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-label fw-semibold">Video
                                                                (Opsional)</label>
                                                            <input type="file" name="video[{{ $item->product->id }}]"
                                                                class="form-control"
                                                                accept="video/mp4,video/webm,video/ogg">
                                                            <small class="text-muted">Max 20 MB</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success" id="submitReview">
                                            <i class="bi bi-send me-1"></i>
                                            Kirim Semua Ulasan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Tampilkan Penilaian --}}
                    @php
                        $review = \App\Models\Review::where('order_id', $order->id)
                            ->where('user_id', auth()->id())
                            ->first();
                    @endphp

                    @if ($review)
                        <div class="modal fade review-modal" id="showReviewModal{{ $order->id }}" tabindex="-1"
                            aria-hidden="true">

                            <div class="modal-dialog modal-dialog-centered">

                                <div class="modal-content">

                                    {{-- Header --}}
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">
                                            <i class="bi bi-star-fill text-warning me-2"></i>
                                            Penilaian Produk
                                        </h5>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    {{-- Body --}}
                                    <div class="modal-body">

                                        {{-- Produk --}}
                                        <div class="review-product">

                                            <img src="{{ asset('storage/' . $review->product->image) }}">

                                            <div>

                                                <h6 class="fw-bold mb-1">
                                                    {{ $review->product->name }}
                                                </h6>

                                                <small class="text-muted">
                                                    Produk yang telah dibeli
                                                </small>

                                            </div>

                                        </div>

                                        {{-- User --}}
                                        <div class="review-user">

                                            <img
                                                src="{{ $review->user->photo ? asset('storage/' . $review->user->photo) : asset('images/default-avatar.png') }}">

                                            <div class="ms-3">

                                                <div class="fw-semibold">

                                                    {{ $review->user->name }}

                                                </div>

                                                <div>

                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $review->rating)
                                                            <i class="bi bi-star-fill text-warning"></i>
                                                        @else
                                                            <i class="bi bi-star text-secondary"></i>
                                                        @endif
                                                    @endfor

                                                    <span class="fw-bold ms-1">

                                                        {{ number_format($review->rating, 1) }}

                                                    </span>

                                                </div>

                                            </div>

                                        </div>

                                        {{-- Komentar --}}
                                        <div class="review-comment">

                                            {{ $review->comment ?: 'Tidak ada komentar.' }}

                                        </div>

                                        {{-- Foto & Video --}}
                                        <div class="row mt-4 g-3">

                                            {{-- FOTO --}}
                                            <div class="col-6">

                                                <div class="fw-semibold mb-2">

                                                    📷 Foto Review

                                                </div>

                                                @if ($review->image)
                                                    <img src="{{ asset('storage/' . $review->image) }}"
                                                        class="review-media">
                                                @else
                                                    <div class="review-empty">

                                                        Tidak ada foto

                                                    </div>
                                                @endif

                                            </div>

                                            {{-- VIDEO --}}
                                            <div class="col-6">

                                                <div class="fw-semibold mb-2">

                                                    🎥 Video Review

                                                </div>

                                                @if ($review->video)
                                                    <video controls class="review-media">

                                                        <source src="{{ asset('storage/' . $review->video) }}">

                                                    </video>
                                                @else
                                                    <div class="review-empty">

                                                        Tidak ada video

                                                    </div>
                                                @endif

                                            </div>

                                        </div>

                                        {{-- Tanggal --}}
                                        <div class="review-date">

                                            <i class="bi bi-calendar-event me-1"></i>

                                            Dinilai pada

                                            <strong>

                                                {{ $review->created_at->translatedFormat('d F Y') }}

                                            </strong>

                                            pukul

                                            <strong>

                                                {{ $review->created_at->format('H:i') }} WITA

                                            </strong>

                                        </div>

                                    </div>

                                    {{-- Footer --}}
                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editReviewModal{{ $order->id }}" data-bs-dismiss="modal">
                                            <i class="bi bi-pencil-square me-1"></i>
                                            Perbarui Penilaian
                                        </button>

                                        <button class="btn btn-success px-4" data-bs-dismiss="modal">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Oke
                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                        {{-- Modal Edit Penilaian --}}
                        <div class="modal fade" id="editReviewModal{{ $order->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <form action="{{ route('reviews.update', $review->id) }}" method="POST"
                                        enctype="multipart/form-data">

                                        @csrf
                                        @method('PUT')

                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <i class="bi bi-pencil-square text-warning"></i>
                                                Perbarui Penilaian
                                            </h5>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">

                                            {{-- Produk --}}
                                            <div class="d-flex align-items-center mb-4">

                                                <img src="{{ asset('storage/' . $review->product->image) }}"
                                                    width="70" class="rounded border me-3">

                                                <div>
                                                    <h6 class="mb-1">{{ $review->product->name }}</h6>
                                                    <small class="text-muted">
                                                        Ubah penilaian Anda
                                                    </small>
                                                </div>

                                            </div>

                                            {{-- Rating --}}
                                            <div class="mb-3">

                                                <label class="form-label fw-bold">
                                                    Rating
                                                </label>

                                                <select name="rating" class="form-select" required>

                                                    @for ($i = 5; $i >= 1; $i--)
                                                        <option value="{{ $i }}"
                                                            {{ $review->rating == $i ? 'selected' : '' }}>
                                                            {{ $i }} Bintang
                                                        </option>
                                                    @endfor

                                                </select>

                                            </div>

                                            {{-- Komentar --}}
                                            <div class="mb-3">

                                                <label class="form-label fw-bold">
                                                    Komentar
                                                </label>

                                                <textarea name="comment" class="form-control" rows="4">{{ $review->comment }}</textarea>

                                            </div>

                                            {{-- Foto --}}
                                            <div class="mb-3">

                                                <label class="form-label fw-bold">
                                                    Foto Baru (Opsional)
                                                </label>

                                                <input type="file" name="image" class="form-control"
                                                    accept="image/*">

                                                @if ($review->image)
                                                    <img src="{{ asset('storage/' . $review->image) }}"
                                                        class="img-thumbnail mt-2" width="120">
                                                @endif

                                            </div>

                                            {{-- Video --}}
                                            <div class="mb-3">

                                                <label class="form-label fw-bold">
                                                    Video Baru (Opsional)
                                                </label>

                                                <input type="file" name="video" class="form-control"
                                                    accept="video/*">

                                                @if ($review->video)
                                                    <video controls width="180" class="mt-2 rounded border">

                                                        <source src="{{ asset('storage/' . $review->video) }}">

                                                    </video>
                                                @endif

                                            </div>

                                        </div>

                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Batal
                                            </button>

                                            <button type="submit" class="btn btn-warning">
                                                <i class="bi bi-save me-1"></i>
                                                Simpan Perubahan
                                            </button>

                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Countdown timer
            @foreach ($orders as $order)
                @if ($order->status != 'cancelled' && !$order->paid_at && $order->payment_deadline)
                    (function() {
                        const deadline = new Date(
                            "{{ \Carbon\Carbon::parse($order->payment_deadline)->format('Y-m-d H:i:s') }}"
                        ).getTime();
                        const countdown = document.getElementById('countdown-{{ $order->id }}');
                        const timer = setInterval(function() {
                            const now = new Date().getTime();
                            const distance = deadline - now;
                            if (distance <= 0) {
                                countdown.innerHTML = 'Kedaluwarsa';
                                clearInterval(timer);
                                return;
                            }
                            const hours = Math.floor(
                                (distance % (1000 * 60 * 60 * 24)) /
                                (1000 * 60 * 60)
                            );
                            const minutes = Math.floor(
                                (distance % (1000 * 60 * 60)) /
                                (1000 * 60)
                            );
                            const seconds = Math.floor(
                                (distance % (1000 * 60)) /
                                1000
                            );
                            countdown.innerHTML =
                                String(hours).padStart(2, '0') + ':' +
                                String(minutes).padStart(2, '0') + ':' +
                                String(seconds).padStart(2, '0');
                        }, 1000);
                    })();
                @endif
            @endforeach

            // Toast notification function
            function showToast(message, type = 'success') {
                const container = document.getElementById('toastContainer');
                const toast = document.createElement('div');
                toast.className = `toast-custom ${type === 'error' ? 'error' : ''}`;
                toast.innerHTML = `
                    <i class="bi ${type === 'error' ? 'bi-exclamation-circle' : 'bi-check-circle-fill'}"></i>
                    <span>${message}</span>
                `;
                container.appendChild(toast);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    toast.style.animation = 'slideOutRight 0.5s ease';
                    setTimeout(() => {
                        toast.remove();
                    }, 500);
                }, 5000);

                // Click to remove
                toast.addEventListener('click', function() {
                    this.style.animation = 'slideOutRight 0.5s ease';
                    setTimeout(() => {
                        this.remove();
                    }, 500);
                });
            }

            // Handle review form submission with AJAX
            document.querySelectorAll('.review-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const submitBtn = this.querySelector('#submitReview');
                    const originalText = submitBtn.innerHTML;

                    // Disable button and show loading
                    submitBtn.disabled = true;
                    submitBtn.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';

                    fetch(this.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Close modal
                                const modal = bootstrap.Modal.getInstance(this.closest(
                                    '.modal'));
                                modal.hide();

                                // Show success toast
                                showToast(data.message ||
                                    '⭐ Ulasan berhasil dikirim! Terima kasih atas penilaian Anda.'
                                );

                                // Update UI: hide review button
                                const orderId = this.dataset.orderId;
                                const reviewBtn = document.querySelector(
                                    `[data-bs-target="#reviewModal${orderId}"]`);
                                if (reviewBtn) {
                                    reviewBtn.classList.remove('btn-warning');
                                    reviewBtn.classList.add('btn-success-soft');

                                    reviewBtn.innerHTML = `
                                         <i class="bi bi-eye me-1"></i>
                                        Tampilkan Penilaian`;

                                    reviewBtn.setAttribute(
                                        'data-bs-target',
                                        '#showReviewModal' + orderId
                                    );
                                }
                            } else {
                                showToast(data.message ||
                                    'Gagal mengirim ulasan. Silakan coba lagi.', 'error');
                            }
                        })
                        .catch(error => {
                            showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
                        })
                        .finally(() => {
                            // Re-enable button
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        });
                });
            });

            // Filter tabs functionality
            const tabs = document.querySelectorAll('.tab-link');
            const orderItems = document.querySelectorAll('.order-item');
            const container = document.querySelector('#ordersContainer');

            // Menampilkan tab sesuai status
            function showTab(status) {
                tabs.forEach(t => t.classList.remove('active'));

                const activeTab = document.querySelector(
                    `.tab-link[data-status="${status}"]`
                );

                if (activeTab) {
                    activeTab.classList.add('active');
                }

                orderItems.forEach(item => {
                    if (status === 'all' || item.dataset.status === status) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });

                updateEmptyStates(status);
            }

            // Create empty state elements for each tab
            const emptyStates = {};
            const statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];
            const statusLabels = {
                'pending': 'Belum Bayar',
                'processing': 'Diproses',
                'shipped': 'Dikirim',
                'completed': 'Selesai',
                'cancelled': 'Dibatalkan'
            };

            statuses.forEach(status => {
                const emptyDiv = document.createElement('div');
                emptyDiv.className = 'card shadow-sm tab-empty-state';
                emptyDiv.id = 'emptyState_' + status;
                emptyDiv.style.display = 'none';
                emptyDiv.innerHTML = `
                    <div class="empty-order">
                        <i class="bi bi-inbox"></i>
                        <h5 class="mt-3">Tidak Ada Pesanan</h5>
                        <p class="text-muted">
                            Tidak ada pesanan dengan status <strong>"${statusLabels[status]}"</strong>.
                        </p>
                    </div>
                `;
                container.appendChild(emptyDiv);
                emptyStates[status] = emptyDiv;
            });

            function updateEmptyStates(activeStatus) {
                // Hide all empty states first
                Object.values(emptyStates).forEach(el => {
                    el.style.display = 'none';
                });

                // Count visible items
                const visibleItems = document.querySelectorAll('.order-item[style*="display: block"]');

                if (visibleItems.length === 0) {
                    // Show empty state for active tab
                    if (emptyStates[activeStatus]) {
                        emptyStates[activeStatus].style.display = 'block';
                    }
                }
            }

            // Initial state - show empty for active tab if needed
            setTimeout(() => {
                const activeTab = document.querySelector('.tab-link.active');
                if (activeTab) {
                    const status = activeTab.getAttribute('data-status');
                    updateEmptyStates(status);
                }
            }, 100);

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {

                    const status = this.dataset.status;

                    // Simpan tab aktif
                    localStorage.setItem('activeOrderTab', status);

                    // Tampilkan tab
                    showTab(status);
                });
            });

            // Saat halaman dibuka kembali
            const savedTab = localStorage.getItem('activeOrderTab') || 'all';
            showTab(savedTab);
        });
    </script>

@endsection
