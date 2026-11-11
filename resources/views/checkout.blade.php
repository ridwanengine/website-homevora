@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

    @php
        $grandTotal = 0;
    @endphp

    <style>
        .checkout-container {
            max-width: 1000px;
            margin: 40px auto;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            font-family: Arial, sans-serif;
        }

        .section-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .product-table th,
        .product-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        .summary-box {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-checkout {
            width: 170px;
            padding: 10px 18px;
            background: #f39c12;
            border: none;
            color: #fff;
            font-size: 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: .3s;
        }

        .btn-checkout:hover {
            background: #d68910;
        }

        .btn-back-cart {
            width: 170px;
            padding: 10px 18px;
            background: #6c757d;
            color: #fff;
            text-decoration: none;
            text-align: center;
            border-radius: 8px;
            transition: .3s;
        }

        .btn-back-cart:hover {
            background: #5a6268;
            color: #fff;
        }
    </style>

    <div class="checkout-container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf

            {{-- ================= DATA PENERIMA & PENGIRIMAN ================= --}}
            <div class="section-title">Data Penerima</div>

            @php
                $user = Auth::user();
            @endphp

            <div class="row g-2 mb-3">

                <div class="col-md-3">
                    <label for="Nama">Nama</label>
                    <input type="text" name="receiver_name" class="form-control"
                        value="{{ old('receiver_name', $user->name ?? '') }}" placeholder="Nama" readonly>
                </div>

                <div class="col-md-3">
                    <label for="No Hp">No Hp</label>
                    <input type="text" name="receiver_phone" class="form-control"
                        value="{{ old('receiver_phone', $user->phone ?? '') }}" placeholder="No Handphone" readonly>
                </div>

                <div class="col-md-6">
                    <label for="Alamat">Alamat</label>
                    <textarea name="address" class="form-control" rows="1" placeholder="Alamat lengkap" readonly>{{ old('shipping_address', $user->address ?? '') }}</textarea>
                </div>

            </div>

            {{-- ================= PRODUK ================= --}}
            <div class="section-title">Produk Dipesan</div>

            <table class="product-table">
                <thead>
                    <tr>
                        <th style="text-align:left;">Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($cart as $item)
                        @php
                            $price = $item['price'] ?? 0;
                            $qty = $item['qty'] ?? 1;
                            $subtotal = $price * $qty;
                            $grandTotal += $subtotal;
                        @endphp

                        <tr>
                            {{-- PRODUK + GAMBAR --}}
                            <td>
                                <div style="display:flex; align-items:center; gap:10px;">

                                    <img src="{{ !empty($item['image']) ? asset('storage/' . $item['image']) : 'https://via.placeholder.com/60' }}"
                                        alt="produk"
                                        style="width:50px;height:50px;object-fit:cover;border-radius:8px;border:1px solid #ddd;">

                                    <span>{{ $item['name'] }}</span>
                                </div>
                            </td>

                            <td>Rp {{ number_format($price, 0, ',', '.') }}</td>
                            <td>{{ $qty }}</td>
                            <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="4">Keranjang kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- ================= PENGIRIMAN ================= --}}
            <div class="section-title">Opsi Pengiriman</div>

            <select name="shipping_method" class="form-control mb-3" required>
                <option value="hemat_kargo">Hemat Kargo</option>
                <option value="spx_hemat">SPX Hemat</option>
                <option value="reguler">Reguler</option>
                <option value="express">Express</option>
            </select>

            {{-- ================= PEMBAYARAN ================= --}}
            <div class="section-title">Metode Pembayaran</div>

            <select id="payment_method" name="payment_method" class="form-control mb-3" required>
                <option value="">-- Pilih Metode Pembayaran --</option>
                <option value="cod">COD (Bayar di Tempat)</option>
                <option value="transfer">Transfer Bank</option>
                <option value="ewallet">E-Wallet</option>
            </select>

            {{-- BANK OPTIONS --}}
            <div id="bankOptions" style="display:none;" class="mb-3">
                <label>Pilih Bank</label>
                <select name="bank_name" class="form-control">
                    <option value="BCA">BCA</option>
                    <option value="BRI">BRI</option>
                    <option value="BNI">BNI</option>
                    <option value="Mandiri">Mandiri</option>
                </select>
            </div>

            {{-- EWALLET OPTIONS --}}
            <div id="ewalletOptions" style="display:none;" class="mb-3">
                <label>Pilih E-Wallet</label>
                <select name="ewallet_name" class="form-control">
                    <option value="Gopay">GoPay</option>
                    <option value="OVO">OVO</option>
                    <option value="DANA">DANA</option>
                    <option value="ShopeePay">ShopeePay</option>
                </select>
            </div>

            {{-- ================= TOTAL ================= --}}
            <div class="summary-box mb-3">
                <h4>Total Pembayaran</h4>
                <h3>Rp {{ number_format($grandTotal, 0, ',', '.') }}</h3>
            </div>

            <input type="hidden" name="total" value="{{ $grandTotal }}">


            <div class="button-group">
                <a href="{{ route('cart.index') }}" class="btn-back-cart">
                     Kembali
                </a>

                <button type="submit" class="btn-checkout">
                    Buat Pesanan
                </button>
            </div>

        </form>

    </div>
    <script>
        const paymentMethod = document.getElementById('payment_method');
        const bankOptions = document.getElementById('bankOptions');
        const ewalletOptions = document.getElementById('ewalletOptions');

        paymentMethod.addEventListener('change', function() {

            let value = this.value;

            bankOptions.style.display = 'none';
            ewalletOptions.style.display = 'none';

            if (value === 'transfer') {
                bankOptions.style.display = 'block';
            }

            if (value === 'ewallet') {
                ewalletOptions.style.display = 'block';
            }
        });
    </script>

@endsection
