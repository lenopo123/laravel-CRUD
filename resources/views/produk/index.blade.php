{{-- resources/views/produk/index.blade.php --}}
@extends('app')

@section('title', 'Daftar Jam')

@section('content')
    <div class="container mt-4 mb-5">
        {{-- Header Section --}}
        <div class="row align-items-center mb-4">
            <div class="col-md-8">
                <h2 class="fw-bold mb-2">
                    <i class="bi bi-smartwatch me-2 text-primary"></i> 
                    <span class="text-gradient">Daftar Jam</span>
                </h2>
                <p class="text-muted mb-0">
                    <i class="bi bi-shop me-1"></i> Jam Termurah Sejagat Raya
                </p>
            </div>

            {{-- Tombol tambah produk untuk admin --}}
            @auth
                @if (auth()->user()->role === 'admin')
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="{{ route('produk.create') }}" class="btn btn-primary shadow-sm btn-add">
                            <i class="bi bi-plus-circle me-2"></i> Tambah Produk
                        </a>
                    </div>
                @endif
            @endauth
        </div>

        {{-- Pesan sukses / error --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div>{{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Cek apakah ada produk --}}
        @if ($produk->isEmpty())
            <div class="empty-state text-center py-5">
                <i class="bi bi-smartwatch display-1 text-muted mb-3"></i>
                <h4 class="text-muted">Tidak ada produk tersedia</h4>
                <p class="text-muted">Belum ada produk yang ditambahkan ke dalam sistem</p>
                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('produk.create') }}" class="btn btn-primary mt-3">
                            <i class="bi bi-plus-circle me-2"></i> Tambah Produk Pertama
                        </a>
                    @endif
                @endauth
            </div>
        @else
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">
                @foreach ($produk as $p)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm produk-card">
                            {{-- Badge Stok di atas gambar --}}
                            <div class="position-relative">
                                @if ($p->gambar)
                                    <img src="{{ asset('storage/' . $p->gambar) }}" 
                                        alt="{{ $p->nama }}"
                                        class="card-img-top produk-img"
                                        style="height: 250px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                         style="height: 250px;">
                                        <i class="bi bi-smartwatch text-muted" style="font-size: 4rem;"></i>
                                    </div>
                                @endif
                                
                                {{-- Badge Stok --}}
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge {{ $p->stok > 0 ? 'bg-success' : 'bg-danger' }} shadow-sm px-3 py-2">
                                        @if ($p->stok > 0)
                                            <i class="bi bi-check-circle me-1"></i> Stok: {{ $p->stok }}
                                        @else
                                            <i class="bi bi-x-circle me-1"></i> Habis
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold mb-2 text-truncate" title="{{ $p->nama }}">
                                    {{ $p->nama }}
                                </h5>
                                
                                <p class="card-text text-muted small mb-3 flex-grow-1" style="min-height: 40px;">
                                    {{ Str::limit($p->deskripsi ?? 'Tidak ada deskripsi.', 60) }}
                                </p>

                                {{-- Harga --}}
                                <div class="price-tag mb-3">
                                    <span class="fs-5 fw-bold text-primary">
                                        Rp{{ number_format($p->harga, 0, ',', '.') }}
                                    </span>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="mt-auto">
                                    @auth
                                        @if (auth()->user()->role === 'admin')
                                            <div class="btn-group w-100" role="group">
                                                <a href="{{ route('produk.edit', $p->id) }}"
                                                    class="btn btn-outline-warning btn-action">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-outline-danger btn-action"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal-{{ $p->id }}">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </div>
                                        @else
                                            <a href="{{ route('produk.buy', $p->id) }}"
                                                class="btn btn-success w-100 btn-buy {{ $p->stok == 0 ? 'disabled' : '' }}">
                                                <i class="bi bi-cart-plus me-2"></i> 
                                                {{ $p->stok == 0 ? 'Stok Habis' : 'Beli Sekarang' }}
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">
                                            <i class="bi bi-box-arrow-in-right me-2"></i> Login untuk Beli
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Modal Konfirmasi Hapus - Di luar loop --}}
    @auth
        @if (auth()->user()->role === 'admin')
            @foreach ($produk as $p)
                <div class="modal fade" id="deleteModal-{{ $p->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $p->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fw-bold" id="deleteModalLabel-{{ $p->id }}">
                                    <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                                    Konfirmasi Hapus
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body py-4">
                                <p class="mb-2">Apakah Anda yakin ingin menghapus produk:</p>
                                <div class="alert alert-light border mb-3">
                                    <strong class="text-dark">{{ $p->nama }}</strong>
                                </div>
                                <p class="text-muted small mb-0">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Tindakan ini tidak dapat dibatalkan dan semua data terkait akan dihapus secara permanen.
                                </p>
                            </div>
                            <div class="modal-footer border-0 pt-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle me-1"></i> Batal
                                </button>
                                <form method="POST" action="{{ route('produk.destroy', $p->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash me-1"></i> Ya, Hapus Produk
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    @endauth

    {{-- Enhanced Styles --}}
    <style>
        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-add {
            padding: 0.625rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }

        .produk-card {
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: #fff;
        }

        .produk-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .produk-img {
            transition: transform 0.3s ease;
        }

        .produk-card:hover .produk-img {
            transform: scale(1.05);
        }

        .price-tag {
            padding: 0.5rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            text-align: center;
        }

        .btn-action {
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }

        .btn-buy {
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-buy:not(.disabled):hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(25, 135, 84, 0.3);
        }

        .alert {
            border-radius: 12px;
            padding: 1rem 1.25rem;
        }

        .empty-state {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 3rem 1rem;
        }

        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header .btn-close {
            padding: 0.75rem;
        }

        .modal-footer .btn {
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
        }

        @media (max-width: 576px) {
            .produk-card {
                margin-bottom: 1rem;
            }
            
            .btn-add {
                width: 100%;
            }
        }
    </style>
@endsection