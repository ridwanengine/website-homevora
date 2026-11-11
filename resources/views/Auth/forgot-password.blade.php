<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Lupa Password</title>

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
            font-family: 'Segoe UI', sans-serif;
            position: relative;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            z-index: -1;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, .15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, .3);
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .25);
        }

        .login-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-header img {
            width: 80px;
            margin-bottom: 10px;
        }

        .login-header h3 {
            color: #000;
            font-weight: 700;
        }

        .login-header p {
            color: #fff;
            margin: 0;
            font-size: .95rem;
        }

        .form-label {
            color: #000;
            font-weight: 600;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-reset {
            background: #6c757d;
            color: #fff;
            border: none;
            width: 100%;
            border-radius: 8px;
            padding: 10px;
            font-weight: 600;
        }

        .btn-reset:hover {
            background: #5a6268;
        }

        .back-login {
            color: #000;
            font-weight: 600;
        }

        .back-login:hover {
            color: #333;
        }
    </style>

</head>

<body>

    <div class="login-container">

        <div class="login-card">

            <div class="login-header">

                <img src="{{ asset('images/logo.png') }}" alt="Logo">

                <h3>Lupa Password</h3>

                <p>Masukkan email untuk menerima link reset password.</p>

            </div>

            @if (session('status'))
                <div class="alert alert-success">

                    {{ session('status') }}

                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">

                    {{ $errors->first() }}

                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">

                @csrf

                <div class="mb-3">

                    <label class="form-label">
                        Email
                    </label>

                    <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                        placeholder="contoh@email.com" required>

                </div>

                <button class="btn btn-reset">

                    <i class="fas fa-paper-plane me-2"></i>

                    Kirim Link Reset Password

                </button>

            </form>

            <div class="text-center mt-3">

                <a href="{{ route('login') }}" class="text-decoration-none back-login">

                    <i class="fas fa-arrow-left"></i>

                    Kembali ke Login

                </a>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
