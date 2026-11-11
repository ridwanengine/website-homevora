<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    {{-- logo --}}
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">

    <style>
        body {
            background: url('{{ asset('images/background home.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
        }

        /* 🔥 Overlay gelap */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            /* atur gelap di sini */
            z-index: -1;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.15);
            /* transparan */
            backdrop-filter: blur(10px);
            /* efek blur 🔥 */
            -webkit-backdrop-filter: blur(10px);
            /* support Safari */

            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            /* garis tipis elegan */

            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            /* shadow lebih halus */

            max-width: 350px;
            width: 100%;
            padding: 1.5rem;
        }

        .login-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .login-header i {
            font-size: 2.5rem;
            color: #0d6efd;
            margin-bottom: 0.75rem;
        }

        .login-header h3 {
            color: #000 !important;
            font-weight: 600;
            font-size: 2.4rem;
            margin-bottom: 0.25rem;
        }

        .login-header p {
            color: #ffffff;
            font-size: 1.8rem;
            margin: 0;
        }

        .form-control {
            border-radius: 6px;
            border: 1px solid #ddd;
            padding: 0.5rem 0.75rem;
            font-size: 0.85rem;
        }

        .form-control:focus {
            border-color: #0d6efd;
            color: #000 !important;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
            color: #000000 !important;
        }

        .btn-login {
            background: #0d6efd;
            border: none;
            border-radius: 6px;
            padding: 0.5rem;
            font-weight: 500;
            font-size: 0.85rem;
            width: 100%;
        }

        .btn-login:hover {
            background: #0b5ed7;
        }

        .alert {
            border-radius: 6px;
            font-size: 0.8rem;
            margin-bottom: 1rem;
            padding: 0.5rem 0.75rem;
        }


        .form-check-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #000000 !important;
        }

        .forgot-link {
            font-size: 0.8rem;
            color: #000 !important;
            font-weight: 600;
        }

        .forgot-link:hover {
            color: #333 !important;
        }

        /* 🔥 BIKIN MATA NYATU DENGAN INPUT */
        .input-group {
            border-radius: 6px;
            overflow: hidden;
        }

        .input-group .form-control {
            background: #fff;
            border: 1px solid #ddd;
            border-right: none;
        }

        /* tombol mata */
        .input-group .btn {
            background: #fff !important;
            border: 1px solid #ddd !important;
            border-left: none !important;
            color: #555;
        }

        /* hover tetap sama */
        .input-group .btn:hover {
            background: #fff !important;
        }

        /* hilangkan efek klik */
        .input-group .btn:focus {
            box-shadow: none;
        }

        /* icon */
        .input-group .btn i {
            color: #555;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 1.25rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mb-2"
                    style="width: 80px; height: 80px;">
                <h3>Login</h3>
                <p>Selamat Datang</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Success Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Status Message (Laravel 12 built-in) -->
            @if (session('status'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        placeholder="contoh@email.com">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" required autocomplete="current-password"
                            placeholder="Masukkan password">
                        <button class="btn" type="button" id="togglePassword">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            Ingat Saya
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="#" class="text-decoration-none forgot-link">
                            Lupa Password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-login text-white">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </button>
                <!-- Register Link -->
                <div class="text-center mt-3" style="color: #000000 !important; font-weight: 500;">
                    <small">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-decoration-none fw-semibold "
                            style="color: #ffffff !important;">
                            Daftar sekarang
                        </a>
                        </small>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const icon = togglePassword.querySelector('i');

        togglePassword.addEventListener('click', function() {

            if (password.type === "password") {
                password.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                password.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }

        });

        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
</body>

</html>
