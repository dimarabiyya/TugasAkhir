@extends('layouts.skydash')

@section('content')

<style>
    .gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .image-upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .image-upload-area:hover {
        border-color: #667eea;
        background-color: #f8f9ff;
    }

    .image-upload-area.active {
        border-color: #667eea;
        background-color: #f0f4ff;
    }

    .image-preview {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .form-input {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .form-label {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
        display: block;
        font-size: 14px;
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 12px 32px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #5568d3 0%, #6b3b8c 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(102, 126, 234, 0.4);
    }

    .btn-cancel {
        background: white;
        border: 1.5px solid #e5e7eb;
        color: #6b7280;
        padding: 12px 32px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
        display: inline-block;
    }

    .btn-cancel:hover {
        background: #f9fafb;
        border-color: #d1d5db;
        color: #374151;
    }

    .error-alert {
        background: #fee2e2;
        border: 1px solid #fecaca;
        border-radius: 8px;
        color: #991b1b;
        padding: 12px 16px;
        margin-bottom: 24px;
    }

    .error-alert strong {
        display: block;
        margin-bottom: 8px;
    }

    .error-alert ul {
        margin: 0;
        padding-left: 20px;
    }

    .error-alert li {
        margin: 4px 0;
        font-size: 13px;
    }
</style>

<!-- Header -->
<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="fw-bold text-dark mb-2" style="font-size: 28px;">Tambah e-Book Baru</h2>
        <p class="text-muted mb-0">Lengkapi informasi buku dan unggah cover serta file PDF</p>
    </div>
</div>

<div class="separator mb-5"></div>

<!-- Main Content -->
<div class="container-xl">
    <!-- Error Messages -->
    @if ($errors->any())
        <div class="error-alert mb-4">
            <strong><i class="icon-alert-circle me-2"></i>Terdapat Kesalahan</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ebooks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            <!-- Left Column: Image Upload -->
            <div class="col-lg-5">
                <div class="bg-white rounded-lg shadow-sm p-5 h-100">
                    <h5 class="fw-bold text-dark mb-4">Cover Buku</h5>

                    <!-- Image Upload Area -->
                    <div class="image-upload-area d-flex align-items-center justify-content-center position-relative" id="uploadArea" style="min-height: 400px; cursor: pointer;">
                        <input type="file" name="cover_image" id="coverImage" accept="image/*" class="d-none" required>
                        
                        <!-- Default Upload UI -->
                        <div id="uploadPlaceholder" class="text-center">
                            <div style="font-size: 48px; color: #d1d5db; margin-bottom: 16px;">
                                <i class="icon-image"></i>
                            </div>
                            <p class="text-muted mb-2 fw-semibold">Klik atau drag gambar ke sini</p>
                            <p class="text-muted" style="font-size: 13px;">Format: JPG, PNG, WebP (Max 5MB)</p>
                        </div>

                        <!-- Image Preview -->
                        <div id="imagePreview" class="image-preview d-none w-100 h-100" style="position: absolute; top: 0; left: 0;">
                            <img id="previewImg" src="" alt="Preview" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                    </div>

                    <!-- Change Image Button -->
                    <button type="button" id="changeImageBtn" class="btn btn-sm btn-light border mt-3 w-100 d-none" onclick="document.getElementById('coverImage').click();">
                        <i class="icon-edit me-2"></i> Ubah Gambar
                    </button>

                    <!-- Image Info -->
                    <div id="imageInfo" class="mt-4 p-3 bg-light rounded d-none">
                        <small class="text-muted d-block mb-2">File telah dipilih</small>
                        <small id="fileName" class="text-dark fw-semibold d-block"></small>
                    </div>
                </div>
            </div>

            <!-- Right Column: Form Fields -->
            <div class="col-lg-7">
                <div class="bg-white rounded-lg shadow-sm p-5">
                    <h5 class="fw-bold text-dark mb-4">Informasi Buku</h5>

                    <!-- Judul -->
                    <div class="mb-4">
                        <label class="form-label" for="title">
                           Judul Buku
                        </label>
                        <input type="text" id="title" name="title" class="form-input form-control" placeholder="Contoh: Laravel Mastery" value="{{ old('title') }}" required>
                        @error('title')
                            <small class="text-danger mt-2 d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Penulis -->
                    <div class="mb-4">
                        <label class="form-label" for="author">
                            <i class="icon-user me-2" style="color: #667eea;"></i>Penulis
                        </label>
                        <input type="text" id="author" name="author" class="form-input form-control" placeholder="Nama penulis" value="{{ old('author') }}" required>
                        @error('author')
                            <small class="text-danger mt-2 d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Tahun Terbit -->
                    <div class="mb-4">
                        <label class="form-label" for="publication_year">
                            <i class="icon-calendar me-2" style="color: #667eea;"></i>Tahun Terbit
                        </label>
                        <input type="number" id="publication_year" name="publication_year" class="form-input form-control" placeholder="Contoh: 2025" min="1900" max="2099" value="{{ old('publication_year') }}" required>
                        @error('publication_year')
                            <small class="text-danger mt-2 d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label class="form-label" for="description">
                            Deskripsi (Opsional)
                        </label>
                        <textarea id="description" name="description" class="form-input form-control" rows="3" placeholder="Deskripsi singkat tentang buku..." style="resize: none;">{{ old('description') }}</textarea>
                        @error('description')
                            <small class="text-danger mt-2 d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- File PDF -->
                    <div class="mb-5">
                        <label class="form-label" for="ebookFile">
                            <i class="icon-file-pdf me-2" style="color: #ff6b6b;"></i>File E-Book (PDF)
                        </label>
                        <div class="border-2 border-dashed border-secondary rounded-2 p-4 text-center cursor-pointer" onclick="document.getElementById('ebookFile').click();" style="transition: all 0.3s ease;">
                            <input type="file" id="ebookFile" name="ebook_file" accept=".pdf" class="d-none" required>
                            <div id="pdfPlaceholder">
                                <i class="icon-file-pdf" style="font-size: 32px; color: #ff6b6b; margin-bottom: 8px; display: block;"></i>
                                <p class="mb-1 fw-semibold text-dark">Klik untuk upload PDF</p>
                                <small class="text-muted">Drag & drop atau klik untuk memilih file</small>
                            </div>
                            <div id="pdfInfo" class="d-none">
                                <i class="icon-check-circle" style="font-size: 32px; color: #10b981; margin-bottom: 8px; display: block;"></i>
                                <small id="pdfFileName" class="text-dark fw-semibold d-block"></small>
                            </div>
                        </div>
                        @error('ebook_file')
                            <small class="text-danger mt-2 d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-3 justify-content-end">
                        <a href="{{ route('ebooks.index') }}" class="btn-cancel">
                            <i class="icon-x me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn-submit">
                            <i class="icon-save me-2"></i>Simpan e-Book
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- JavaScript for File Upload -->
<script>
    const uploadArea = document.getElementById('uploadArea');
    const coverImage = document.getElementById('coverImage');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const changeImageBtn = document.getElementById('changeImageBtn');
    const imageInfo = document.getElementById('imageInfo');
    const fileName = document.getElementById('fileName');

    // Click to upload
    uploadArea.addEventListener('click', () => {
        coverImage.click();
    });

    // Drag and drop
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('active');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('active');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('active');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            coverImage.files = files;
            handleImageSelect();
        }
    });

    // File selection
    coverImage.addEventListener('change', handleImageSelect);

    function handleImageSelect() {
        const file = coverImage.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                uploadPlaceholder.classList.add('d-none');
                imagePreview.classList.remove('d-none');
                changeImageBtn.classList.remove('d-none');
                imageInfo.classList.remove('d-none');
                fileName.textContent = file.name + ' (' + (file.size / 1024).toFixed(2) + ' KB)';
            };
            reader.readAsDataURL(file);
        }
    }

    // PDF File Upload
    const ebookFile = document.getElementById('ebookFile');
    const pdfPlaceholder = document.getElementById('pdfPlaceholder');
    const pdfInfo = document.getElementById('pdfInfo');
    const pdfFileName = document.getElementById('pdfFileName');

    const pdfUploadArea = document.querySelector('[onclick="document.getElementById(\'ebookFile\').click();"]');

    pdfUploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        pdfUploadArea.style.borderColor = '#667eea';
        pdfUploadArea.style.backgroundColor = '#f0f4ff';
    });

    pdfUploadArea.addEventListener('dragleave', () => {
        pdfUploadArea.style.borderColor = '#dee2e6';
        pdfUploadArea.style.backgroundColor = 'white';
    });

    pdfUploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        pdfUploadArea.style.borderColor = '#dee2e6';
        pdfUploadArea.style.backgroundColor = 'white';
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            ebookFile.files = files;
            handlePdfSelect();
        }
    });

    ebookFile.addEventListener('change', handlePdfSelect);

    function handlePdfSelect() {
        const file = ebookFile.files[0];
        if (file) {
            pdfPlaceholder.classList.add('d-none');
            pdfInfo.classList.remove('d-none');
            pdfFileName.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
        }
    }
</script>

@endsection