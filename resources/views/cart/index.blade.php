@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')

    @php
        $cart = session('cart', []);
    @endphp

    <style>
        /* ===== LAYOUT UTAMA ===== */
        .cart-page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .cart-content {
            flex: 1;
            padding-bottom: 20px;
        }

        .cart-container {
            max-width: 1200px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
            font-family: Arial, sans-serif;
            overflow-x: auto;
        }

        .cart-title {
            text-align: center;
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 25px;
            color: #333;
        }

        table.table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
        }

        table.table th {
            background: #f5f5f5;
            padding: 14px;
            text-align: left;
            border-bottom: 2px solid #ddd;
            white-space: nowrap;
        }

        table.table td {
            padding: 14px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
            white-space: nowrap;
        }

        table.table tr:hover {
            background: #fafafa;
        }

        .cart-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .btn-warning {
            background: #f1c40f;
            color: #000;
            padding: 10px 15px;
            border-radius: 8px;
        }

        .btn-warning:hover {
            background: #d4ac0d;
        }

        .total-row {
            font-weight: bold;
            background: #f9f9f9;
        }

        .empty-cart {
            text-align: center;
            padding: 50px;
            font-size: 18px;
            color: #888;
        }

        .product-img {
            width: 55px;
            height: 55px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .checkbox-center {
            text-align: center;
        }

        .cart-footer {
            text-align: right;
            margin-top: 15px;
        }

        /* ===== CHECKOUT BAR - STICKY DENGAN STOP DI ATAS FOOTER ===== */
        .checkout-bar {
            position: sticky;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #fff;
            border-top: 1px solid #ddd;
            box-shadow:
                0 -5px 20px rgba(0, 0, 0, .08),
                0 5px 20px rgba(0, 0, 0, .08);
            z-index: 9999;
            padding: 15px 0;
            transition: all 0.3s ease;
        }

        /* Saat sticky berhenti di atas footer */
        .checkout-bar.stopped {
            position: relative;
            bottom: auto;
            margin-bottom: 30px;
            box-shadow: 0 -5px 20px rgba(0, 0, 0, .05);
        }

        .checkout-content {
            max-width: 1200px;
            margin: auto;
            padding: 0 20px;
        }

        .checkout-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .checkout-left,
        .checkout-right {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .checkout-total {
            font-size: 18px;
            font-weight: bold;
        }

        .checkout-btn {
            background: #D4A373;
            color: #fff;
            border: none;
            padding: 12px 35px;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .checkout-btn:hover {
            background: #B98A5A;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 163, 115, 0.3);
        }

        .checkout-btn:active {
            transform: translateY(0);
        }

        .checkout-gap {
            height: 30px;
        }

        /* ===== FOOTER ===== */
        .footer-wrapper {
            background: #f8f8f8;
            border-top: 1px solid #eee;
            padding: 30px 0;
            margin-top: 0;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .checkout-box {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            .checkout-left,
            .checkout-right {
                justify-content: center;
            }

            .checkout-btn {
                width: 100%;
                justify-content: center;
            }

            .cart-container {
                padding: 15px;
                margin: 20px 10px;
            }

            table.table {
                min-width: 600px;
            }

            .cart-content {
                padding-bottom: 180px;
                /* Ruang lebih buat checkout di mobile */
            }
        }

        /* ===== TOAST NOTIFICATION ===== */
        .toast-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 99999;
            animation: fadeIn 0.3s ease;
        }

        .toast-box {
            background: white;
            padding: 40px 50px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            animation: slideUp 0.4s ease;
        }

        .toast-box .check-icon {
            font-size: 60px;
            color: #2ecc71;
            margin-bottom: 15px;
        }

        .toast-box p {
            font-size: 18px;
            font-weight: 500;
            color: #333;
            margin: 0;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>

    <div class="cart-page-wrapper">

        {{-- ==================== CONTENT UTAMA ==================== --}}
        <div class="cart-content">

            <div class="cart-container">

                <div class="cart-title"> Keranjang Belanja</div>

                @if (!empty($cart) && count($cart) > 0)

                    <table class="table">
                        <thead>
                            <tr>
                                <th class="checkbox-center">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th>Gambar</th>
                                <th>Nama</th>
                                <th>Harga Satuan</th>
                                <th>Kuantitas</th>
                                <th>Total Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp

                            @foreach ($cart as $item)
                                @php
                                    $price = $item['price'] ?? 0;
                                    $qty = $item['qty'] ?? 1;
                                    $total = $price * $qty;
                                    $grandTotal += $total;
                                @endphp

                                <tr>
                                    <td class="checkbox-center">
                                        <input type="checkbox" class="item-checkbox" value="{{ $item['id'] ?? '' }}"
                                            data-unitprice="{{ $price }}" data-price="{{ $total }}">
                                    </td>

                                    <td>
                                        <img src="{{ !empty($item['image']) ? asset('storage/' . $item['image']) : 'https://via.placeholder.com/60' }}"
                                            class="product-img" alt="{{ $item['name'] ?? 'Produk' }}">
                                    </td>

                                    <td>{{ $item['name'] ?? 'Produk tidak ada' }}</td>

                                    <td>Rp {{ number_format($price, 0, ',', '.') }}</td>

                                    <td>
                                        <div class="d-flex align-items-center gap-2">

                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                onclick="changeQty('{{ $item['id'] }}', -1)">
                                                −
                                            </button>

                                            <span id="qty-{{ $item['id'] }}" class="fw-bold">{{ $qty }}</span>

                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                onclick="changeQty('{{ $item['id'] }}', 1)">
                                                +
                                            </button>

                                        </div>
                                    </td>

                                    <td id="total-{{ $item['id'] }}">
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        <form action="{{ url('/cart/remove') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item['id'] ?? '' }}">
                                            <button class="btn cart-btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-cart">
                        Keranjang belanja kosong.<br>
                        <a href="{{ url('produk') }}" class="btn btn-warning mt-3">Belanja Sekarang</a>
                    </div>
                @endif

            </div>

        </div>

        {{-- ==================== CHECKOUT BAR (STICKY) ==================== --}}
        <div class="checkout-bar" id="checkoutBar">

            <div class="checkout-content">

                <form action="{{ route('checkout.select') }}" method="POST" id="checkoutForm">
                    @csrf

                    <input type="hidden" name="selected_items" id="selected_items">

                    <div class="checkout-box">

                        <div class="checkout-left">

                            <div class="d-flex align-items-center gap-2">
                                <input type="checkbox" id="selectAllCheckout">

                                <label for="selectAllCheckout" class="mb-0">
                                    Pilih Semua
                                    (<span id="totalCartItems">0</span>)
                                </label>
                            </div>

                            <button type="button" class="btn cart-btn btn-danger" onclick="openDeletePopup()">
                                Hapus
                            </button>

                        </div>

                        <div class="checkout-right">

                            <div class="checkout-total">
                                Total
                                (<span id="totalItems">0</span>) :

                                <span id="checkoutTotal">
                                    Rp 0
                                </span>
                            </div>

                            <button type="submit" class="checkout-btn">
                                Checkout
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <div class="checkout-gap"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const checkoutBar = document.getElementById('checkoutBar');
            const footerWrapper = document.getElementById('footerWrapper');

            if (checkoutBar && footerWrapper) {

                function handleCheckoutSticky() {
                    const footerRect = footerWrapper.getBoundingClientRect();
                    const viewportHeight = window.innerHeight;

                    if (footerRect.top < viewportHeight) {
                        checkoutBar.classList.add('stopped');
                    } else {
                        checkoutBar.classList.remove('stopped');
                    }
                }

                window.addEventListener('load', handleCheckoutSticky);
                window.addEventListener('scroll', handleCheckoutSticky);
                window.addEventListener('resize', handleCheckoutSticky);

                const observer = new MutationObserver(handleCheckoutSticky);
                observer.observe(document.body, {
                    childList: true,
                    subtree: true
                });
            }

            const checkboxes = document.querySelectorAll('.item-checkbox');
            const selectAllTop = document.getElementById('selectAll');
            const selectAllCheckout = document.getElementById('selectAllCheckout');
            const totalItemsText = document.getElementById('totalItems');
            const totalCartItems = document.getElementById('totalCartItems');
            const totalPriceText = document.getElementById('checkoutTotal');

            let selectedIds = [];

            function updateCart() {
                let total = 0;
                let count = 0;
                selectedIds = [];

                checkboxes.forEach(cb => {
                    if (cb.checked) {
                        count++;
                        total += parseInt(cb.dataset.price || 0);
                        selectedIds.push(cb.value);
                    }
                });

                if (totalItemsText) totalItemsText.innerText = count;
                if (totalCartItems) totalCartItems.innerText = checkboxes.length;
                if (totalPriceText) totalPriceText.innerText = "Rp " + total.toLocaleString('id-ID');

                const hiddenInput = document.getElementById('selected_items');
                if (hiddenInput) {
                    hiddenInput.value = JSON.stringify(selectedIds);
                }

                const allChecked = count === checkboxes.length && checkboxes.length > 0;

                if (selectAllTop) selectAllTop.checked = allChecked;
                if (selectAllCheckout) selectAllCheckout.checked = allChecked;
            }

            if (selectAllTop) {
                selectAllTop.addEventListener('change', function() {
                    checkboxes.forEach(cb => {
                        cb.checked = this.checked;
                    });
                    updateCart();
                });
            }

            if (selectAllCheckout) {
                selectAllCheckout.addEventListener('change', function() {
                    checkboxes.forEach(cb => {
                        cb.checked = this.checked;
                    });
                    updateCart();
                });
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateCart);
            });

            updateCart();

            window.changeQty = function(id, change) {
                let qtyEl = document.getElementById('qty-' + id);
                let totalEl = document.getElementById('total-' + id);
                let currentQty = parseInt(qtyEl.innerText);
                let newQty = currentQty + change;

                if (newQty < 1) return;

                fetch('/cart/update-qty', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id: id,
                            qty: newQty
                        })
                    })
                    .then(res => res.json())
                    .then(() => {
                        qtyEl.innerText = newQty;

                        let checkbox = document.querySelector('.item-checkbox[value="' + id + '"]');
                        let price = parseInt(checkbox.dataset.unitprice);
                        let newTotal = price * newQty;

                        totalEl.innerText = "Rp " + newTotal.toLocaleString('id-ID');
                        checkbox.dataset.price = newTotal;

                        updateCart();
                    });
            };

            const checkoutForm = document.getElementById('checkoutForm');

            checkoutForm.addEventListener('submit', function(e) {
                let checked = document.querySelectorAll('.item-checkbox:checked');

                if (checked.length === 0) {
                    e.preventDefault();
                    alert('⚠️ Silakan pilih produk terlebih dahulu!');
                    return false;
                }
            });

            window.openDeletePopup = function() {
                let checked = document.querySelectorAll('.item-checkbox:checked');

                if (checked.length === 0) {
                    alert('⚠️ Pilih produk yang ingin dihapus!');
                    return;
                }

                let ids = [];
                checked.forEach(item => {
                    ids.push(item.value);
                });

                fetch('/cart/remove-selected', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            ids: ids
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Produk berhasil dihapus.',
                            confirmButtonColor: '#866347'
                        }).then(() => {
                            location.reload();
                        });
                    });
            };

        });
    </script>

@endsection
