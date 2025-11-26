@extends('app')

@section('title', 'Register')

@section('content')
    <div class="register-container d-flex justify-content-center align-items-center" style="min-height: 85vh; padding: 2rem 1rem;">
        <div class="row w-100" style="max-width: 1000px;">
            {{-- Left Side - Illustration/Info --}}
            <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center left-side">
                <div class="text-center text-dark p-4">
                    <div class="illustration-icon mb-4">
                        <i class="bi bi-clock" style="font-size: 8rem;"></i>
                    </div>
                    <h2 class="fw-bold mb-3">Jam Termurah Sejagat Raya</h2>
                    <p class="lead mb-4">Daftar sekarang dan dapatkan pengalaman belanja terbaik</p>
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

            {{-- Right Side - Register Form --}}
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 register-card">
                    <div class="card-body p-4 p-md-5">
                        {{-- Header --}}
                        <div class="text-center mb-4">
                            <div class="icon-circle mb-3">
                                <i class="bi bi-person-circle" style="font-size: 3rem;"></i>
                            </div>
                            <h3 class="fw-bold">
                                <span class="text-gradient">Buat Akun Baru</span>
                            </h3>
                            <p class="text-muted mb-0">Daftar sekarang dan mulai belanja</p>
                        </div>

                        {{-- Alert Error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                                    <div class="flex-grow-1">
                                        <strong>Terjadi kesalahan:</strong>
                                        <ul class="mb-0 mt-2 ps-3">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Form --}}
                        <form method="POST" action="{{ route('register') }}" id="registerForm">
                            @csrf

                            {{-- Name --}}
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="bi bi-person text-primary me-2"></i>Nama Lengkap
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg shadow-sm">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" 
                                           name="name" 
                                           class="form-control border-start-0 ps-0" 
                                           id="name" 
                                           placeholder="Masukkan nama lengkap" 
                                           value="{{ old('name') }}" 
                                           required
                                           autofocus>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="bi bi-envelope text-primary me-2"></i>Email
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg shadow-sm">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" 
                                           name="email" 
                                           class="form-control border-start-0 ps-0" 
                                           id="email" 
                                           placeholder="contoh@email.com" 
                                           value="{{ old('email') }}" 
                                           required>
                                </div>
                            </div>

                            {{-- Password --}}
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="bi bi-lock text-primary me-2"></i>Password
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg shadow-sm">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" 
                                           name="password" 
                                           class="form-control border-start-0 border-end-0 ps-0" 
                                           id="password" 
                                           placeholder="Minimal 8 karakter"
                                           required>
                                    <span class="input-group-text bg-light border-start-0 cursor-pointer" onclick="togglePassword('password', 'toggleIcon1')">
                                        <i class="bi bi-eye" id="toggleIcon1"></i>
                                    </span>
                                </div>
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>Minimal 8 karakter dengan kombinasi huruf dan angka
                                </div>
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-semibold">
                                    <i class="bi bi-shield-lock text-primary me-2"></i>Konfirmasi Password
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg shadow-sm">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-shield-lock"></i>
                                    </span>
                                    <input type="password" 
                                           name="password_confirmation" 
                                           class="form-control border-start-0 border-end-0 ps-0" 
                                           id="password_confirmation" 
                                           placeholder="Ulangi password"
                                           required>
                                    <span class="input-group-text bg-light border-start-0 cursor-pointer" onclick="togglePassword('password_confirmation', 'toggleIcon2')">
                                        <i class="bi bi-eye" id="toggleIcon2"></i>
                                    </span>
                                </div>
                            </div>

                            {{-- Terms & Conditions --}}
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label small" for="terms">
                                    Saya menyetujui <a href="#" class="text-decoration-none">Syarat & Ketentuan</a> yang berlaku
                                </label>
                            </div>

                            {{-- Button --}}
                            <button type="submit" class="btn btn-primary btn-lg w-100 fw-semibold shadow-sm btn-register mb-4">
                                <i class="bi bi-check-circle me-2"></i>Daftar Sekarang
                            </button>

                            {{-- Link Login --}}
                            <div class="text-center">
                                <p class="text-muted mb-0">
                                    Sudah punya akun? 
                                    <a href="{{ route('login') }}" class="fw-semibold text-decoration-none text-primary">
                                        Masuk Di Sini
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Enhanced Styles --}}
    <style>
        .register-container {
            background: linear-gradient(135deg, #6b7280 0%, #9ca3af 100%);
            position: relative;
            overflow: hidden;
        }

        .register-container::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -150px;
            right: -150px;
        }

        .register-container::after {
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
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .feature-item {
            display: flex;
            align-items: center;
            font-size: 1.1rem;
        }

        .register-card {
            border-radius: 20px;
            background: #fff;
            position: relative;
            z-index: 1;
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #6b7280 0%, #9ca3af 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .text-gradient {
            background: linear-gradient(135deg, #6b7280 0%, #9ca3af 100%);
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
        }

        .input-group-lg .form-control:focus {
            border-color: #6b7280;
            box-shadow: none;
        }

        .cursor-pointer {
            cursor: pointer;
            user-select: none;
        }

        .btn-register {
            background: linear-gradient(135deg, #6b7280 0%, #9ca3af 100%);
            border: none;
            padding: 0.75rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(107, 114, 128, 0.4);
        }

        .alert {
            border-radius: 12px;
        }

        .form-check-input:checked {
            background-color: #6b7280;
            border-color: #6b7280;
        }

        @media (max-width: 991.98px) {
            .register-container {
                min-height: 100vh;
                padding: 1rem;
            }

            .register-card {
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
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            
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
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            const terms = document.getElementById('terms').checked;

            // Check if all fields are filled
            if (!name || !email || !password || !passwordConfirmation) {
                e.preventDefault();
                alert('Semua field harus diisi!');
                return false;
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Format email tidak valid!');
                return false;
            }

            // Password length validation
            if (password.length < 8) {
                e.preventDefault();
                alert('Password minimal 8 karakter!');
                return false;
            }

            // Password match validation
            if (password !== passwordConfirmation) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
                return false;
            }

            // Terms validation
            if (!terms) {
                e.preventDefault();
                alert('Anda harus menyetujui Syarat & Ketentuan!');
                return false;
            }
        });

        // Auto-focus name input on page load
        window.addEventListener('load', function() {
            document.getElementById('name').focus();
        });

        // Real-time password match indicator
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmation = this.value;
            
            if (confirmation && password !== confirmation) {
                this.style.borderColor = '#ef4444';
            } else if (confirmation && password === confirmation) {
                this.style.borderColor = '#6b7280';
            } else {
                this.style.borderColor = '#e5e7eb';
            }
        });
    </script>
@endsection