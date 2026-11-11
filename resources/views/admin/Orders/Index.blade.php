@extends('layouts.admin')

@section('title', 'Manajemen Pemesanan')
@section('page-title', 'Manajemen Pemesanan')

@push('styles')
    <style>
        .order-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .06);
        }

        .order-card .card-header {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            border: none;
            padding: 20px 25px;
        }

        .order-card .card-header h5 {
            color: #fff;
            margin: 0;
            font-weight: 600;
        }

        .table {
            vertical-align: middle;
        }

        .table thead th {
            background: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
            color: #374151;
            padding: 16px 14px;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 16px 14px;
            border-color: #f1f5f9;
            font-size: 14px;
        }

        .table-hover tbody tr:hover {
            background: #f8fbff;
        }

        .badge-status {
            padding: 8px 12px;
            border-radius: 10px;
        }

        .form-control-sm,
        .form-select-sm {
            border-radius: 10px;
        }

        .btn {
            border-radius: 10px;
        }

        .btn-primary {
            background: #4f46e5;
            border: none;
        }

        .btn-info {
            background: #0ea5e9;
            border: none;
            color: white;
        }

        .modal-content {
            border: none;
            border-radius: 20px;
        }

        .modal-header {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: white;
        }

        .info-box {
            background: #f8fafc;
            border-radius: 15px;
            padding: 18px;
        }

        .total-box {
            background: #eef2ff;
            padding: 14px;
            border-radius: 12px;
        }

        .dataTables_wrapper .dataTables_filter input {
            border-radius: 10px;
            border: 1px solid #d1d5db;
            padding: 6px 12px;
        }

        .dataTables_wrapper .dataTables_length select {
            border-radius: 10px;
        }

        /* custom table */
        .custom-table {
            width: 100%;
            table-layout: fixed;
        }

        .custom-table td,
        .custom-table th {
            vertical-align: middle;
        }

        .col-harga {
            width: 220px;
        }

        .col-total {
            width: 220px;
        }

        /*  */
    </style>
@endpush


@section('content')

    {{-- notif --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert">
            </button>

        </div>
    @endif

    <div class="card order-card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5>Daftar Semua Pesanan</h5>

            <span class="badge bg-light text-dark px-3 py-2">
                Total Pesanan: {{ $orders->count() }}
            </span>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover" id="orders-table">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th style="text-align: center">satuan</th>
                            <th style="text-align: center">Total</th>
                            <th>Pembayaran</th>
                            <th style="text-align: center">Bukti Pembayaran</th>
                            <th>Status Bayar</th>
                            <th style="text-align: center">Alamat</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($orders as $order)
                            <tr>

                                <td>
                                    <strong class="text-primary">
                                        #{{ $order->id }}
                                    </strong>
                                </td>


                                <td>

                                    <div class="fw-semibold">
                                        {{ $order->customer_name }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $order->customer_email }}
                                    </small>

                                </td>


                                <td>

                                    @foreach ($order->items as $item)
                                        <div>
                                            {{ $item->product_name }}
                                        </div>
                                    @endforeach

                                </td>


                                <td>

                                    @foreach ($order->items as $item)
                                        <div style="text-align: center">
                                            {{ $item->jumlah }}
                                        </div>
                                    @endforeach

                                </td>

                                {{-- Harga Satuan Produk --}}
                                <td style="min-width: 110px;">
                                    @foreach ($order->items as $item)
                                        <div>
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </div>
                                    @endforeach
                                </td>

                                {{-- Total --}}
                                <td style="min-width: 110px;">
                                    <strong class="text-success">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </strong>
                                </td>

                                {{-- Metode Pembayaran --}}
                                <td class="text-center">
                                    <span class="badge bg-dark badge-status">

                                        {{ ucfirst($order->payment_method) }}

                                    </span>
                                </td>

                                {{-- Bukti Pembayaran --}}
                                <td class="text-center">

                                    @if ($order->payment_proof)
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#proofModal{{ $order->id }}">

                                            <i class="fas fa-eye"></i>

                                        </button>
                                    @else
                                        <span class="text-muted">
                                            Belum ada bukti
                                        </span>
                                    @endif

                                </td>

                                {{-- Status Pembayaran --}}
                                <td>
                                    @php
                                        $paymentBadge = [
                                            'pending' => 'warning',
                                            'success' => 'success',
                                            'rejected' => 'danger',
                                        ];
                                    @endphp

                                    <span class="badge bg-{{ $paymentBadge[$order->payment_status] ?? 'secondary' }}">

                                        {{ ucfirst($order->payment_status) }}

                                    </span>

                                </td>

                                {{-- Alamat --}}
                                <td style="min-width:150px; text-align: center">

                                    {{ $order->address ?? '-' }}

                                </td>

                                {{-- Status Pengiriman --}}
                                <td style="min-width:115px">

                                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">

                                        @csrf
                                        @method('PUT')

                                        <select name="status" class="form-select form-select-sm"
                                            onchange="this.form.submit()">

                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                                Pending
                                            </option>

                                            <option value="processing"
                                                {{ $order->status == 'processing' ? 'selected' : '' }}>
                                                Diproses
                                            </option>

                                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                                Dikirim
                                            </option>

                                            <option value="completed"
                                                {{ $order->status == 'completed' ? 'selected' : '' }}>
                                                Selesai
                                            </option>

                                            <option value="cancelled"
                                                {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                                Dibatalkan
                                            </option>

                                        </select>

                                    </form>
                                </td>


                                <td>

                                    {{ $order->created_at->format('d M Y') }}

                                    <br>

                                    <small class="text-muted">

                                        {{ $order->created_at->format('H:i') }}

                                    </small>

                                </td>

                                <td class="text-center d-flex justify-content-center gap-2">

                                    {{-- Detail --}}
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $order->id }}">
                                        <i class="fas fa-eye"></i>

                                    </button>

                                    {{-- Hapus --}}
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>



    {{-- MODAL DI LUAR TABLE --}}
    @foreach ($orders as $order)
        <div class="modal fade" id="detailModal{{ $order->id }}" tabindex="-1">

            <div class="modal-dialog modal-lg modal-dialog-centered">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Detail Pesanan #{{ $order->id }}
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                    </div>


                    <div class="modal-body">

                        <div class="row g-3">

                            <div class="col-md-6">

                                <div class="info-box">

                                    <h6>Informasi Customer</h6>

                                    <p>
                                        <strong>Nama :</strong>
                                        {{ $order->customer_name }}
                                    </p>

                                    <p>
                                        <strong>Email :</strong>
                                        {{ $order->customer_email }}
                                    </p>

                                    <p>
                                        <strong>Telepon :</strong>
                                        {{ $order->customer_phone ?? '-' }}
                                    </p>

                                    <p>
                                        <strong>Alamat :</strong>
                                        {{ $order->address }}
                                    </p>

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="info-box">

                                    <h6>Informasi Pesanan</h6>

                                    <p>
                                        <strong>Tanggal :</strong>
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </p>

                                    <p>
                                        <strong>Pembayaran :</strong>
                                        {{ ucfirst($order->payment_method) }}
                                    </p>

                                    <p>
                                        <strong>Status :</strong>
                                        {{ ucfirst($order->status) }}
                                    </p>

                                </div>

                            </div>

                        </div>


                        <hr>

                        <h6 class="mb-3 fw-bold">
                            Daftar Produk
                        </h6>

                        <table class="table">

                            <thead>

                                <tr>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($order->items as $item)
                                    <tr>

                                        <td>
                                            {{ $item->product_name }}
                                        </td>

                                        <td>
                                            {{ $item->jumlah }}
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>


                        <div class="total-box">

                            Total:
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button class="btn btn-secondary" data-bs-dismiss="modal">

                            Tutup

                        </button>

                    </div>

                </div>
            </div>
        </div>
    @endforeach

    {{-- MODAL BUKTI PEMBAYARAN --}}
    @foreach ($orders as $order)
        @if ($order->payment_proof)
            <div class="modal fade" id="proofModal{{ $order->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">
                                Bukti Pembayaran #{{ $order->id }}
                            </h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body text-center">

                            <img src="{{ asset('payments/' . $order->payment_proof) }}" class="img-fluid rounded mb-3"
                                style="max-height:500px;">

                        </div>

                        <div class="modal-footer">

                            @if ($order->payment_status == 'pending')
                                <form action="{{ route('admin.orders.confirm-payment', $order->id) }}" method="POST">

                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="btn btn-success">

                                        <i class="fas fa-check-circle me-1"></i>
                                        Konfirmasi Pembayaran

                                    </button>

                                </form>
                            @else
                                <span class="badge bg-success fs-6 me-auto">
                                    Terkonfirmasi
                                </span>

                                <form action="{{ route('admin.orders.cancel-confirmation', $order->id) }}" method="POST">

                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Batalkan konfirmasi pembayaran ini?')">

                                        <i class="fas fa-times-circle me-1"></i>
                                        Batalkan Konfirmasi

                                    </button>

                                </form>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        @endif
    @endforeach

@endsection


@push('scripts')
    <script>
        $(document).ready(function() {

            $('#orders-table').DataTable({

                order: [
                    [10, 'desc']
                ],

                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                }

            });

        });
    </script>
@endpush
