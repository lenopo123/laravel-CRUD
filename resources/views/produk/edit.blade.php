@extends('app')

@section('title', 'Edit Produk')

@section('content')
<div class="container mt-4 mb-5">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('produk.index') }}" class="text-decoration-none"><i class="bi bi-house-door"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('produk.index') }}" class="text-decoration-none">Produk</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Produk</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                {{-- Header --}}
                <div class="card-header bg-gradient-primary text-white py-4 border-0">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-3">
                            <i class="bi bi-pencil-square fs-4"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold">Edit Produk</h4>
                            <p class="mb-0 opacity-75 small">Perbarui informasi produk Anda</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    {{-- Error Messages --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-exclamation-triangle-fill fs-5 me-3 mt-1"></i>
                                <div class="flex-grow-1">
                                    <strong>Oops! Ada beberapa masalah:</strong>
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

                    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" id="editProductForm">
                        @csrf
                        @method('PUT')

                        {{-- Nama Produk --}}
                        <div class="mb-4">
                            <label for="nama" class="form-label fw-semibold">
                                <i class="bi bi-tag-fill text-primary me-2"></i>Nama Produk
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="nama" 
                                   id="nama"
                                   class="form-control form-control-lg rounded-3 shadow-sm" 
                                   value="{{ old('nama', $produk->nama) }}" 
                                   placeholder="Masukkan nama produk"
                                   required>
                        </div>

                        <div class="row">
                            {{-- Harga --}}
                            <div class="col-md-6 mb-4">
                                <label for="harga" class="form-label fw-semibold">
                                    <i class="bi bi-cash-coin text-success me-2"></i>Harga
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg shadow-sm">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                        <strong>Rp</strong>
                                    </span>
                                    <input type="number" 
                                           name="harga" 
                                           id="harga"
                                           class="form-control border-start-0 rounded-end-3" 
                                           value="{{ old('harga', $produk->harga) }}" 
                                           placeholder="0"
                                           min="0"
                                           required>
                                </div>
                            </div>

                            {{-- Stok --}}
                            <div class="col-md-6 mb-4">
                                <label for="stok" class="form-label fw-semibold">
                                    <i class="bi bi-box-seam text-info me-2"></i>Stok
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       name="stok" 
                                       id="stok"
                                       class="form-control form-control-lg rounded-3 shadow-sm" 
                                       value="{{ old('stok', $produk->stok) }}" 
                                       placeholder="0"
                                       min="0"
                                       required>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-semibold">
                                <i class="bi bi-file-earmark-text-fill text-warning me-2"></i>Deskripsi
                            </label>
                            <textarea name="deskripsi" 
                                      id="deskripsi"
                                      class="form-control rounded-3 shadow-sm" 
                                      rows="5"
                                      placeholder="Masukkan deskripsi produk (opsional)">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>Deskripsikan produk Anda dengan detail
                            </div>
                        </div>

                        {{-- Gambar Produk --}}
                        <div class="mb-4">
                            <label for="gambar" class="form-label fw-semibold">
                                <i class="bi bi-image-fill text-danger me-2"></i>Gambar Produk
                            </label>
                            
                            {{-- Preview Gambar Lama --}}
                            @if ($produk->gambar)
                                <div class="current-image-container mb-3 p-3 bg-light rounded-3 border">
                                    <p class="small text-muted mb-2"><strong>Gambar Saat Ini:</strong></p>
                                    <img src="{{ asset('storage/' . $produk->gambar) }}" 
                                         alt="Gambar Produk" 
                                         class="img-fluid rounded-3 shadow-sm current-image"
                                         style="max-width: 250px; max-height: 250px; object-fit: cover;">
                                </div>
                            @endif

                            {{-- Input File --}}
                            <div class="custom-file-upload">
                                <input type="file" 
                                       name="gambar" 
                                       id="gambar"
                                       class="form-control form-control-lg rounded-3 shadow-sm" 
                                       accept="image/*"
                                       onchange="previewImage(event)">
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>Format: JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.
                                </div>
                            </div>

                            {{-- Preview Gambar Baru --}}
                            <div id="imagePreview" class="mt-3 d-none">
                                <p class="small text-muted mb-2"><strong>Preview Gambar Baru:</strong></p>
                                <img id="preview" 
                                     src="" 
                                     alt="Preview" 
                                     class="img-fluid rounded-3 shadow-sm"
                                     style="max-width: 250px; max-height: 250px; object-fit: cover;">
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3 mt-5 pt-4 border-top">
                            <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary btn-lg rounded-3 px-4 w-100 w-sm-auto">
                                <i class="bi bi-arrow-left-circle me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-success btn-lg rounded-3 px-5 w-100 w-sm-auto shadow-sm btn-update">
                                <i class="bi bi-check-circle me-2"></i>Update Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Enhanced Styles --}}
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .icon-box {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
    }

    .form-control-lg {
        padding: 0.75rem 1rem;
        font-size: 1rem;
    }

    .input-group-text {
        border: 1px solid #ced4da;
    }

    .btn-update {
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(25, 135, 84, 0.4);
    }

    .btn-outline-secondary:hover {
        transform: translateY(-2px);
    }

    .current-image-container {
        transition: all 0.3s ease;
    }

    .current-image {
        transition: transform 0.3s ease;
    }

    .current-image:hover {
        transform: scale(1.05);
    }

    .custom-file-upload input[type="file"] {
        cursor: pointer;
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

    @media (max-width: 576px) {
        .card-body {
            padding: 1.5rem !important;
        }

        .icon-box {
            width: 40px;
            height: 40px;
        }

        .card-header h4 {
            font-size: 1.25rem;
        }
    }
</style>

{{-- Preview Image Script --}}
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('d-none');
                
                // Scroll ke preview
                previewContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.classList.add('d-none');
        }
    }

    // Form validation
    document.getElementById('editProductForm').addEventListener('submit', function(e) {
        const harga = document.getElementById('harga').value;
        const stok = document.getElementById('stok').value;
        
        if (harga < 0 || stok < 0) {
            e.preventDefault();
            alert('Harga dan stok tidak boleh bernilai negatif!');
            return false;
        }
    });
</script>

@endsection