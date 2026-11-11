<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

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

        /* overlay gelap */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }

        /* container */
        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* card glass */
        .register-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);

            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.3);

            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);

            max-width: 350px;
            width: 100%;
            padding: 1.5rem;
        }

        /* header */
        .register-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .register-header i {
            font-size: 2.5rem;
            color: #0d6efd;
            margin-bottom: 0.75rem;
        }

        .register-header h3 {
            font-weight: 700;
            font-size: 1.3rem;
            color: #000;
        }

        /* input */
        .form-control {
            border-radius: 6px;
            border: 1px solid #ddd;
            padding: 0.5rem 0.75rem;
            font-size: 0.85rem;
            background: #fff;
        }

        /* focus */
        .form-control:focus {
            border-color: #0d6efd;
            color: #000;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        /* label */
        .form-label {
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
            color: #000;
        }

        /* tombol daftar */
        .btn-register {
            background: #0d6efd;
            border: none;
            border-radius: 6px;
            padding: 0.6rem;
            width: 100%;
            font-weight: 500;
        }

        .btn-register:hover {
            background: #0b5ed7;
        }

        /* 🔥 FIX INPUT GROUP (MATA NYATU) */
        .input-group {
            border-radius: 6px;
            overflow: hidden;
        }

        .input-group .form-control {
            border-right: none;
        }

        /* tombol mata */
        .input-group .btn {
            background: #fff !important;
            border: 1px solid #ddd !important;
            border-left: none !important;
            color: #555;
        }

        /* hover tetap halus */
        .input-group .btn:hover {
            background: #fff !important;
            color: #000;
        }

        /* hilangkan efek klik */
        .input-group .btn:focus {
            box-shadow: none !important;
            outline: none !important;
        }

        /* icon */
        .input-group .btn i {
            color: #555;
        }

        .login-link {
            font-size: 1rem;
            color: #000;
            font-weight: 500;
        }
    </style>
</head>

<body>

    <div class="register-container">
        <div class="register-card">

            <div class="register-header";">
                <i class="fas fa-user-plus"></i>
                <h3>Daftar Akun</h3>
                <p class="text-muted" style="color:#fff !important; font-weight: 500;">Buat akun baru untuk melanjutkan</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}">
                @csrf

                <!-- Nama -->
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" required >
                        <button type="button" class="btn" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-3" style="color: #000000;">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control" required>
                        <button type="button" class="btn" id="toggleConfirmPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-register text-white">
                    <i class="fas fa-user-plus me-2"></i>Daftar
                </button>
            </form>


            <div class="text-center mt-3">
                <small class="login-link">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="fw-semibold text-decoration-none" style="color: #fff;">
                        Login di sini
                    </a>
                </small>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';

            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const input = document.getElementById('password_confirmation');
            input.type = input.type === 'password' ? 'text' : 'password';

            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>

</body>

</html>
