@extends('app')

@section('title', 'Tambah jam')

@section('content')
<div class="container mt-4 mb-5">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('produk.index') }}" class="text-decoration-none"><i class="bi bi-house-door"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('produk.index') }}" class="text-decoration-none">Produk</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Produk</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                {{-- Header --}}
                <div class="card-header bg-gradient-success text-white py-4 border-0">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-3">
                            <i class="bi bi-plus-circle-fill fs-4"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold">Tambah Produk Baru</h4>
                            <p class="mb-0 opacity-75 small">Lengkapi informasi produk yang akan ditambahkan</p>
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

                    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" id="createProductForm">
                        @csrf

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
                                   value="{{ old('nama') }}" 
                                   placeholder="Contoh: rolex"
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
                                           value="{{ old('harga') }}" 
                                           placeholder="15000"
                                           min="0"
                                           required>
                                </div>
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>Masukkan harga dalam Rupiah
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
                                       value="{{ old('stok') }}" 
                                       placeholder="100"
                                       min="0"
                                       required>
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>Jumlah stok tersedia
                                </div>
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
                                      placeholder="Deskripsikan produk Anda dengan detail. Contoh: spesifikasi laptop">{{ old('deskripsi') }}</textarea>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>Jelaskan produk secara detail untuk menarik pembeli
                            </div>
                        </div>

                        {{-- Gambar Produk --}}
                        <div class="mb-4">
                            <label for="gambar" class="form-label fw-semibold">
                                <i class="bi bi-image-fill text-danger me-2"></i>Gambar Produk
                            </label>
                            
                            <div class="upload-area" id="uploadArea">
                                <input type="file" 
                                       name="gambar" 
                                       id="gambar"
                                       class="form-control d-none" 
                                       accept="image/*"
                                       onchange="previewImage(event)">
                                
                                <label for="gambar" class="upload-label">
                                    <div class="upload-content">
                                        <i class="bi bi-cloud-upload fs-1 text-primary mb-3"></i>
                                        <p class="mb-1 fw-semibold">Klik untuk upload gambar</p>
                                        <p class="text-muted small mb-0">atau drag & drop file di sini</p>
                                    </div>
                                </label>
                            </div>

                            <div class="form-text mt-2">
                                <i class="bi bi-info-circle me-1"></i>Format: JPG, JPEG, PNG. Maksimal 2MB. Gambar produk yang menarik akan meningkatkan penjualan.
                            </div>

                            {{-- Preview Gambar --}}
                            <div id="imagePreview" class="mt-3 d-none">
                                <div class="preview-container p-3 bg-light rounded-3 border">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <p class="small text-muted mb-0"><strong>Preview:</strong></p>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeImage()">
                                            <i class="bi bi-x-circle me-1"></i>Hapus
                                        </button>
                                    </div>
                                    <img id="preview" 
                                         src="" 
                                         alt="Preview" 
                                         class="img-fluid rounded-3 shadow-sm"
                                         style="max-width: 300px; max-height: 300px; object-fit: cover;">
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3 mt-5 pt-4 border-top">
                            <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary btn-lg rounded-3 px-4 w-100 w-sm-auto">
                                <i class="bi bi-arrow-left-circle me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-success btn-lg rounded-3 px-5 w-100 w-sm-auto shadow-sm btn-submit">
                                <i class="bi bi-check-circle me-2"></i>Simpan Produk
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
    .bg-gradient-success {
        background: linear-gradient(135deg, #6b6b6bff 0%, #5c5c5cff 100%);
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
        border-color: #5a5a5aff;
        box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.25);
    }

    .form-control-lg {
        padding: 0.75rem 1rem;
        font-size: 1rem;
    }

    .input-group-text {
        border: 1px solid #ced4da;
    }

    .upload-area {
        position: relative;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .upload-area:hover {
        border-color: #757575ff;
        background: #f0fdf4;
    }

    .upload-label {
        cursor: pointer;
        display: block;
        margin: 0;
    }

    .upload-content {
        pointer-events: none;
    }

    .preview-container {
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .btn-submit {
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(16, 185, 129, 0.4);
    }

    .btn-outline-secondary:hover {
        transform: translateY(-2px);
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
        color: #9b9b9bff;
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

        .upload-area {
            padding: 1.5rem;
        }
    }
</style>

{{-- JavaScript --}}
<script>
    // Preview Image
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('imagePreview');
        const uploadArea = document.getElementById('uploadArea');
        
        if (input.files && input.files[0]) {
            // Validasi ukuran file (2MB)
            if (input.files[0].size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 2MB.');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('d-none');
                uploadArea.style.display = 'none';
                
                // Scroll ke preview
                previewContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Remove Image
    function removeImage() {
        const input = document.getElementById('gambar');
        const previewContainer = document.getElementById('imagePreview');
        const uploadArea = document.getElementById('uploadArea');
        
        input.value = '';
        previewContainer.classList.add('d-none');
        uploadArea.style.display = 'block';
    }

    // Drag and Drop
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('gambar');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, () => {
            uploadArea.style.borderColor = '#797979ff';
            uploadArea.style.background = '#f0fdf4';
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, () => {
            uploadArea.style.borderColor = '#cbd5e1';
            uploadArea.style.background = '#f8fafc';
        }, false);
    });

    uploadArea.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        
        // Trigger preview
        const event = new Event('change', { bubbles: true });
        fileInput.dispatchEvent(event);
    }, false);

    // Form validation
    document.getElementById('createProductForm').addEventListener('submit', function(e) {
        const harga = document.getElementById('harga').value;
        const stok = document.getElementById('stok').value;
        const nama = document.getElementById('nama').value;
        
        if (harga < 0 || stok < 0) {
            e.preventDefault();
            alert('Harga dan stok tidak boleh bernilai negatif!');
            return false;
        }

        if (nama.trim().length < 3) {
            e.preventDefault();
            alert('Nama produk minimal 3 karakter!');
            return false;
        }
    });
</script>

@endsection