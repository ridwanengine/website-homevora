@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="container py-5">

        {{-- STEP --}}
        <div class="d-flex justify-content-center align-items-center mb-5">
            <div class="text-center mx-4">
                <div class="rounded-circle border p-3">1</div>
                <small>Keranjang</small>
            </div>

            <div style="width:100px;height:2px;background:#ddd"></div>

            <div class="text-center mx-4">
                <div class="rounded-circle border p-3">2</div>
                <small>Checkout</small>
            </div>

            <div style="width:100px;height:2px;background:#28a745"></div>

            <div class="text-center mx-4">
                <div class="rounded-circle bg-success text-white p-3">
                    3
                </div>
                <small>Pembayaran</small>
            </div>
        </div>


        {{-- BATAS WAKTU --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">

                <div class="d-flex align-items-center justify-content-center">

                    <div class="me-4 fs-1">
                        ⏰
                    </div>

                    <div>

                        <div class="text-muted">
                            Batas Waktu Pembayaran
                        </div>

                        @if ($order->status == 'cancelled')
                            <h2 class="text-danger fw-bold">
                                Pesanan Dibatalkan
                            </h2>
                        @elseif($order->payment_proof)
                            <h2 class="text-success fw-bold">
                                Bukti Sudah Diupload
                            </h2>
                        @else
                            <h2 class="text-danger fw-bold" id="countdown">
                                Loading...
                            </h2>

                            <div class="small text-secondary">
                                {{ \Carbon\Carbon::parse($order->payment_deadline)->format('d M Y H:i') }} WIB
                            </div>
                        @endif

                    </div>

                </div>

            </div>
        </div>


        {{-- DETAIL PEMBAYARAN --}}
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-4">

                <h4 class="text-success mb-4">
                    Detail Pembayaran
                </h4>


                <div class="row py-3 border-bottom">

                    <div class="col-md-4">
                        Metode Pembayaran
                    </div>

                    <div class="col-md-8 fw-semibold">
                        {{ $order->payment_method }}
                    </div>

                </div>


                <div class="row py-3 border-bottom">

                    <div class="col-md-4">
                        Nomor Tujuan
                    </div>

                    <div class="col-md-6 fw-bold">
                        {{ $payment->account_number }}
                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-outline-success btn-sm" onclick="copyNumber()">

                            Salin

                        </button>

                    </div>

                </div>


                <div class="row py-3 border-bottom">

                    <div class="col-md-4">
                        Nama Pemilik
                    </div>

                    <div class="col-md-8">
                        {{ $payment->account_name }}
                    </div>

                </div>


                <div class="row py-4">

                    <div class="col-md-4">
                        Total Bayar
                    </div>

                    <div class="col-md-8">

                        <h2 class="text-success fw-bold">
                            Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                        </h2>

                    </div>

                </div>

                {{-- UPLOAD BUKTI PEMBAYARAN --}}
                <div class="border-top pt-4 mt-2">

                    <h5 class="text-success mb-3">
                        Upload Bukti Pembayaran
                    </h5>

                    @if ($order->payment_proof)
                        <div class="alert alert-success">
                            Bukti pembayaran sudah diupload
                        </div>

                        <img src="{{ asset('payments/' . $order->payment_proof) }}" class="img-fluid rounded mb-3"
                            width="250">
                    @else
                        <form action="{{ route('payment.upload', $order->id) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <div class="mb-3">

                                <input type="file" name="payment_proof" class="form-control" required>

                            </div>

                            <button type="submit" class="btn btn-success">

                                Upload Bukti

                            </button>

                        </form>
                    @endif

                </div>


                {{-- CARA PEMBAYARAN --}}
                <div class="bg-light rounded-4 p-4">

                    <h5 class="text-success mb-3">
                        Cara Pembayaran
                    </h5>

                    @if ($order->payment_method == 'DANA')
                        <ol>

                            <li>Buka aplikasi DANA</li>

                            <li>Pilih menu Kirim</li>

                            <li>Masukkan nomor tujuan</li>

                            <li>Masukkan nominal pembayaran</li>

                            <li>Selesaikan pembayaran</li>

                        </ol>
                    @else
                        <ol>

                            <li>Buka aplikasi Mobile Banking</li>

                            <li>Pilih Transfer</li>

                            <li>Masukkan nomor rekening</li>

                            <li>Masukkan nominal pembayaran</li>

                            <li>Konfirmasi transaksi</li>

                        </ol>
                    @endif

                </div>


                <div class="alert alert-warning mt-4">

                    Pastikan nominal pembayaran sesuai.
                    Pembayaran tidak sesuai dapat
                    menyebabkan pesanan gagal diproses.

                </div>


            </div>

        </div>


        <div class="text-center mt-4 text-secondary">

            Butuh bantuan?
            Hubungi WhatsApp:
            0812-3456-7890

        </div>
    </div>

    @if ($order->status != 'cancelled' && !$order->payment_proof && $order->payment_deadline)
        <script>
            let deadline =
                {{ \Carbon\Carbon::parse($order->payment_deadline)->timestamp * 1000 }};

            function updateCountdown() {

                let now = new Date().getTime();

                let distance = deadline - now;

                if (distance <= 0) {

                    document.getElementById('countdown')
                        .innerHTML = "00:00:00";

                    return;
                }

                let days =
                    Math.floor(
                        distance /
                        (1000 * 60 * 60 * 24)
                    );

                let hours =
                    Math.floor(
                        (distance %
                            (1000 * 60 * 60 * 24)) /
                        (1000 * 60 * 60)
                    );

                hours =
                    (days * 24) + hours;

                let minutes =
                    Math.floor(
                        (distance %
                            (1000 * 60 * 60)) /
                        (1000 * 60)
                    );

                let seconds =
                    Math.floor(
                        (distance %
                            (1000 * 60)) /
                        1000
                    );

                document
                    .getElementById('countdown')
                    .innerHTML =
                    String(hours)
                    .padStart(2, '0') +
                    ":" +
                    String(minutes)
                    .padStart(2, '0') +
                    ":" +
                    String(seconds)
                    .padStart(2, '0');
            }

            updateCountdown();

            setInterval(
                updateCountdown,
                1000
            );
        </script>
    @endif

@endsection
