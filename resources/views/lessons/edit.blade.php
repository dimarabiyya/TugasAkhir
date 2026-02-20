@extends('layouts.skydash')

@section('content')
<!-- Header Section -->
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <div class="d-flex align-items-center">
                    <div>
                        <h3 class="font-weight-bold mb-2">Edit Materi</h3>
                        <p class="text-muted mb-0">Perbarui "{{ $lesson->title }}" di "{{ $lesson->module->title }}"</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-4">
                <div class="justify-content-end d-flex">
                    <a href="{{ route('lessons.show', $lesson) }}" class="btn btn-light mr-2">
                        <i class="mdi mdi-eye"></i> Lihat Materi
                    </a>
                    <a href="{{ route('modules.show', $lesson->module) }}" class="btn btn-outline-secondary">
                        <i class="mdi mdi-arrow-left"></i> Kembali ke Modul
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lesson Info Card -->
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-gradient-primary text-white mr-3">
                        <i class="mdi mdi-book-open"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">{{ $lesson->title }}</h5>
                        <p class="text-muted mb-0">
                            Materi {{ $lesson->order }} • {{ ucfirst($lesson->type) }} • 
                            Modul: {{ $lesson->module->title }} • Mata Pelajaran: {{ $lesson->module->course->title }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Lesson Form -->
<div class="row">
    <div class="col-md-8 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">
                    <i class="mdi mdi-pencil text-primary"></i> Informasi Materi
                </h4>

                <form action="{{ route('lessons.update', $lesson) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group mb-4">
                        <label for="title" class="form-label">
                            Judul Materi <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $lesson->title) }}" 
                               placeholder="Masukkan judul Materi"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="3" 
                                  placeholder="Masukkan deskripsi Materi (opsional)">{{ old('description', $lesson->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="type" class="form-label">
                            Tipe Materi <span class="text-danger">*</span>
                        </label>
                        <select class="form-control @error('type') is-invalid @enderror" 
                                id="type" 
                                name="type" 
                                required>
                            <option value="">Pilih tipe Materi</option>
                            @foreach($lessonTypes as $type)
                                <option value="{{ $type }}" {{ old('type', $lesson->type) == $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="content_url" class="form-label">URL Konten</label>
                        <input type="url" 
                               class="form-control @error('content_url') is-invalid @enderror" 
                               id="content_url" 
                               name="content_url" 
                               value="{{ old('content_url', $lesson->content_url) }}" 
                               placeholder="https://example.com/video">
                        @error('content_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            URL untuk video, audio, atau konten eksternal
                        </small>
                    </div>

                    <div class="form-group mb-4">
                        <label for="content_text" class="form-label">Teks Konten</label>
                        <textarea class="form-control @error('content_text') is-invalid @enderror" 
                                  id="content_text" 
                                  name="content_text" 
                                  rows="6" 
                                  placeholder="Masukkan teks konten Materi (opsional)">{{ old('content_text', $lesson->content_text) }}</textarea>
                        @error('content_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Konten teks untuk Materi membaca atau informasi tambahan
                        </small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="duration_minutes" class="form-label">Duration (minutes)</label>
                                <input type="number" 
                                       class="form-control @error('duration_minutes') is-invalid @enderror" 
                                       id="duration_minutes" 
                                       name="duration_minutes" 
                                       value="{{ old('duration_minutes', $lesson->duration_minutes) }}" 
                                       min="1"
                                       max="999"
                                       placeholder="30">
                                @error('duration_minutes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="order" class="form-label">
                                    Urutan <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control @error('order') is-invalid @enderror" 
                                       id="order" 
                                       name="order" 
                                       value="{{ old('order', $lesson->order) }}" 
                                       min="1"
                                       max="999"
                                       required>
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <div class="form-check">
                            <input type="checkbox" 
                                   class="form-check-input" 
                                   id="is_free" 
                                   name="is_free" 
                                   value="1" 
                                   {{ old('is_free', $lesson->is_free) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_free">
                                Materi ini gratis
                            </label>
                        </div>
                        <small class="form-text text-muted">
                            Materi gratis dapat diakses tanpa pendaftaran
                        </small>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary mr-3">
                            <i class="mdi mdi-check"></i> Perbarui Materi
                        </button>
                        <a href="{{ route('lessons.show', $lesson) }}" class="btn btn-secondary">
                            <i class="mdi mdi-close"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4 grid-margin">
        <!-- Lesson Stats -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="mdi mdi-chart text-info"></i> Statistik Materi
                </h5>
                
                <div class="stat-item d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div>
                        <i class="mdi mdi-clock text-primary mr-2"></i>
                        <span class="text-muted">Durasi</span>
                    </div>
                    <h4 class="mb-0 font-weight-bold text-primary">{{ $lesson->duration_minutes ? $lesson->duration_minutes . 'm' : '-' }}</h4>
                </div>
                
                <div class="stat-item d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div>
                        <i class="mdi mdi-calendar text-info mr-2"></i>
                        <span class="text-muted">Dibuat</span>
                    </div>
                    <h6 class="mb-0 font-weight-bold text-info">{{ $lesson->created_at->format('M d, Y') }}</h6>
                </div>
                
                <div class="stat-item d-flex justify-content-between align-items-center">
                    <div>
                        <i class="mdi mdi-update text-success mr-2"></i>
                        <span class="text-muted">Pembaruan Terakhir</span>
                    </div>
                    <h6 class="mb-0 font-weight-bold text-success">{{ $lesson->updated_at->format('M d, Y') }}</h6>
                </div>
            </div>
        </div>

        <!-- Module Info -->
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="mdi mdi-folder text-warning"></i> Informasi Modul
                </h5>
                
                <div class="module-info">
                    <h6 class="mb-2">{{ $lesson->module->title }}</h6>
                    <p class="text-muted mb-2">Module {{ $lesson->module->order }}</p>
                    <p class="text-muted mb-3">{{ Str::limit($lesson->module->description, 100) }}</p>
                    
                    <a href="{{ route('modules.show', $lesson->module) }}" class="btn btn-outline-primary btn-block mb-3">
                        <i class="mdi mdi-eye mr-2"></i> Lihat Modul
                    </a>
                    
                    <div class="module-stats">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Materi:</span>
                            <strong>{{ $lesson->module->lessons->count() }}</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Mata Pelajaran:</span>
                            <strong>{{ $lesson->module->course->title }}</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Level:</span>
                            <strong>{{ $lesson->module->course->level }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="card mt-3 border-danger">
            <div class="card-body">
                <h5 class="card-title mb-4 text-danger">
                    <i class="mdi mdi-delete"></i> Zona Bahaya
                </h5>
                
                <p class="text-muted mb-3 small">
                    Menghapus Materi ini akan menghapusnya secara permanen beserta semua data progresnya. Tindakan ini tidak dapat dibatalkan.
                </p>
                
                @if($lesson->quiz)
                    <div class="alert alert-warning mb-3">
                        <i class="mdi mdi-warning"></i>
                        <strong>Peringatan:</strong> Materi ini berisi kuis. 
                        Anda harus menghapus kuis sebelum menghapus Materi ini.
                    </div>
                @endif
                
                <form action="{{ route('lessons.destroy', $lesson) }}" method="POST" 
                      onsubmit="event.preventDefault(); confirmDelete(event, 'Apakah Anda yakin ingin menghapus Materi ini? Tindakan ini tidak dapat dibatalkan.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="btn btn-danger btn-block" 
                            {{ $lesson->quiz ? 'disabled' : '' }}>
                        <i class="mdi mdi-delete mr-2"></i> Hapus Materi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .stat-item:last-child {
        border-bottom: none !important;
    }
    
    .module-stats {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
    }
    
    .card.border-danger {
        border-color: #dc3545 !important;
    }
    
    .alert-warning {
        background-color: #fff3cd;
        border-color: #ffeaa7;
        color: #856404;
    }
</style>
@endpush

@push('scripts')
<script>
function confirmDelete(event, message) {
    if (confirm(message)) {
        event.target.closest('form').submit();
    }
}
</script>
@endpush
@endsection
