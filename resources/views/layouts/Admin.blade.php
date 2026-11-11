<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Admin Panel') - Homevora</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon" />

    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-bg: #866347;
            /* warna sidebar sesuai permintaan */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', Roboto, Arial, sans-serif;
        }

        /* ----- SIDEBAR dengan warna #866347 ----- */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100%;
            background: var(--sidebar-bg);
            color: white;
            transition: all 0.3s ease;
            z-index: 1050;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 20px 16px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            background: rgba(0, 0, 0, 0.05);
        }

        .sidebar-header .logo-text {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar-header img {
            width: 52px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            padding: 4px;
        }

        .sidebar-header h5 {
            font-weight: 600;
            letter-spacing: 0.3px;
            margin-top: 10px;
            font-size: 1.1rem;
            color: #fff;
        }

        /* navigasi */
        .sidebar .nav {
            padding: 10px 0;
            flex: 1;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 10px 18px;
            margin: 4px 12px;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            transform: translateX(3px);
        }

        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            box-shadow: inset 3px 0 0 #fff;
        }

        /* collapse sidebar */
        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.collapsed .sidebar-title,
        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 12px 0;
            margin: 4px 8px;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0 !important;
            font-size: 1.4rem;
        }

        .sidebar.collapsed .sidebar-header img {
            width: 40px;
        }

        .sidebar.collapsed .sidebar-header h5 {
            display: none;
        }

        /* main content */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        /* topbar */
        .topbar {
            background: white;
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border-bottom: 1px solid #e9ecef;
            flex-wrap: wrap;
            gap: 12px;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-left h4 {
            margin: 0;
            font-weight: 600;
            color: #1e293b;
            font-size: 1.25rem;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .topbar-right .profile-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-right .admin-name {
            font-weight: 500;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .topbar-right .admin-name i {
            font-size: 1.2rem;
            color: #866347;
        }

        .btn-outline-logout {
            background: transparent;
            border: 1px solid #e2e8f0;
            color: #475569;
            padding: 4px 14px;
            border-radius: 30px;
            font-size: 0.85rem;
            transition: 0.2s;
        }

        .btn-outline-logout:hover {
            background: #fee2e2;
            border-color: #f87171;
            color: #b91c1c;
        }

        .btn-toggle {
            background: #866347;
            border: none;
            color: white;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }

        .btn-toggle:hover {
            background: #6e4f37;
            color: white;
        }

        /* icon bell sejajar dengan profil admin */
        .bell-icon {
            font-size: 1.3rem;
            color: #1e293b;
            background: #f1f5f9;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: 0.2s;
            cursor: pointer;
            position: relative;
        }

        .bell-icon:hover {
            background: #e2e8f0;
            color: #866347;
        }

        .bell-icon .badge-dot {
            position: absolute;
            top: 4px;
            right: 6px;
            width: 10px;
            height: 10px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid white;
        }

        .content-area {
            padding: 24px 28px;
            flex: 1;
        }

        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
        }

        /* responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
            }

            .sidebar .sidebar-title,
            .sidebar .nav-link span {
                display: none;
            }

            .sidebar .nav-link {
                justify-content: center;
                padding: 12px 0;
            }

            .sidebar .nav-link i {
                margin-right: 0 !important;
                font-size: 1.4rem;
            }

            .main-content {
                margin-left: 80px;
            }

            .topbar-left h4 {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>

    @php
        $outOfStockProducts = \App\Models\Product::where('stock', 0)->get();
    @endphp

    <!-- ====== SIDEBAR ====== -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-text">
                <img src="{{ asset('images/logo.png') }}" alt="logo" />
                <h5 class="sidebar-title mt-2">Homevora Admin</h5>
            </div>
        </div>

        <nav class="nav flex-column">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.products.index') }}"
                class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i>
                <span>Produk</span>
            </a>

            <a href="{{ route('admin.orders.index') }}"
                class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Pesanan</span>
            </a>

            <a href="{{ route('admin.payment.index') }}"
                class="nav-link {{ request()->routeIs('admin.payment.*') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i>
                <span>Metode Pembayaran</span>
            </a>
        </nav>
    </div>

    <!-- ====== MAIN ====== -->
    <div class="main-content" id="mainContent">

        <!-- TOPBAR -->
        <div class="topbar">
            <div class="topbar-left">
                <button class="btn-toggle" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h4>@yield('page-title', 'Dashboard')</h4>
            </div>

            <div class="topbar-right">
                <div class="dropdown">

                    <button class="btn position-relative" data-bs-toggle="dropdown">

                        <i class="fas fa-bell fs-5"></i>

                        @if ($outOfStockProducts->count() > 0)
                            <span class="badge bg-danger">

                                {{ $outOfStockProducts->count() }}

                            </span>
                        @endif

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow" style="width:320px;">

                        <li class="dropdown-header fw-bold">
                            Notifikasi
                        </li>

                        @forelse($outOfStockProducts as $product)
                            <li>

                                <a class="dropdown-item">

                                    <div class="fw-bold text-danger">

                                        <i class="fas fa-times-circle"></i>

                                        {{ $product->name }}

                                    </div>

                                    <small>
                                        Stok habis
                                    </small>

                                </a>

                            </li>

                        @empty

                            <li>

                                <span class="dropdown-item text-success">

                                    <i class="fas fa-check-circle"></i>

                                    Tidak ada produk yang stoknya habis.

                                </span>

                            </li>
                        @endforelse

                    </ul>

                </div>

                <div class="profile-wrapper">
                    <span class="admin-name">
                        <i class="fas fa-user-circle"></i>
                        {{ Auth::guard('admin')->user()->name ?? 'Admin' }}
                    </span>

                    <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                        @csrf
                        <button class="btn-outline-logout" type="submit">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="content-area">

            @yield('content')
        </div>
    </div>

    <!-- ====== SCRIPTS ====== -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        (function() {
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');

            if (toggleBtn && sidebar && mainContent) {
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');
                });
            }

            // inisialisasi DataTables
            $(document).ready(function() {
                $('.datatable').each(function() {
                    if ($.fn.DataTable.isDataTable(this)) {
                        $(this).DataTable().destroy();
                    }
                    $(this).DataTable({
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                        }
                    });
                });
            });
        })();
    </script>

    @stack('scripts')

</body>

</html>
