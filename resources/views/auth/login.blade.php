@extends('app')

@section('title', 'Login')

@section('content')
    <div class="login-container d-flex justify-content-center align-items-center" style="min-height: 85vh; padding: 2rem 1rem;">
        <div class="row w-100" style="max-width: 1000px;">
            {{-- Left Side - Illustration/Info --}}
            <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center left-side">
                <div class="text-center text-white p-4">
                    <div class="illustration-icon mb-4">
                        <i class="bi bi-smartwatch" style="font-size: 8rem;"></i>
                    </div>
                    <h2 class="fw-bold mb-3">Jam Termurah Sejagat Raya</h2>
                    <p class="lead mb-4">Temukan jam impian Anda dengan harga terbaik dan kualitas terjamin</p>
                    <div class="features">
                        <div class="feature-item mb-3">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <span>Harga Terjangkau</span>
                        </div>
                        <div class="feature-item mb-3">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <span>Kualitas Terpercaya</span>
                        </div>
                        <div class="feature-item mb-3">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <span>Proses Cepat & Mudah</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side - Login Form --}}
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 login-card">
                    <div class="card-body p-4 p-md-5">
                        {{-- Header --}}
                        <div class="text-center mb-4">
                            <div class="icon-circle mb-3">
                                <i class="bi bi-person-circle" style="font-size: 3rem;"></i>
                            </div>
                            <h3 class="fw-bold">
                                <span class="text-gradient">Selamat Datang Kembali!</span>
                            </h3>
                            <p class="text-muted mb-0">Masuk untuk melanjutkan belanja</p>
                        </div>

                        {{-- Alert Error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                                    <div class="flex-grow-1">
                                        @foreach ($errors->all() as $error)
                                            <div>{{ $error }}</div>
                                        @endforeach
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Form --}}
                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf

                            {{-- Email --}}
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="bi bi-envelope text-secondary me-2"></i>Email
                                </label>
                                <div class="input-group input-group-lg shadow-sm">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope text-secondary"></i>
                                    </span>
                                    <input type="email" 
                                           name="email" 
                                           class="form-control border-start-0 ps-0" 
                                           id="email"
                                           placeholder="contoh@email.com" 
                                           required 
                                           value="{{ old('email') }}"
                                           autofocus>
                                </div>
                            </div>

                            {{-- Password --}}
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="bi bi-lock text-secondary me-2"></i>Password
                                </label>
                                <div class="input-group input-group-lg shadow-sm">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock text-secondary"></i>
                                    </span>
                                    <input type="password" 
                                           name="password" 
                                           class="form-control border-start-0 border-end-0 ps-0" 
                                           id="password" 
                                           placeholder="••••••••"
                                           required>
                                    <span class="input-group-text bg-light border-start-0 cursor-pointer" onclick="togglePassword()">
                                        <i class="bi bi-eye text-secondary" id="toggleIcon"></i>
                                    </span>
                                </div>
                            </div>

                            {{-- Remember Me & Forgot Password --}}
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label small" for="remember">
                                        Ingat saya
                                    </label>
                                </div>
                                <a href="#" class="text-decoration-none small text-secondary">Lupa password?</a>
                            </div>

                            {{-- Button --}}
                            <button type="submit" class="btn btn-secondary btn-lg w-100 fw-semibold shadow-sm btn-login mb-4">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                            </button>

                            {{-- Link Register --}}
                            <div class="text-center">
                                <p class="text-muted mb-0">
                                    Belum punya akun? 
                                    <a href="{{ route('register') }}" class="fw-semibold text-decoration-none text-dark">
                                        Daftar Sekarang
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Enhanced Styles - Grey Theme --}}
    <style>
        .login-container {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -150px;
            right: -150px;
        }

        .login-container::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -200px;
            left: -200px;
        }

        .left-side {
            position: relative;
            z-index: 1;
        }

        .illustration-icon {
            animation: float 3s ease-in-out infinite;
            color: #e5e7eb;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .feature-item {
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            color: #f3f4f6;
        }

        .feature-item i {
            color: #d1d5db;
        }

        .login-card {
            border-radius: 20px;
            background: #fff;
            position: relative;
            z-index: 1;
            border: 1px solid #e5e7eb;
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .text-gradient {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .input-group-lg {
            border-radius: 10px;
            overflow: hidden;
        }

        .input-group-lg .form-control,
        .input-group-lg .input-group-text {
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
        }

        .input-group-lg .form-control:focus {
            border-color: #6b7280;
            box-shadow: 0 0 0 0.2rem rgba(107, 114, 128, 0.25);
            background-color: #fff;
        }

        .cursor-pointer {
            cursor: pointer;
            user-select: none;
        }

        .btn-login {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            border: none;
            padding: 0.75rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            color: white;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(107, 114, 128, 0.4);
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
        }

        .divider {
            position: relative;
            text-align: center;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 45%;
            height: 1px;
            background: #e5e7eb;
        }

        .divider::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            width: 45%;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            background: white;
            padding: 0 1rem;
            color: #9ca3af;
            font-size: 0.875rem;
        }

        .social-btn {
            border-radius: 10px;
            padding: 0.5rem;
            transition: all 0.3s ease;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .social-btn:not(:disabled):hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .alert {
            border-radius: 12px;
        }

        .form-check-input:checked {
            background-color: #6b7280;
            border-color: #6b7280;
        }

        .form-check-input:focus {
            border-color: #6b7280;
            box-shadow: 0 0 0 0.2rem rgba(107, 114, 128, 0.25);
        }

        @media (max-width: 991.98px) {
            .login-container {
                min-height: 100vh;
                padding: 1rem;
            }

            .login-card {
                margin-top: 1rem;
            }
        }

        @media (max-width: 576px) {
            .icon-circle {
                width: 60px;
                height: 60px;
            }

            .icon-circle i {
                font-size: 2rem !important;
            }

            .card-body {
                padding: 1.5rem !important;
            }
        }
    </style>

    {{-- JavaScript --}}
    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }

        // Form validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (!email || !password) {
                e.preventDefault();
                alert('Email dan password harus diisi!');
                return false;
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Format email tidak valid!');
                return false;
            }
        });

        // Auto-focus email input on page load
        window.addEventListener('load', function() {
            document.getElementById('email').focus();
        });
    </script>
@endsection