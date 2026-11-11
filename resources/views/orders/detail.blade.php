@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')

    <style>
        .detail-card {
            border: none;
            border-radius: 16px;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }

        .info-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: 600;
        }

        .info-value {
            font-weight: 500;
        }

        .product-item {
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .total-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
        }

        .status-badge {
            font-size: 14px;
            padding: 8px 15px;
        }
    </style>

    @php
        $totalBelanja = $order->items->sum(function ($item) {
            return $item->jumlah * $item->price;
        });
    @endphp

    <div class="container py-4">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-1">Detail Pesanan</h3>
            </div>

            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>

        </div>

        {{-- Header --}}

        <div class="card shadow-sm detail-card">

            <div class="card-body">

                {{-- INFO ORDER --}}
                <div class="row g-4 align-items-start">

                    <div class="col">
                        <div class="info-label">Tanggal Pesanan</div>
                        <div class="info-value">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>

                    <div class="col">
                        <div class="info-label">Metode Pembayaran</div>
                        <div class="info-value">
                            {{ $order->payment_method ?? '-' }}
                        </div>
                    </div>

                    <div class="col">
                        <div class="info-label">Alamat Pengiriman</div>
                        <div class="info-value">
                            {{ $order->address ?? '-' }}
                        </div>
                    </div>

                    {{-- Info Pengiriman --}}
                    <div class="col">
                        <div class="info-label">Info Pengiriman</div>
                        <div class="info-value">
                            <i class="bi bi-truck me-1"></i>
                            {{ $order->courier ?? ($order->shipping_method ?? '-') }}
                        </div>
                    </div>

                    {{-- Status Pesanan --}}
                    <div class="col">
                        <div class="info-label">Status Pesanan</div>

                        <span
                            class="badge status-badge
                         @if ($order->status == 'pending') bg-warning text-dark
                         @elseif($order->status == 'diproses') bg-info
                         @elseif($order->status == 'dikirim') bg-primary
                         @elseif($order->status == 'selesai') bg-success
                         @else bg-secondary @endif
                         ">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                </div>

                {{-- Batas header --}}

                <hr>

                {{-- PRODUK --}}
                <h5 class="mb-3">Produk yang Dipesan</h5>

                @foreach ($order->items as $item)
                    <div class="product-item d-flex align-items-center">

                        <img src="{{ asset('storage/' . $item->product->image) }}" class="product-image">

                        <div class="flex-grow-1 ms-3">

                            <h6 class="mb-1">
                                {{ $item->product->name }}
                            </h6>

                            <small class="text-muted">
                                {{ $item->jumlah }} x
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </small>

                        </div>

                        <div class="fw-bold">
                            Rp {{ number_format($item->jumlah * $item->price, 0, ',', '.') }}
                        </div>

                    </div>
                @endforeach

                {{-- TOTAL (SUDAH DIPERSINGKAT) --}}
                <div class="total-section mt-4">

                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total Pesanan</span>
                        <span class="text-danger">
                            Rp {{ number_format($totalBelanja, 0, ',', '.') }}
                        </span>
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
