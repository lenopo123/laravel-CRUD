@extends('app')

@section('title', 'Management Pembelian')

@section('content')
<div class="container mt-4 mb-5">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('produk.index') }}" class="text-decoration-none"><i class="bi bi-house-door"></i> Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Management Pembelian</li>
        </ol>
    </nav>

    {{-- Header Section --}}
    <div class="header-section mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="fw-bold mb-2">
                    <i class="bi bi-gear-fill me-2 text-secondary"></i>
                    <span class="text-gradient">Management Pembelian</span>
                </h2>
                <p class="text-muted mb-0">
                    <i class="bi bi-kanban me-1"></i>Kelola semua transaksi pembelian customer
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="stats-card">
                    <small class="text-muted d-block">Total Transaksi</small>
                    <h4 class="fw-bold text-white mb-0">{{ $purchases->count() }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Empty State --}}
    @if($purchases->isEmpty())
        <div class="empty-state text-center py-5">
            <div class="empty-icon mb-4">
                <i class="bi bi-inbox display-1 text-muted"></i>
            </div>
            <h4 class="text-muted mb-3">Belum Ada Transaksi</h4>
            <p class="text-muted mb-0">Belum ada transaksi pembelian dari customer</p>
        </div>
    @else
        {{-- Desktop Table View --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden d-none d-lg-block">
            <div class="table-responsive">
                <table class="table table-hover mb-0 management-table">
                    <thead class="table-header">
                        <tr>
                            <th class="text-center" style="width: 60px;">#</th>
                            <th style="min-width: 180px;">Customer</th>
                            <th style="min-width: 250px;">Produk</th>
                            <th class="text-center" style="width: 80px;">jumlah</th>
                            <th class="text-center" style="width: 130px;">Total</th>
                            <th class="text-center" style="width: 150px;">Status</th>
                            <th class="text-center" style="width: 140px;">Tanggal</th>
                            <th class="text-center" style="width: 160px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchases as $purchase)
                            <tr class="purchase-row">
                                <td class="text-center fw-semibold">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="customer-info">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="bi bi-person-circle text-secondary me-2 fs-5"></i>
                                            <strong>{{ $purchase->user->name ?? 'User Dihapus' }}</strong>
                                        </div>
                                        <small class="text-muted">
                                            <i class="bi bi-envelope me-1"></i>{{ $purchase->user->email ?? '-' }}
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($purchase->produk && $purchase->produk->gambar)
                                            <img src="{{ asset('storage/' . $purchase->produk->gambar) }}" 
                                                 alt="{{ $purchase->produk->nama }}" 
                                                 class="me-3 rounded-3 product-thumb" 
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="me-3 rounded-3 bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 60px;">
                                                <i class="bi bi-laptop text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold">{{ $purchase->produk->nama ?? 'Produk Dihapus' }}</div>
                                            <small class="text-muted">
                                                <i class="bi bi-tag me-1"></i>Rp {{ number_format($purchase->produk->harga ?? 0, 0, ',', '.') }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border">
                                        <i class="bi bi-x"></i> {{ $purchase->quantity }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="total-price">
                                        Rp {{ number_format(($purchase->produk->harga ?? 0) * $purchase->quantity, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="status-badge status-{{ str_replace(' ', '-', strtolower($purchase->status)) }}">
                                        @if($purchase->status == 'Menunggu Konfirmasi')
                                            <i class="bi bi-clock-history me-1"></i>
                                        @elseif($purchase->status == 'Dikonfirmasi')
                                            <i class="bi bi-check-circle me-1"></i>
                                        @elseif($purchase->status == 'Ditolak')
                                            <i class="bi bi-x-circle me-1"></i>
                                        @elseif($purchase->status == 'Sedang Dikemas')
                                            <i class="bi bi-box-seam me-1"></i>
                                        @elseif($purchase->status == 'Sedang Dikirim')
                                            <i class="bi bi-truck me-1"></i>
                                        @elseif($purchase->status == 'Selesai')
                                            <i class="bi bi-check-circle me-1"></i>
                                        @endif
                                        {{ $purchase->status }}
                                    </span>
                                </td>
                                <td class="text-center text-muted">
                                    <div class="small">
                                        <i class="bi bi-calendar3 me-1"></i>{{ $purchase->created_at->format('d M Y') }}
                                    </div>
                                    <div class="small">
                                        <i class="bi bi-clock me-1"></i>{{ $purchase->created_at->format('H:i') }} WIB
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        @if($purchase->status == 'Menunggu Konfirmasi')
                                            <form action="{{ route('purchase.updateStatus', $purchase->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="Dikonfirmasi">
                                                <button type="submit" class="btn btn-success btn-sm mb-1" title="Konfirmasi">
                                                    <i class="bi bi-check-lg me-1"></i>Konfirmasi
                                                </button>
                                            </form>
                                            <form action="{{ route('purchase.updateStatus', $purchase->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="Ditolak">
                                                <button type="submit" class="btn btn-danger btn-sm" title="Tolak">
                                                    <i class="bi bi-x-lg me-1"></i>Tolak
                                                </button>
                                            </form>
                                        @elseif($purchase->status == 'Dikonfirmasi')
                                            <form action="{{ route('purchase.updateStatus', $purchase->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="Sedang Dikemas">
                                                <button type="submit" class="btn btn-primary btn-sm" title="Kemas">
                                                    <i class="bi bi-box-seam me-1"></i>Kemas
                                                </button>
                                            </form>
                                        @elseif($purchase->status == 'Sedang Dikemas')
                                            <form action="{{ route('purchase.updateStatus', $purchase->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="Sedang Dikirim">
                                                <button type="submit" class="btn btn-info btn-sm" title="Kirim">
                                                    <i class="bi bi-truck me-1"></i>Kirim
                                                </button>
                                            </form>
                                        @elseif($purchase->status == 'Sedang Dikirim')
                                            <form action="{{ route('purchase.updateStatus', $purchase->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="Selesai">
                                                <button type="submit" class="btn btn-success btn-sm" title="Selesai">
                                                    <i class="bi bi-check2-all me-1"></i>Selesai
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted small">Tidak ada aksi</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Mobile Card View --}}
        <div class="d-lg-none">
            @foreach($purchases as $purchase)
                <div class="card border-0 shadow-sm rounded-4 mb-3 management-card-mobile">
                    <div class="card-body p-3">
                        {{-- Header --}}
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="flex-grow-1">
                                <span class="badge bg-light text-dark border mb-2">Order #{{ $loop->iteration }}</span>
                                <h6 class="fw-bold mb-1">{{ $purchase->user->name ?? 'User Dihapus' }}</h6>
                                <small class="text-muted">
                                    <i class="bi bi-envelope me-1"></i>{{ $purchase->user->email ?? '-' }}
                                </small>
                            </div>
                            <span class="status-badge status-{{ str_replace(' ', '-', strtolower($purchase->status)) }}">
                                @if($purchase->status == 'Menunggu Konfirmasi')
                                    <i class="bi bi-clock-history"></i>
                                @elseif($purchase->status == 'Dikonfirmasi')
                                    <i class="bi bi-check-circle"></i>
                                @elseif($purchase->status == 'Ditolak')
                                    <i class="bi bi-x-circle"></i>
                                @elseif($purchase->status == 'Sedang Dikemas')
                                    <i class="bi bi-box-seam"></i>
                                @elseif($purchase->status == 'Sedang Dikirim')
                                    <i class="bi bi-truck"></i>
                                @elseif($purchase->status == 'Selesai')
                                    <i class="bi bi-check-circle"></i>
                                @endif
                            </span>
                        </div>

                        {{-- Product Info --}}
                        <div class="product-info mb-3 p-2 bg-light rounded-3">
                            <div class="d-flex align-items-center">
                                @if($purchase->produk && $purchase->produk->gambar)
                                    <img src="{{ asset('storage/' . $purchase->produk->gambar) }}" 
                                         alt="{{ $purchase->produk->nama }}" 
                                         class="me-2 rounded" 
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                @endif
                                <div>
                                    <div class="fw-semibold">{{ $purchase->produk->nama ?? 'Produk Dihapus' }}</div>
                                    <small class="text-muted">{{ $purchase->quantity }} unit</small>
                                </div>
                            </div>
                        </div>

                        {{-- Details --}}
                        <div class="purchase-details mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Harga Satuan</span>
                                <span class="fw-semibold">Rp {{ number_format($purchase->produk->harga ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tanggal</span>
                                <span class="fw-semibold">{{ $purchase->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">Total</span>
                                <span class="fw-bold text-secondary">
                                    Rp {{ number_format(($purchase->produk->harga ?? 0) * $purchase->quantity, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="action-buttons-mobile">
                            @if($purchase->status == 'Menunggu Konfirmasi')
                                <div class="d-grid gap-2">
                                    <form action="{{ route('purchase.updateStatus', $purchase->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="Dikonfirmasi">
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="bi bi-check-lg me-2"></i>Konfirmasi Pesanan
                                        </button>
                                    </form>
                                    <form action="{{ route('purchase.updateStatus', $purchase->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="Ditolak">
                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="bi bi-x-lg me-2"></i>Tolak Pesanan
                                        </button>
                                    </form>
                                </div>
                            @elseif($purchase->status == 'Dikonfirmasi')
                                <form action="{{ route('purchase.updateStatus', $purchase->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Sedang Dikemas">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-box-seam me-2"></i>Mulai Kemas
                                    </button>
                                </form>
                            @elseif($purchase->status == 'Sedang Dikemas')
                                <form action="{{ route('purchase.updateStatus', $purchase->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Sedang Dikirim">
                                    <button type="submit" class="btn btn-info w-100">
                                        <i class="bi bi-truck me-2"></i>Kirim Pesanan
                                    </button>
                                </form>
                            @elseif($purchase->status == 'Sedang Dikirim')
                                <form action="{{ route('purchase.updateStatus', $purchase->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Selesai">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-check2-all me-2"></i>Tandai Selesai
                                    </button>
                                </form>
                            @else
                                <div class="text-center text-muted">
                                    <small>Tidak ada aksi tersedia</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Summary Card --}}
        <div class="card border-0 shadow-sm rounded-4 mt-4 summary-card">
            <div class="card-body p-4">
                <div class="row text-center">
                    <div class="col-6 col-md-3 mb-3 mb-md-0">
                        <div class="summary-item">
                            <i class="bi bi-receipt-cutoff fs-3 text-secondary mb-2"></i>
                            <div class="fw-bold fs-5">{{ $purchases->count() }}</div>
                            <small class="text-muted">Total Transaksi</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mb-3 mb-md-0">
                        <div class="summary-item">
                            <i class="bi bi-clock-history fs-3 text-warning mb-2"></i>
                            <div class="fw-bold fs-5">{{ $purchases->where('status', 'Menunggu Konfirmasi')->count() }}</div>
                            <small class="text-muted">Menunggu</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mb-3 mb-md-0">
                        <div class="summary-item">
                            <i class="bi bi-truck fs-3 text-info mb-2"></i>
                            <div class="fw-bold fs-5">{{ $purchases->whereIn('status', ['Dikonfirmasi', 'Sedang Dikemas', 'Sedang Dikirim'])->count() }}</div>
                            <small class="text-muted">Dalam Proses</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="summary-item">
                            <i class="bi bi-check-circle fs-3 text-success mb-2"></i>
                            <div class="fw-bold fs-5">{{ $purchases->where('status', 'Selesai')->count() }}</div>
                            <small class="text-muted">Selesai</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Enhanced Styles - Grey Theme --}}
<style>
    .text-gradient {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .breadcrumb {
        background-color: transparent;
        padding: 0;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        font-size: 1.2rem;
    }

    .breadcrumb-item a:hover {
        color: #6b7280;
    }

    .stats-card {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        padding: 1rem 1.5rem;
        border-radius: 12px;
        color: white;
        text-align: center;
    }

    .stats-card small {
        color: rgba(255, 255, 255, 0.8);
    }

    .stats-card h4 {
        color: white;
    }

    .empty-state {
        background: #f8f9fa;
        border-radius: 20px;
        padding: 4rem 2rem;
    }

    .empty-icon {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .management-table {
        font-size: 0.95rem;
    }

    .table-header {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: white;
    }

    .table-header th {
        border: none;
        padding: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .purchase-row {
        transition: all 0.3s ease;
    }

    .purchase-row:hover {
        background-color: #f8f9fa;
        transform: scale(1.01);
    }

    .purchase-row td {
        padding: 1rem;
        vertical-align: middle;
    }

    .product-thumb {
        transition: transform 0.3s ease;
    }

    .purchase-row:hover .product-thumb {
        transform: scale(1.1);
    }

    .customer-info {
        line-height: 1.5;
    }

    .total-price {
        font-weight: 700;
        color: #10b981;
        font-size: 1.05rem;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }

    .status-menunggu-konfirmasi {
        background-color: #f8f9fa;
        color: #6b7280;
        border: 2px solid #d1d5db;
    }

    .status-dikonfirmasi {
        background-color: #f0f9ff;
        color: #0369a1;
        border: 2px solid #0ea5e9;
    }

    .status-ditolak {
        background-color: #fef2f2;
        color: #991b1b;
        border: 2px solid #ef4444;
    }

    .status-sedang-dikemas {
        background-color: #f0f9ff;
        color: #0369a1;
        border: 2px solid #0ea5e9;
    }

    .status-sedang-dikirim {
        background-color: #f0fdf4;
        color: #166534;
        border: 2px solid #22c55e;
    }

    .status-selesai {
        background-color: #f0fdf4;
        color: #166534;
        border: 2px solid #22c55e;
    }

    .action-buttons .btn {
        font-size: 0.85rem;
        padding: 0.35rem 0.75rem;
        margin: 2px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .action-buttons .btn:hover {
        transform: translateY(-2px);
    }

    .management-card-mobile {
        transition: all 0.3s ease;
    }

    .management-card-mobile:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .purchase-details {
        border-top: 1px dashed #e5e7eb;
        padding-top: 1rem;
    }

    .action-buttons-mobile .btn {
        border-radius: 10px;
        padding: 0.75rem;
        font-weight: 600;
    }

    .summary-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .summary-item {
        transition: transform 0.3s ease;
    }

    .summary-item:hover {
        transform: translateY(-5px);
    }

    .alert {
        border-radius: 12px;
    }

    @media (max-width: 991.98px) {
        .stats-card {
            margin-top: 1rem;
        }
    }
</style>
@endsection