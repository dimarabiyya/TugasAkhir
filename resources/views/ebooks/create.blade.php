@extends('layouts.skydash')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
            <div class="card-body py-4 px-4">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-8 mb-3 mb-xl-0">
                        <div class="d-flex align-items-center">
                            <div style="background: rgba(255,255,255,0.2); border-radius: 10px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; margin-right: 14px; flex-shrink: 0;">
                                <i class="mdi mdi-book-plus-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Tambah e-Book Baru</h4>
                                <p class="text-white-50 mb-0" style="font-size: 14px;">Lengkapi informasi buku, cover, dan file PDF</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('ebooks.index') }}" class="btn btn-light font-weight-bold" style="border-radius: 8px; font-size: 13px;">
                            <i class="mdi mdi-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== ERROR ALERT ===== --}}
@if($errors->any())
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 10px; background: #fde8e8; border-left: 4px solid #e74a3b !important;">
            <div class="card-body py-3 px-4">
                <div class="d-flex align-items-start">
                    <div style="background: #e74a3b; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0; margin-top: 2px;">
                        <i class="mdi mdi-alert-circle text-white" style="font-size: 16px;"></i>
                    </div>
                    <div>
                        <p class="font-weight-bold mb-1" style="color: #c0392b; font-size: 14px;">Terdapat Kesalahan</p>
                        <ul class="mb-0 pl-3" style="color: #c0392b;">
                            @foreach($errors->all() as $error)
                                <li style="font-size: 13px;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ===== FORM ===== --}}
<form action="{{ route('ebooks.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="row">

    {{-- ===== LEFT: Cover Upload ===== --}}
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-image-outline" style="font-size: 20px; color: #4e73df;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Cover Buku</h5>
                        <small class="text-muted">JPG, PNG, WebP (maks. 5MB)</small>
                    </div>
                </div>

                {{-- Upload Area --}}
                <div id="uploadArea"
                     style="border: 2px dashed #d1d3e2; border-radius: 10px; min-height: 340px; display: flex; align-items: center; justify-content: center; position: relative; cursor: pointer; transition: all 0.2s ease; overflow: hidden;"
                     onmouseover="if(!this.classList.contains('has-image')){this.style.borderColor='#4e73df';this.style.background='#f0f4ff';}"
                     onmouseout="if(!this.classList.contains('has-image')){this.style.borderColor='#d1d3e2';this.style.background='#fdfdff';}">

                    <input type="file" name="cover_image" id="coverImage" accept="image/*" class="d-none" required>

                    {{-- Placeholder --}}
                    <div id="uploadPlaceholder" class="text-center p-4">
                        <div style="background: #f0f0f3; border-radius: 50%; width: 70px; height: 70px; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px;">
                            <i class="mdi mdi-image-plus-outline" style="font-size: 34px; color: #c4c6d0;"></i>
                        </div>
                        <p class="font-weight-bold text-dark mb-1" style="font-size: 14px;">Klik atau drag gambar ke sini</p>
                        <p class="text-muted mb-0" style="font-size: 12px;">JPG, PNG, WebP — Maks. 5MB</p>
                    </div>

                    {{-- Preview --}}
                    <div id="imagePreview" class="d-none" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                        <img id="previewImg" src="" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                        {{-- Overlay on hover --}}
                        <div id="previewOverlay"
                             style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(78,115,223,0.7); display: none; align-items: center; justify-content: center; flex-direction: column; gap: 6px;">
                            <i class="mdi mdi-camera-outline text-white" style="font-size: 32px;"></i>
                            <span class="text-white font-weight-bold" style="font-size: 13px;">Ubah Gambar</span>
                        </div>
                    </div>
                </div>

                {{-- File info --}}
                <div id="imageInfo" class="mt-3 d-none">
                    <div style="background: #e3f9e5; border-radius: 8px; padding: 8px 12px; display: flex; align-items: center; gap: 8px;">
                        <i class="mdi mdi-check-circle" style="color: #1cc88a; font-size: 16px; flex-shrink: 0;"></i>
                        <small id="fileName" class="text-dark font-weight-bold" style="font-size: 12px; word-break: break-all;"></small>
                    </div>
                </div>

                @error('cover_image')
                    <div class="mt-2"><small class="text-danger"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</small></div>
                @enderror
            </div>
        </div>
    </div>

    {{-- ===== RIGHT: Form Fields ===== --}}
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-information-outline" style="font-size: 20px; color: #4e73df;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Informasi Buku</h5>
                        <small class="text-muted">Judul, penulis, tahun, dan deskripsi</small>
                    </div>
                </div>

                {{-- Judul --}}
                <div class="form-group mb-4">
                    <label for="title" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                        <i class="mdi mdi-format-title mr-1 text-muted"></i> Judul Buku <span class="text-danger">*</span>
                    </label>
                    <input type="text" id="title" name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           placeholder="Contoh: Laravel Mastery"
                           value="{{ old('title') }}" required
                           style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2;">
                    @error('title')
                        <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                {{-- Penulis --}}
                <div class="form-group mb-4">
                    <label for="author" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                        <i class="mdi mdi-account-outline mr-1 text-muted"></i> Penulis <span class="text-danger">*</span>
                    </label>
                    <input type="text" id="author" name="author"
                           class="form-control @error('author') is-invalid @enderror"
                           placeholder="Nama penulis buku"
                           value="{{ old('author') }}" required
                           style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2;">
                    @error('author')
                        <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tahun Terbit --}}
                <div class="form-group mb-4">
                    <label for="publication_year" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                        <i class="mdi mdi-calendar-outline mr-1 text-muted"></i> Tahun Terbit <span class="text-danger">*</span>
                    </label>
                    <input type="number" id="publication_year" name="publication_year"
                           class="form-control @error('publication_year') is-invalid @enderror"
                           placeholder="Contoh: 2025"
                           min="1900" max="2099"
                           value="{{ old('publication_year') }}" required
                           style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2;">
                    @error('publication_year')
                        <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="form-group mb-0">
                    <label for="description" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                        <i class="mdi mdi-text-box-outline mr-1 text-muted"></i> Deskripsi
                    </label>
                    <textarea id="description" name="description"
                              class="form-control @error('description') is-invalid @enderror"
                              rows="3"
                              placeholder="Deskripsi singkat tentang buku ini..."
                              style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2; resize: vertical;">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted mt-1 d-block"><i class="mdi mdi-information-outline mr-1"></i>Opsional — ringkasan singkat isi buku</small>
                </div>
            </div>
        </div>

        {{-- ===== PDF Upload ===== --}}
        <div class="card border-0 shadow-sm mt-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div style="background: #fde8e8; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-file-pdf-box" style="font-size: 20px; color: #e74a3b;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">File e-Book (PDF)</h5>
                        <small class="text-muted">Unggah file PDF buku</small>
                    </div>
                </div>

                <input type="file" id="ebookFile" name="ebook_file" accept=".pdf" class="d-none" required>

                {{-- PDF Drop Zone --}}
                <div id="pdfUploadArea"
                     onclick="document.getElementById('ebookFile').click();"
                     style="border: 2px dashed #d1d3e2; border-radius: 10px; padding: 28px; text-align: center; cursor: pointer; transition: all 0.2s ease; background: #fdfdff;"
                     onmouseover="this.style.borderColor='#e74a3b';this.style.background='#fff8f8';"
                     onmouseout="if(!this.classList.contains('has-file')){this.style.borderColor='#d1d3e2';this.style.background='#fdfdff';}">

                    <div id="pdfPlaceholder">
                        <div style="background: #fde8e8; border-radius: 50%; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                            <i class="mdi mdi-file-pdf-box" style="font-size: 30px; color: #e74a3b;"></i>
                        </div>
                        <p class="font-weight-bold text-dark mb-1" style="font-size: 14px;">Klik atau drag file PDF ke sini</p>
                        <p class="text-muted mb-0" style="font-size: 12px;">Hanya file .PDF yang diterima</p>
                    </div>

                    <div id="pdfSuccess" class="d-none">
                        <div style="background: #e3f9e5; border-radius: 50%; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                            <i class="mdi mdi-check-circle" style="font-size: 30px; color: #1cc88a;"></i>
                        </div>
                        <p class="font-weight-bold text-dark mb-1" style="font-size: 14px;">File berhasil dipilih</p>
                        <small id="pdfFileName" class="text-muted" style="font-size: 12px;"></small>
                    </div>
                </div>

                @error('ebook_file')
                    <div class="mt-2"><small class="text-danger"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</small></div>
                @enderror
            </div>
        </div>
    </div>

</div>

{{-- ===== ACTION BUTTONS ===== --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 10px;">
            <p class="mb-0 text-muted" style="font-size: 13px;">
                <i class="mdi mdi-information-outline mr-1"></i> Pastikan cover, informasi buku, dan file PDF sudah diisi.
            </p>
            <div class="d-flex" style="gap: 10px;">
                <a href="{{ route('ebooks.index') }}"
                   class="btn btn-outline-secondary"
                   style="border-radius: 8px; padding: 10px 20px; font-size: 14px; font-weight: 600;">
                    <i class="mdi mdi-close mr-1"></i> Batal
                </a>
                <button type="submit"
                        class="btn btn-primary"
                        style="border-radius: 8px; padding: 10px 24px; font-size: 14px; font-weight: 600;">
                    <i class="mdi mdi-content-save-outline mr-1"></i> Simpan e-Book
                </button>
            </div>
        </div>
    </div>
</div>

</form>

@push('styles')
<style>
    .form-control:focus {
        border-color: #4e73df !important;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // ===== COVER IMAGE =====
    const uploadArea     = document.getElementById('uploadArea');
    const coverImage     = document.getElementById('coverImage');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const imagePreview   = document.getElementById('imagePreview');
    const previewImg     = document.getElementById('previewImg');
    const previewOverlay = document.getElementById('previewOverlay');
    const imageInfo      = document.getElementById('imageInfo');
    const fileName       = document.getElementById('fileName');

    uploadArea.addEventListener('click', () => coverImage.click());

    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.style.borderColor = '#4e73df';
        uploadArea.style.background  = '#f0f4ff';
    });

    uploadArea.addEventListener('dragleave', () => {
        if (!uploadArea.classList.contains('has-image')) {
            uploadArea.style.borderColor = '#d1d3e2';
            uploadArea.style.background  = '#fdfdff';
        }
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            coverImage.files = files;
            handleImageSelect();
        }
    });

    // Overlay hover on preview
    uploadArea.addEventListener('mouseover', () => {
        if (uploadArea.classList.contains('has-image')) {
            previewOverlay.style.display = 'flex';
        }
    });

    uploadArea.addEventListener('mouseout', () => {
        previewOverlay.style.display = 'none';
    });

    coverImage.addEventListener('change', handleImageSelect);

    function handleImageSelect() {
        const file = coverImage.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImg.src = e.target.result;
            uploadPlaceholder.classList.add('d-none');
            imagePreview.classList.remove('d-none');
            imageInfo.classList.remove('d-none');
            uploadArea.classList.add('has-image');
            uploadArea.style.borderColor = '#4e73df';
            fileName.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
        };
        reader.readAsDataURL(file);
    }

    // ===== PDF FILE =====
    const ebookFile     = document.getElementById('ebookFile');
    const pdfUploadArea = document.getElementById('pdfUploadArea');
    const pdfPlaceholder = document.getElementById('pdfPlaceholder');
    const pdfSuccess    = document.getElementById('pdfSuccess');
    const pdfFileName   = document.getElementById('pdfFileName');

    pdfUploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        pdfUploadArea.style.borderColor = '#e74a3b';
        pdfUploadArea.style.background  = '#fff8f8';
    });

    pdfUploadArea.addEventListener('dragleave', () => {
        if (!pdfUploadArea.classList.contains('has-file')) {
            pdfUploadArea.style.borderColor = '#d1d3e2';
            pdfUploadArea.style.background  = '#fdfdff';
        }
    });

    pdfUploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            ebookFile.files = files;
            handlePdfSelect();
        }
    });

    ebookFile.addEventListener('change', handlePdfSelect);

    function handlePdfSelect() {
        const file = ebookFile.files[0];
        if (!file) return;
        pdfPlaceholder.classList.add('d-none');
        pdfSuccess.classList.remove('d-none');
        pdfUploadArea.classList.add('has-file');
        pdfUploadArea.style.borderColor = '#1cc88a';
        pdfUploadArea.style.background  = '#f0fdf4';
        pdfFileName.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
    }
</script>
@endpush

@endsection