@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')

    <style>
        /* ===== ROOT VARIABLES ===== */
        :root {
            --white: #FFFFFF;
            --beige: #DCC5B2;
            --brown: #866347;
            --light-bg: #F8F8F8;
            --text-dark: #2D2D2D;
            --text-muted: #888888;
            --border-light: #EEEEEE;
            --shadow-soft: 0 8px 30px rgba(0, 0, 0, 0.06);
            --shadow-hover: 0 12px 40px rgba(0, 0, 0, 0.10);
            --radius-card: 20px;
            --radius-item: 16px;
            --transition: all 0.25s ease;
        }

        body {
            background: var(--light-bg);
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
        }

        /* ===== MAIN CONTAINER ===== */
        .profile-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .profile-card-main {
            background: var(--white);
            border-radius: var(--radius-card);
            padding: 40px 45px 35px;
            box-shadow: var(--shadow-soft);
            transition: var(--transition);
        }

        .profile-card-main:hover {
            box-shadow: var(--shadow-hover);
        }

        /* ===== PROFILE HEADER ===== */
        .profile-header {
            display: flex;
            align-items: center;
            gap: 30px;
            padding-bottom: 30px;
            border-bottom: 1.5px solid var(--border-light);
            flex-wrap: wrap;
        }

        /* Left - Avatar */
        .avatar-wrapper {
            position: relative;
            flex-shrink: 0;
            width: 120px;
            height: 120px;
        }

        .avatar-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--white);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            background: var(--light-bg);
            transition: var(--transition);
        }

        .avatar-img:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .camera-btn {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--beige);
            border: 3px solid var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.10);
            color: var(--brown);
            z-index: 2;
        }

        .camera-btn:hover {
            background: var(--brown);
            color: var(--white);
            transform: scale(1.08);
        }

        .camera-btn:active {
            transform: scale(0.92);
        }

        .camera-btn i {
            font-size: 16px;
        }

        /* Center - User Info */
        .user-info {
            flex: 1;
            min-width: 180px;
        }

        .user-info h1 {
            font-size: 28px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 4px 0;
            letter-spacing: -0.3px;
        }

        .user-info .email {
            font-size: 16px;
            color: var(--text-muted);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-info .email i {
            color: var(--brown);
            opacity: 0.6;
            font-size: 15px;
        }

        /* Right - Action Button */
        .profile-actions {
            flex-shrink: 0;
        }

        .btn-edit-profile {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 28px;
            border: 2px solid var(--brown);
            border-radius: 50px;
            background: transparent;
            color: var(--brown);
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-edit-profile:hover {
            background: var(--brown);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(134, 99, 71, 0.25);
        }

        .btn-edit-profile:active {
            transform: translateY(0);
        }

        .btn-edit-profile i {
            font-size: 16px;
        }

        /* ===== DIVIDER ===== */
        .divider {
            border: none;
            border-top: 1.5px solid var(--border-light);
            margin: 30px 0 30px 0;
        }

        /* ===== PESANAN SAYA CARD ===== */
        .order-card {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 18px 22px;
            border-radius: var(--radius-item);
            background: var(--white);
            border: 1.5px solid var(--border-light);
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            color: var(--text-dark);
            margin-bottom: 30px;
        }

        .order-card:hover {
            border-color: var(--beige);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            transform: translateY(-2px);
        }

        .order-card:active {
            transform: translateY(0);
        }

        .order-icon-box {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--beige);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--brown);
        }

        .order-icon-box i {
            font-size: 24px;
        }

        .order-text {
            flex: 1;
        }

        .order-text h4 {
            font-size: 17px;
            font-weight: 600;
            margin: 0 0 2px 0;
            color: var(--text-dark);
        }

        .order-text p {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0;
        }

        .order-arrow {
            color: #CCCCCC;
            font-size: 18px;
            transition: var(--transition);
        }

        .order-card:hover .order-arrow {
            color: var(--brown);
            transform: translateX(4px);
        }

        /* ===== MENU AKUN ===== */
        .menu-section-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 18px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .menu-section-title i {
            color: var(--brown);
            font-size: 20px;
        }

        .menu-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 30px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 16px 20px;
            border-radius: var(--radius-item);
            border: 1.5px solid var(--border-light);
            background: var(--white);
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            color: var(--text-dark);
        }

        .menu-item:hover {
            border-color: var(--beige);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
            transform: translateY(-1px);
        }

        .menu-item:active {
            transform: translateY(0);
        }

        .menu-item .icon-box {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 20px;
        }

        .menu-item .icon-box.green {
            background: #E8F5E9;
            color: #2E7D32;
        }

        .menu-item .icon-box.blue {
            background: #E3F2FD;
            color: #1565C0;
        }

        .menu-item .icon-box.red {
            background: #FFEBEE;
            color: #C62828;
        }

        .menu-item .menu-text {
            flex: 1;
        }

        .menu-item .menu-text h5 {
            font-size: 15px;
            font-weight: 600;
            margin: 0 0 2px 0;
            color: var(--text-dark);
        }

        .menu-item .menu-text small {
            font-size: 13px;
            color: var(--text-muted);
            display: block;
        }

        .menu-item .arrow {
            color: #CCCCCC;
            font-size: 16px;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .menu-item:hover .arrow {
            color: var(--brown);
            transform: translateX(3px);
        }

        /* Logout special hover */
        .menu-item.logout:hover {
            border-color: #EF9A9A;
        }

        .menu-item.logout:hover .arrow {
            color: #C62828;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .profile-card-main {
                padding: 28px 24px 25px;
                border-radius: 16px;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
                gap: 16px;
                padding-bottom: 24px;
            }

            .user-info .email {
                justify-content: center;
            }

            .profile-actions {
                width: 100%;
            }

            .btn-edit-profile {
                width: 100%;
                justify-content: center;
            }

            .order-card {
                padding: 14px 16px;
            }

            .menu-item {
                padding: 14px 16px;
                gap: 14px;
            }

            .menu-item .menu-text small {
                font-size: 12px;
            }

            .user-info h1 {
                font-size: 24px;
            }

            .avatar-wrapper {
                width: 100px;
                height: 100px;
            }

            .avatar-img {
                width: 100px;
                height: 100px;
            }

            .camera-btn {
                width: 34px;
                height: 34px;
            }

            .camera-btn i {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .profile-container {
                padding: 0 12px;
                margin: 20px auto;
            }

            .profile-card-main {
                padding: 20px 16px 20px;
                border-radius: 14px;
            }

            .order-icon-box {
                width: 44px;
                height: 44px;
            }

            .order-icon-box i {
                font-size: 20px;
            }

            .order-text h4 {
                font-size: 15px;
            }

            .menu-item .icon-box {
                width: 38px;
                height: 38px;
                font-size: 17px;
            }

            .menu-item .menu-text h5 {
                font-size: 14px;
            }

            .menu-section-title {
                font-size: 16px;
            }
        }
    </style>

    <div class="profile-container">

        <!-- ===== MAIN CARD ===== -->
        <div class="profile-card-main">

            <!-- ===== PROFILE HEADER ===== -->
            <div class="profile-header">

                <!-- Left: Avatar -->
                <div class="avatar-wrapper">
                    <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://cdn-icons-png.flaticon.com/512/847/847969.png' }}"
                        class="avatar-img" id="previewPhoto" alt="Foto Profil">

                    <form id="photoForm" action="{{ route('Profil.uploadPhoto') }}" method="POST"
                        enctype="multipart/form-data" style="display:none;">
                        @csrf
                        <input type="file" id="photoInput" name="photo" accept="image/*">
                    </form>

                    <div class="camera-btn" onclick="document.getElementById('photoInput').click()"
                        title="Ganti Foto Profil">
                        <i class="bi bi-camera-fill"></i>
                    </div>
                </div>

                <!-- Center: User Info -->
                <div class="user-info">
                    <h1>{{ auth()->user()->name }}</h1>

                    <p class="email">
                        <i class="bi bi-envelope-fill"></i>
                        {{ auth()->user()->email }}
                    </p>
                </div>

                <!-- Right: Edit Button -->
                <div class="profile-actions">
                    <button class="btn-edit-profile" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="bi bi-pencil"></i>
                        Edit Profil
                    </button>
                </div>

            </div>

            <!-- ===== DIVIDER ===== -->
            <hr class="divider">

            <!-- ===== PESANAN SAYA ===== -->
            <a href="{{ route('orders.index') }}" class="order-card">
                <div class="order-icon-box">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="order-text">
                    <h4>Pesanan Anda</h4>
                    <p>Lihat status dan riwayat pesanan Anda</p>
                </div>
                <i class="bi bi-chevron-right order-arrow"></i>
            </a>

            <!-- ===== DIVIDER ===== -->
            <hr class="divider">

            <!-- ===== MENU AKUN ===== -->
            <div class="menu-section-title">
                <i class="bi bi-sliders2"></i>
                Menu Akun
            </div>

            <div class="menu-list">

                <!-- Kelola Alamat -->
                <a href="#" class="menu-item" data-bs-toggle="modal" data-bs-target="#addressModal">
                    <div class="icon-box green">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <div class="menu-text">
                        <h5>Kelola Alamat</h5>
                        <small>Tambah, ubah, atau hapus alamat pengiriman Anda</small>
                    </div>
                    <i class="bi bi-chevron-right arrow"></i>
                </a>

                <!-- Ganti Password -->
                <a href="#" class="menu-item" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    <div class="icon-box blue">
                        <i class="bi bi-lock"></i>
                    </div>
                    <div class="menu-text">
                        <h5>Ganti Password</h5>
                        <small>Ubah password akun Anda secara berkala</small>
                    </div>
                    <i class="bi bi-chevron-right arrow"></i>
                </a>

                <!-- Logout -->
                <form action="{{ route('logout') }}" method="POST" class="m-0 w-100">
                    @csrf
                    <button type="submit" class="menu-item logout"
                        style="background:transparent; border:1.5px solid #EEEEEE; width:100%; text-align:left; font-family:inherit;">
                        <div class="icon-box red">
                            <i class="bi bi-box-arrow-right"></i>
                        </div>
                        <div class="menu-text">
                            <h5>Logout</h5>
                            <small>Keluar dari akun Anda</small>
                        </div>
                        <i class="bi bi-chevron-right arrow"></i>
                    </button>
                </form>

            </div>

            <hr class="divider" style="margin-bottom: 0;">

        </div>

    </div>

    <!-- Modal Edit Profil -->
    <div class="modal fade" id="editProfileModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:20px; border:none; box-shadow:0 20px 60px rgba(0,0,0,0.12);">
                <div class="modal-header"
                    style="border-bottom:1px solid #EEEEEE; padding:24px 28px 12px 28px; background:#FAFAFA; border-radius:20px 20px 0 0;">
                    <h4 style="font-weight:600; font-size:20px; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="bi bi-pencil-square" style="color:var(--brown);"></i>
                        Edit Profil
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('Profil.update') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body" style="padding:24px 28px 8px 28px;">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" style="font-weight:600; font-size:14px; color:#444;">Nama</label>
                                <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}"
                                    required
                                    style="border-radius:12px; padding:11px 16px; border:1.5px solid #E0E0E0; font-size:15px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-weight:600; font-size:14px; color:#444;">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ auth()->user()->email }}" required
                                    style="border-radius:12px; padding:11px 16px; border:1.5px solid #E0E0E0; font-size:15px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-weight:600; font-size:14px; color:#444;">Nomor
                                    Telepon</label>
                                <input type="text" name="phone" class="form-control"
                                    value="{{ auth()->user()->phone }}"
                                    style="border-radius:12px; padding:11px 16px; border:1.5px solid #E0E0E0; font-size:15px;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"
                        style="border-top:1px solid #EEEEEE; padding:14px 28px 22px 28px; background:#FAFAFA; border-radius:0 0 20px 20px;">
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal"
                            style="background:#F0EDEB; border:none; border-radius:50px; padding:10px 28px; font-weight:600; color:#555; transition:0.2s;">Batal</button>
                        <button type="submit" class="btn btn-save"
                            style="background:var(--brown); color:#fff; border:none; border-radius:50px; padding:10px 34px; font-weight:600; transition:0.2s;">
                            <i class="bi bi-check-circle me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Ganti Password -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:20px; border:none; box-shadow:0 20px 60px rgba(0,0,0,0.12);">
                <div class="modal-header"
                    style="border-bottom:1px solid #EEEEEE; padding:24px 28px 12px 28px; background:#FAFAFA; border-radius:20px 20px 0 0;">
                    <h4 style="font-weight:600; font-size:20px; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="bi bi-shield-lock-fill" style="color:var(--brown);"></i>
                        Ganti Password
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('Profil.changePassword') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body" style="padding:24px 28px 8px 28px;">
                        <div class="mb-3">
                            <label class="form-label" style="font-weight:600; font-size:14px; color:#444;">Password
                                Lama</label>
                            <div class="input-group">
                                <input type="password" name="current_password" id="current_password"
                                    class="form-control" placeholder="Masukkan password lama" required
                                    style="border-radius:12px 0 0 12px; padding:11px 16px; border:1.5px solid #E0E0E0; font-size:15px; border-right:none;">
                                <button class="btn password-toggle-btn" type="button"
                                    onclick="togglePassword('current_password', this)"
                                    style="border-radius:0 12px 12px 0; border:1.5px solid #E0E0E0; border-left:none; background:#FAFAFA; padding:0 16px;">
                                    <i class="bi bi-eye-slash" style="font-size:18px; color:#888;"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight:600; font-size:14px; color:#444;">Password
                                Baru</label>
                            <div class="input-group">
                                <input type="password" name="new_password" id="new_password" class="form-control"
                                    placeholder="Minimal 8 karakter" required
                                    style="border-radius:12px 0 0 12px; padding:11px 16px; border:1.5px solid #E0E0E0; font-size:15px; border-right:none;">
                                <button class="btn password-toggle-btn" type="button"
                                    onclick="togglePassword('new_password', this)"
                                    style="border-radius:0 12px 12px 0; border:1.5px solid #E0E0E0; border-left:none; background:#FAFAFA; padding:0 16px;">
                                    <i class="bi bi-eye-slash" style="font-size:18px; color:#888;"></i>
                                </button>
                            </div>
                            <small class="text-muted" style="font-size:13px; color:#999;"><i
                                    class="bi bi-info-circle"></i> Minimal 8 karakter</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight:600; font-size:14px; color:#444;">Konfirmasi
                                Password Baru</label>
                            <div class="input-group">
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                    class="form-control" placeholder="Konfirmasi password baru" required
                                    style="border-radius:12px 0 0 12px; padding:11px 16px; border:1.5px solid #E0E0E0; font-size:15px; border-right:none;">
                                <button class="btn password-toggle-btn" type="button"
                                    onclick="togglePassword('new_password_confirmation', this)"
                                    style="border-radius:0 12px 12px 0; border:1.5px solid #E0E0E0; border-left:none; background:#FAFAFA; padding:0 16px;">
                                    <i class="bi bi-eye-slash" style="font-size:18px; color:#888;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"
                        style="border-top:1px solid #EEEEEE; padding:14px 28px 22px 28px; background:#FAFAFA; border-radius:0 0 20px 20px;">
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal"
                            style="background:#F0EDEB; border:none; border-radius:50px; padding:10px 28px; font-weight:600; color:#555; transition:0.2s;">Batal</button>
                        <button type="submit" class="btn btn-save"
                            style="background:var(--brown); color:#fff; border:none; border-radius:50px; padding:10px 34px; font-weight:600; transition:0.2s;">
                            <i class="bi bi-check-circle me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Kelola Alamat -->
    <div class="modal fade" id="addressModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:20px; border:none; box-shadow:0 20px 60px rgba(0,0,0,0.12);">
                <div class="modal-header"
                    style="border-bottom:1px solid #EEEEEE; padding:24px 28px 12px 28px; background:#FAFAFA; border-radius:20px 20px 0 0;">
                    <h4 style="font-weight:600; font-size:20px; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="bi bi-geo-alt" style="color:var(--brown);"></i>
                        Kelola Alamat
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('Profil.updateAddress') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body" style="padding:24px 28px 8px 28px;">
                        <label class="form-label" style="font-weight:600; font-size:14px; color:#444;">Alamat</label>
                        <textarea name="address" class="form-control" rows="3"
                            style="border-radius:12px; padding:11px 16px; border:1.5px solid #E0E0E0; font-size:15px; resize:vertical;">{{ auth()->user()->address }}</textarea>
                    </div>
                    <div class="modal-footer"
                        style="border-top:1px solid #EEEEEE; padding:14px 28px 22px 28px; background:#FAFAFA; border-radius:0 0 20px 20px;">
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal"
                            style="background:#F0EDEB; border:none; border-radius:50px; padding:10px 28px; font-weight:600; color:#555; transition:0.2s;">Batal</button>
                        <button type="submit" class="btn btn-save"
                            style="background:var(--brown); color:#fff; border:none; border-radius:50px; padding:10px 34px; font-weight:600; transition:0.2s;">
                            <i class="bi bi-check-circle me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('photoInput');
            input.addEventListener('change', function() {
                if (!this.files.length) return;
                const preview = document.getElementById('previewPhoto');
                if (preview) {
                    preview.src = URL.createObjectURL(this.files[0]);
                }
                document.getElementById('photoForm').submit();
            });
        });

        function togglePassword(id, button) {
            const input = document.getElementById(id);
            const icon = button.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        }
    </script>

@endsection
