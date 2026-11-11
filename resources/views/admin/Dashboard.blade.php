@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card stat-card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Total Produk</h6>
                                <h2 class="mb-0">{{ number_format($totalProducts) }}</h2>
                            </div>
                            <i class="fas fa-box fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Total Pemesanan</h6>
                                <h2 class="mb-0">{{ number_format($totalOrders) }}</h2>
                            </div>
                            <i class="fas fa-shopping-cart fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Total Penjualan</h6>
                                <h4 class="mb-0">Rp {{ number_format($totalSales, 0, ',', '.') }}</h4>
                            </div>
                            <i class="fas fa-chart-line fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Pesanan Pending</h6>
                                <h2 class="mb-0">{{ number_format($pendingOrders) }}</h2>
                            </div>
                            <i class="fas fa-clock fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card stat-card bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Pesanan Diproses</h6>
                                <h2 class="mb-0">{{ number_format($processingOrders) }}</h2>
                            </div>
                            <i class="fas fa-spinner fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card stat-card bg-secondary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Total Customer</h6>
                                <h2 class="mb-0">{{ number_format($totalCustomers) }}</h2>
                            </div>
                            <i class="fas fa-users fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Pesanan Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>

                                    <td>
                                        <span class="badge bg-{{ $statusBadge[$order->status] ?? 'secondary' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>

                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>

                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#detailOrder{{ $order->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="detailOrder{{ $order->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    Detail Pesanan #{{ $order->id }}
                                                </h5>

                                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <p>
                                                    <strong>Customer:</strong>
                                                    {{ $order->customer_name }}
                                                </p>

                                                <p>
                                                    <strong>Status:</strong>
                                                    {{ ucfirst($order->status) }}
                                                </p>

                                                <p>
                                                    <strong>Total:</strong>
                                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                                </p>

                                                <p>
                                                    <strong>Tanggal:</strong>
                                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center">
                                        Belum ada pesanan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
