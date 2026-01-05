<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EatJoy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #6C63FF;
            --secondary: #4A90E2;
            --accent: #FF6584;
            --light: #F8F9FF;
            --dark: #2D3436;
            --gradient: linear-gradient(135deg, #6C63FF 0%, #4A90E2 100%);
            --card-shadow: 0 20px 40px rgba(108, 99, 255, 0.15);
        }

        * { font-family: 'Poppins', sans-serif; }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 80%, rgba(108, 99, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(74, 144, 226, 0.1) 0%, transparent 50%);
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 2;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(108, 99, 255, 0.2);
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 5px;
            background: var(--gradient);
        }

        .login-header {
            padding: 40px 40px 20px;
            text-align: center;
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 10px;
        }

        .logo-text {
            font-size: 2rem;
            font-weight: 700;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-body { padding: 0 40px 40px; }

        .welcome-text {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 1rem;
        }

        .form-group { margin-bottom: 25px; }

        .form-label {
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 8px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-label i {
            color: var(--primary);
            font-size: 1.1rem;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-control {
            height: 48px;
            padding: 0 45px 0 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
            width: 100%;
            background: #fff;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.1);
            outline: none;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-size: 1.2rem;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            font-size: 1.2rem;
            padding: 5px;
            transition: color 0.3s;
        }

        .toggle-password:hover { color: var(--primary); }

        .btn-login {
            background: var(--gradient);
            color: white;
            border: none;
            height: 50px;
            width: 100%;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(108, 99, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(108, 99, 255, 0.4);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: #999;
            font-size: 0.9rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e0e0e0;
        }

        .divider span { padding: 0 15px; }

        /* === Tombol Google === */
        .social-login {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
            margin-bottom: 25px;
        }

        .social-btn {
            height: 48px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: 600;
            color: var(--dark);
            text-decoration: none;
            transition: all 0.3s;
        }

        .social-btn:hover {
            border-color: var(--primary);
            background: #f8f9ff;
            transform: translateY(-2px);
            text-decoration: none;
        }

        .social-btn.google i {
            color: #DB4437;
            font-size: 1.2rem;
        }

        .login-footer {
            padding: 25px 40px;
            text-align: center;
            border-top: 1px solid #eee;
            background: #f8f9ff;
        }

        .login-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .login-footer a:hover {
            color: var(--secondary);
            text-decoration: underline;
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px;
            margin-bottom: 20px;
            animation: slideDown 0.3s ease;
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(255, 101, 132, 0.1), rgba(255, 154, 139, 0.1));
            color: #d32f2f;
            border-left: 4px solid #d32f2f;
        }

        .alert i { margin-right: 10px; }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Loading state */
        .btn-login.loading { pointer-events: none; }
        .btn-login.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .is-invalid { border-color: #dc3545 !important; }
        .invalid-feedback {
            display: block;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: #dc3545;
        }

        @media (max-width: 576px) {
            .login-header { padding: 30px 25px 15px; }
            .login-body { padding: 0 25px 30px; }
            .login-footer { padding: 20px 25px; }
            .logo-text { font-size: 1.8rem; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-container">
                    <h1 class="logo-text">EatJoy</h1>
                </div>
                <p class="welcome-text">Selamat datang kembali! Masuk untuk melanjutkan perjalanan sehatmu</p>
            </div>

            <div class="login-body">
                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <div>{{ $errors->first() }}</div>
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label" for="username">
                            <i class="bi bi-person"></i>Username
                        </label>
                        <div class="input-group">
                            <span class="input-icon"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" id="username" name="username"
                                   placeholder="Masukkan username Anda" required value="{{ old('username') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">
                            <i class="bi bi-lock"></i>Password
                        </label>
                        <div class="input-group">
                            <span class="input-icon"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Masukkan password Anda" required>
                            <button type="button" class="toggle-password" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-login" id="loginButton">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Masuk ke Akun
                    </button>

                    <div class="divider">
                        <span>atau masuk dengan</span>
                    </div>

                    <!-- ✅ Tombol Google -->
                    <div class="social-login">
                        <a href="{{ route('google.redirect') }}" class="social-btn google">
                            <i class="bi bi-google"></i>
                            Masuk dengan Google
                        </a>
                    </div>

                    <div class="login-footer">
                        <p class="mb-0">
                            Belum punya akun?
                            <a href="{{ route('register') }}">Daftar sekarang</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = togglePassword.querySelector('i');

            togglePassword.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.remove('bi-eye');
                    eyeIcon.classList.add('bi-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.remove('bi-eye-slash');
                    eyeIcon.classList.add('bi-eye');
                }
            });

            const loginForm = document.getElementById('loginForm');
            const loginButton = document.getElementById('loginButton');

            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const username = document.getElementById('username').value.trim();
                const password = document.getElementById('password').value.trim();
                let isValid = true;

                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

                if (!username) { showValidationError('username', 'Username wajib diisi'); isValid = false; }
                if (!password) { showValidationError('password', 'Password wajib diisi'); isValid = false; }

                if (isValid) {
                    loginButton.classList.add('loading');
                    loginButton.innerHTML = '';
                    setTimeout(() => loginForm.submit(), 800);
                }
            });

            document.getElementById('username').focus();
        });

        function showValidationError(fieldId, message) {
            const field = document.getElementById(fieldId);
            field.classList.add('is-invalid');

            const errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback';
            errorDiv.textContent = message;
            field.parentElement.appendChild(errorDiv);

            field.focus();

            setTimeout(() => {
                field.classList.remove('is-invalid');
                errorDiv.remove();
            }, 3000);
        }
    </script>
</body>
</html>
