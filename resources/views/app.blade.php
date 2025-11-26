<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Jam')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        .navbar {
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: transform 0.2s;
        }
        
        .navbar-brand:hover {
            transform: translateY(-2px);
        }
        
        .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }
        
        .nav-link.active {
            background-color: rgba(255,255,255,0.2);
            font-weight: 600;
        }
        
        .nav-link i {
            font-size: 1.1rem;
        }
        
        .btn-logout {
            background: none;
            border: none;
            color: rgba(255,255,255,0.85);
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        
        .btn-logout:hover {
            background-color: rgba(220,53,69,0.2);
            color: #fff;
            transform: translateY(-2px);
        }
        
        .navbar-toggler {
            border: 2px solid rgba(255,255,255,0.3);
            padding: 0.5rem 0.75rem;
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.25rem rgba(255,255,255,0.2);
        }
        
        @media (max-width: 991.98px) {
            .navbar-nav {
                padding-top: 1rem;
            }
            
            .nav-item {
                margin-bottom: 0.5rem;
            }
            
            .nav-link {
                padding: 0.75rem 1rem !important;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-shop me-2"></i>Toko Jam
            </a> <!-- TAG INI YANG DIPERBAIKI -->

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    @auth
                        <!-- Menu untuk Semua User -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('produk.index') ? 'active' : '' }}" 
                               href="{{ route('produk.index') }}">
                               <i class="bi bi-box-seam me-2"></i>Produk
                            </a>
                        </li>
                        
                        <!-- Menu khusus Admin -->
                        @if(auth()->user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('management.purchases') ? 'active' : '' }}" 
                               href="{{ route('management.purchases') }}">
                               <i class="bi bi-gear-fill me-2"></i>Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('produk.create') ? 'active' : '' }}" 
                               href="{{ route('produk.create') }}">
                               <i class="bi bi-plus-circle-fill me-2"></i>Tambah Produk
                            </a>
                        </li>
                        @else
                        <!-- Menu "Pembelian Saya" hanya untuk USER BIASA -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('purchase.purchases') ? 'active' : '' }}" 
                               href="{{ route('purchase.purchases') }}">
                               <i class="bi bi-bag-check-fill me-2"></i>Pembelian Saya
                            </a>
                        </li>
                        @endif

                        <!-- User Info & Logout -->
                        <li class="nav-item dropdown ms-lg-2">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-2"></i>{{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <span class="dropdown-item-text text-muted small">
                                        <i class="bi bi-shield-check me-1"></i>{{ ucfirst(auth()->user()->role) }}
                                    </span>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item text-danger" type="submit">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <!-- Menu untuk Guest -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" 
                               href="{{ route('register') }}">
                               <i class="bi bi-person-plus me-2"></i>Register
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" 
                               href="{{ route('login') }}">
                               <i class="bi bi-box-arrow-in-right me-2"></i>Login
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>