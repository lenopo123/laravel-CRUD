@extends('app')

@section('title', 'Beli Produk')

@section('content')
<div class="container mt-4 mb-5">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('produk.index') }}" class="text-decoration-none"><i class="bi bi-house-door"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('produk.index') }}" class="text-decoration-none">Produk</a></li>
            <li class="breadcrumb-item active" aria-current="page">Beli Produk</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Header --}}
            <div class="text-center mb-4">
                <div class="icon-circle mb-3">
                    <i class="bi bi-cart-check-fill fs-1"></i>
                </div>
                <h2 class="fw-bold">
                    <span class="text-gradient">Konfirmasi Pembelian</span>
                </h2>
                <p class="text-muted">Pastikan jumlah dan detail produk sudah sesuai</p>
            </div>

            {{-- Pesan notifikasi --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Product Card --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 produk-card">
                <div class="card-body p-4">
                    <div class="row">
                        {{-- Product Image --}}
                        <div class="col-md-5 mb-3 mb-md-0">
                            @if ($produk->gambar)
                                <img src="{{ asset('storage/' . $produk->gambar) }}" 
                                     alt="{{ $produk->nama }}"
                                     class="img-fluid rounded-3 shadow-sm product-image"
                                     style="width: 100%; height: 250px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" 
                                     style="width: 100%; height: 250px;">
                                    <i class="bi bi-laptop text-muted" style="font-size: 5rem;"></i>
                                </div>
                            @endif
                        </div>

                        {{-- Product Details --}}
                        <div class="col-md-7">
                            <h4 class="fw-bold mb-3">{{ $produk->nama }}</h4>
                            
                            <p class="text-muted mb-3">{{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

                            {{-- Price & Stock --}}
                            <div class="product-info mb-4">
                                <div class="info-item mb-3">
                                    <label class="text-muted small mb-1">Harga Satuan</label>
                                    <div class="price-display">
                                        <i class="bi bi-tag-fill text-primary me-2"></i>
                                        <span class="fs-4 fw-bold text-primary">Rp{{ number_format($produk->harga, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <label class="text-muted small mb-1">Ketersediaan Stok</label>
                                    <div>
                                        <span class="badge {{ $produk->stok > 10 ? 'bg-success' : ($produk->stok > 0 ? 'bg-warning text-dark' : 'bg-danger') }} px-3 py-2">
                                            <i class="bi bi-box-seam me-1"></i>
                                            {{ $produk->stok }} unit tersedia
                                            @if($produk->stok <= 10 && $produk->stok > 0)
                                                <i class="bi bi-exclamation-circle ms-1"></i>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Purchase Form --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden purchase-form-card">
                <div class="card-header bg-gradient-primary text-white py-3 border-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-clipboard-check me-2"></i>Form Pembelian
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('produk.purchase', $produk->id) }}" id="purchaseForm">
                        @csrf
                        
                        {{-- Quantity Input --}}
                        <div class="mb-4">
                            <label for="quantity" class="form-label fw-semibold">
                                <i class="bi bi-bag-plus text-primary me-2"></i>Jumlah Pembelian
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-lg shadow-sm">
                                <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity()">
                                    <i class="bi bi-dash-lg"></i>
                                </button>
                                <input type="number" 
                                       name="quantity" 
                                       id="quantity" 
                                       class="form-control text-center fw-bold" 
                                       value="1"
                                       min="1" 
                                       max="{{ $produk->stok }}" 
                                       required
                                       onchange="calculateTotal()">
                                <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity()">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>Maksimal pembelian: <strong>{{ $produk->stok }}</strong> unit
                            </div>
                        </div>

                        {{-- Alamat Pengiriman --}}
                        <div class="mb-4">
                            <label for="alamat" class="form-label fw-semibold">
                                <i class="bi bi-geo-alt-fill text-primary me-2"></i>Alamat Pengiriman
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" 
                                      name="alamat" 
                                      rows="4" 
                                      placeholder="Masukkan alamat lengkap pengiriman (jalan, RT/RW, kelurahan, kecamatan, kota, kode pos)..."
                                      required>{{ old('alamat', auth()->user()->alamat ?? '') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>Pastikan alamat lengkap dan jelas untuk pengiriman
                            </div>
                        </div>

                        {{-- Metode Pembayaran --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-credit-card-fill text-primary me-2"></i>Metode Pembayaran
                                <span class="text-danger">*</span>
                            </label>
                            <div class="row g-3">
                                {{-- Transfer Bank --}}
                                <div class="col-md-4">
                                    <div class="payment-option card h-100 border-0 shadow-sm">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="metode_pembayaran" 
                                               id="transfer_bank" 
                                               value="transfer_bank" 
                                               {{ old('metode_pembayaran', 'transfer_bank') == 'transfer_bank' ? 'checked' : '' }}
                                               required
                                               onchange="showBankOptions()">
                                        <label class="form-check-label card-body text-center p-3" for="transfer_bank">
                                            <div class="payment-icon mb-3">
                                                <i class="bi bi-bank2 fs-1 text-primary"></i>
                                            </div>
                                            <h6 class="fw-bold mb-2">Transfer Bank</h6>
                                            <small class="text-muted d-block">BCA, BNI, Mandiri, BRI</small>
                                            <small class="text-success fw-semibold">✔ Tersedia</small>
                                        </label>
                                    </div>
                                </div>

                                {{-- E-Wallet --}}
                                <div class="col-md-4">
                                    <div class="payment-option card h-100 border-0 shadow-sm">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="metode_pembayaran" 
                                               id="e_wallet" 
                                               value="e_wallet"
                                               {{ old('metode_pembayaran') == 'e_wallet' ? 'checked' : '' }}
                                               required
                                               onchange="showEWalletOptions()">
                                        <label class="form-check-label card-body text-center p-3" for="e_wallet">
                                            <div class="payment-icon mb-3">
                                                <i class="bi bi-phone fs-1 text-success"></i>
                                            </div>
                                            <h6 class="fw-bold mb-2">E-Wallet</h6>
                                            <small class="text-muted d-block">Gopay, OVO, Dana, ShopeePay</small>
                                            <small class="text-success fw-semibold">✔ Tersedia</small>
                                        </label>
                                    </div>
                                </div>

                                {{-- COD --}}
                                <div class="col-md-4">
                                    <div class="payment-option card h-100 border-0 shadow-sm">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="metode_pembayaran" 
                                               id="cod" 
                                               value="cod"
                                               {{ old('metode_pembayaran') == 'cod' ? 'checked' : '' }}
                                               required
                                               onchange="hidePaymentDetails()">
                                        <label class="form-check-label card-body text-center p-3" for="cod">
                                            <div class="payment-icon mb-3">
                                                <i class="bi bi-cash-coin fs-1 text-warning"></i>
                                            </div>
                                            <h6 class="fw-bold mb-2">COD</h6>
                                            <small class="text-muted d-block">Bayar di Tempat</small>
                                            <small class="text-success fw-semibold">✔ Tersedia</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('metode_pembayaran')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror

                            {{-- Bank Options --}}
                            <div id="bankOptions" class="mt-3 p-3 bg-light rounded-3" style="display: none;">
                                <label class="form-label fw-semibold mb-3">
                                    <i class="bi bi-bank me-2"></i>Pilih Bank
                                </label>
                                <div class="row g-2">
                                    <div class="col-6 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="bank" id="bca" value="bca">
                                            <label class="form-check-label w-100 p-2 border rounded" for="bca">
                                                <i class="bi bi-building me-2 text-primary"></i>BCA
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="bank" id="bni" value="bni">
                                            <label class="form-check-label w-100 p-2 border rounded" for="bni">
                                                <i class="bi bi-building me-2 text-success"></i>BNI
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="bank" id="bri" value="bri">
                                            <label class="form-check-label w-100 p-2 border rounded" for="bri">
                                                <i class="bi bi-building me-2 text-warning"></i>BRI
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="bank" id="mandiri" value="mandiri">
                                            <label class="form-check-label w-100 p-2 border rounded" for="mandiri">
                                                <i class="bi bi-building me-2 text-danger"></i>Mandiri
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- E-Wallet Options --}}
                            <div id="eWalletOptions" class="mt-3 p-3 bg-light rounded-3" style="display: none;">
                                <label class="form-label fw-semibold mb-3">
                                    <i class="bi bi-phone me-2"></i>Pilih E-Wallet
                                </label>
                                <div class="row g-2">
                                    <div class="col-6 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="e_wallet" id="gopay" value="gopay">
                                            <label class="form-check-label w-100 p-2 border rounded" for="gopay">
                                                <i class="bi bi-phone me-2 text-primary"></i>Gopay
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="e_wallet" id="ovo" value="ovo">
                                            <label class="form-check-label w-100 p-2 border rounded" for="ovo">
                                                <i class="bi bi-phone me-2 text-purple"></i>OVO
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="e_wallet" id="dana" value="dana">
                                            <label class="form-check-label w-100 p-2 border rounded" for="dana">
                                                <i class="bi bi-phone me-2 text-blue"></i>Dana
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="e_wallet" id="shopeepay" value="shopeepay">
                                            <label class="form-check-label w-100 p-2 border rounded" for="shopeepay">
                                                <i class="bi bi-phone me-2 text-orange"></i>ShopeePay
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Total Calculation --}}
                        <div class="total-calculation p-4 rounded-3 mb-4">
                            <h6 class="fw-bold mb-3 text-center">
                                <i class="bi bi-receipt me-2"></i>Ringkasan Pembelian
                            </h6>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Harga Satuan</span>
                                <span class="fw-semibold">Rp{{ number_format($produk->harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">Jumlah</span>
                                <span class="fw-semibold" id="displayQuantity">1 unit</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold fs-5">Total Pembayaran</span>
                                <span class="fw-bold text-primary fs-4" id="totalPrice">Rp{{ number_format($produk->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex flex-column flex-sm-row gap-3">
                            <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary btn-lg rounded-3 px-4 w-100 w-sm-auto">
                                <i class="bi bi-arrow-left-circle me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-success btn-lg rounded-3 px-5 w-100 flex-grow-1 shadow-sm btn-purchase">
                                <i class="bi bi-cart-check-fill me-2"></i>Beli Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Info Card --}}
            <div class="alert alert-info border-0 shadow-sm rounded-4 mt-4" role="alert">
                <div class="d-flex">
                    <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                    <div>
                        <h6 class="alert-heading fw-bold mb-2">Informasi Pembelian</h6>
                        <ul class="mb-0 ps-3">
                            <li>Pastikan jumlah pembelian dan alamat sudah sesuai</li>
                            <li>Stok akan berkurang setelah pembelian dikonfirmasi</li>
                            <li>Anda dapat melihat status pembelian di menu "Pembelian Saya"</li>
                            <li>Pembayaran dapat dilakukan sesuai metode yang dipilih</li>
                            <li>Untuk COD, pastikan alamat lengkap dan jelas</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Enhanced Styles --}}
<style>
    .text-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        color: #667eea;
    }

    .icon-circle {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .produk-card {
        transition: all 0.3s ease;
    }

    .produk-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    .product-image {
        transition: transform 0.3s ease;
    }

    .produk-card:hover .product-image {
        transform: scale(1.05);
    }

    .price-display {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 10px;
        border-left: 4px solid #667eea;
    }

    .info-item {
        padding: 0.75rem;
        background: #f8f9fa;
        border-radius: 10px;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .purchase-form-card {
        border: 2px solid transparent;
        background-clip: padding-box;
        position: relative;
    }

    .purchase-form-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: inherit;
        padding: 2px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
        opacity: 0.3;
    }

    .input-group-lg .btn {
        padding: 0.75rem 1rem;
        font-weight: 600;
    }

    .input-group-lg input {
        font-size: 1.5rem;
    }

    .payment-option {
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid transparent;
    }

    .payment-option:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .payment-option .form-check-input {
        position: absolute;
        top: 10px;
        left: 10px;
    }

    .payment-option .form-check-input:checked + .card-body {
        border: 2px solid #0d6efd;
        background-color: #f8f9fa;
        border-radius: 10px;
    }

    .payment-icon {
        transition: transform 0.3s ease;
    }

    .payment-option:hover .payment-icon {
        transform: scale(1.1);
    }

    .total-calculation {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 2px dashed #0ea5e9;
    }

    .btn-purchase {
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .btn-purchase:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    }

    .alert {
        border-radius: 15px;
    }

    /* Custom colors for e-wallets */
    .text-purple { color: #6f42c1 !important; }
    .text-blue { color: #0dcaf0 !important; }
    .text-orange { color: #fd7e14 !important; }

    @media (max-width: 576px) {
        .icon-circle {
            width: 60px;
            height: 60px;
        }

        .price-display span {
            font-size: 1.5rem !important;
        }

        .payment-option {
            margin-bottom: 1rem;
        }
    }
</style>

{{-- JavaScript --}}
<script>
    const maxStock = {{ $produk->stok }};
    const pricePerUnit = {{ $produk->harga }};

    function increaseQuantity() {
        const input = document.getElementById('quantity');
        const currentValue = parseInt(input.value);
        if (currentValue < maxStock) {
            input.value = currentValue + 1;
            calculateTotal();
        } else {
            alert('Jumlah maksimal adalah ' + maxStock + ' unit!');
        }
    }

    function decreaseQuantity() {
        const input = document.getElementById('quantity');
        const currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
            calculateTotal();
        }
    }

    function calculateTotal() {
        const quantity = parseInt(document.getElementById('quantity').value) || 1;
        
        // Validasi
        if (quantity > maxStock) {
            document.getElementById('quantity').value = maxStock;
            alert('Jumlah maksimal adalah ' + maxStock + ' unit!');
            return;
        }
        
        if (quantity < 1) {
            document.getElementById('quantity').value = 1;
            return;
        }

        const total = quantity * pricePerUnit;
        
        // Update display
        document.getElementById('displayQuantity').textContent = quantity + ' unit';
        document.getElementById('totalPrice').textContent = 'Rp' + total.toLocaleString('id-ID');
    }

    function showBankOptions() {
        document.getElementById('bankOptions').style.display = 'block';
        document.getElementById('eWalletOptions').style.display = 'none';
    }

    function showEWalletOptions() {
        document.getElementById('eWalletOptions').style.display = 'block';
        document.getElementById('bankOptions').style.display = 'none';
    }

    function hidePaymentDetails() {
        document.getElementById('bankOptions').style.display = 'none';
        document.getElementById('eWalletOptions').style.display = 'none';
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        calculateTotal();
        
        // Add event listener for manual input
        document.getElementById('quantity').addEventListener('input', calculateTotal);
        
        // Show appropriate options based on selected payment method
        const selectedMethod = document.querySelector('input[name="metode_pembayaran"]:checked');
        if (selectedMethod) {
            if (selectedMethod.value === 'transfer_bank') {
                showBankOptions();
            } else if (selectedMethod.value === 'e_wallet') {
                showEWalletOptions();
            } else {
                hidePaymentDetails();
            }
        }
    });

    // Form validation
    document.getElementById('purchaseForm').addEventListener('submit', function(e) {
        const quantity = parseInt(document.getElementById('quantity').value);
        const alamat = document.getElementById('alamat').value.trim();
        const metodePembayaran = document.querySelector('input[name="metode_pembayaran"]:checked');
        
        if (quantity < 1 || quantity > maxStock) {
            e.preventDefault();
            alert('Jumlah pembelian harus antara 1 dan ' + maxStock + ' unit!');
            return false;
        }

        if (!alamat) {
            e.preventDefault();
            alert('Alamat pengiriman harus diisi!');
            return false;
        }

        if (!metodePembayaran) {
            e.preventDefault();
            alert('Pilih metode pembayaran terlebih dahulu!');
            return false;
        }

        // Validasi pilihan bank jika transfer bank dipilih
        if (metodePembayaran.value === 'transfer_bank') {
            const selectedBank = document.querySelector('input[name="bank"]:checked');
            if (!selectedBank) {
                e.preventDefault();
                alert('Pilih bank terlebih dahulu!');
                return false;
            }
        }

        // Validasi pilihan e-wallet jika e-wallet dipilih
        if (metodePembayaran.value === 'e_wallet') {
            const selectedEWallet = document.querySelector('input[name="e_wallet"]:checked');
            if (!selectedEWallet) {
                e.preventDefault();
                alert('Pilih e-wallet terlebih dahulu!');
                return false;
            }
        }
    });
</script>

@endsection