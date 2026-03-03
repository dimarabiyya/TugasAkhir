@extends('layouts.skydash')

@section('content')
<!-- Header Section -->
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <div class="d-flex align-items-center">
                    <div>
                        <h3 class="font-weight-bold mb-2">Manajemen Materi</h3>
                        <p class="text-muted mb-0">Kelola Materi Mata Pelajaran dan kontennya</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-4">
                <div class="justify-content-end d-flex">
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
                        <button type="button" class="btn btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectModuleModal">
                            <i class="mdi mdi-plus"></i> Buat Materi
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card-body">
            <div class="filter-card">
                <form method="GET" action="{{ route('lessons.index') }}" id="searchForm">
                    <div class="row align-items-end g-3">
                    <div class="col-md-4 ">
                        <label for="search" class="filter-label">Cari Materi</label>
                        <div class="search-input-wrapper">
                            <i class="mdi mdi-magnify search-icon"></i>
                            <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Cari berdasarkan judul, deskripsi, atau Mata Pelajaran...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="module_id" class="filter-label">Filter berdasarkan Modul</label>
                        <select class="form-control" id="module_id" name="module_id">
                            <option value="">Semua Modul</option>
                            @foreach($modules as $module)
                                <option value="{{ $module->id }}" {{ request('module_id') == $module->id ? 'selected' : '' }}>
                                    {{ $module->course->title }} - {{ $module->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="type" class="filter-label">Filter berdasarkan Tipe</label>
                        <select class="form-control" id="type" name="type">
                            <option value="">Semua Tipe</option>
                            @foreach($lessonTypes as $type)
                                <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-sm btn-primary flex-grow-1">
                                    <i class="mdi mdi-magnify"></i> Cari
                                </button>
                                <a href="{{ route('courses.index') }}" class="btn-reset" title="Reset">
                                    <i class="mdi mdi-refresh"></i>
                                </a>
                            </div>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Lessons List -->
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">
                        <i class="mdi mdi-book-open text-primary"></i> Semua Materi ({{ $lessons->total() }})
                    </h4>
                </div>

                @if($lessons->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Urutan</th>
                                    <th>Judul</th>
                                    <th>Tipe</th>
                                    <th>Modul</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Durasi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lessons as $lesson)
                                <tr>
                                    <td>
                                        <span class="badge badge-primary">{{ $lesson->order }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-1 font-weight-bold">{{ $lesson->title }}</h6>
                                            @if($lesson->description)
                                                <small class="text-muted">{{ Str::limit($lesson->description, 60) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $typeColors = [
                                                'video' => 'info',
                                                'reading' => 'success',
                                                'audio' => 'warning',
                                                'interactive' => 'primary'
                                            ];
                                        @endphp
                                        <span class="badge badge-{{ $typeColors[$lesson->type] ?? 'secondary' }}">
                                            {{ ucfirst($lesson->type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="font-weight-medium">{{ $lesson->module->title }}</span>
                                            <br>
                                            <small class="text-muted">Module {{ $lesson->module->order }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <a href="{{ route('courses.show', $lesson->module->course) }}" class="text-primary">
                                                {{ $lesson->module->course->title }}
                                            </a>
                                            <br>
                                            <small class="text-muted">{{ $lesson->module->course->level }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @if($lesson->duration_minutes)
                                            <span class="text-muted">
                                                <i class="mdi mdi-clock mr-1"></i>{{ $lesson->duration_minutes }}m
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($lesson->is_free)
                                            <span class="badge badge-success">FREE</span>
                                        @else
                                            <span class="badge badge-secondary">PAID</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('lessons.show', $lesson) }}" class="btn btn-sm btn-info" title="View">
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
                                                <a href="{{ route('lessons.edit', $lesson) }}" class="btn btn-sm btn-primary" title="Edit">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <form action="{{ route('lessons.destroy', $lesson) }}" method="POST" class="d-inline"
                                                      onsubmit="event.preventDefault(); confirmDelete(event, 'Kamu yakin menghapus Materi ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                        <i class="mdi mdi-delete"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $lessons->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="mdi mdi-book-open" style="font-size: 64px; color: #e3e6f0;"></i>
                        <h5 class="mt-3 mb-2 text-muted">Tidak ada Materi yang ditemukan</h5>
                        <p class="text-muted">
                            @if(request()->hasAny(['search', 'module_id', 'type', 'is_free']))
                                Coba sesuaikan kriteria pencarian Anda
                            @else
                                Belum ada Materi yang dibuat
                            @endif
                        </p>
                        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectModuleModal">
                                <i class="mdi mdi-plus"></i> Buat Materi
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Module Selection Modal -->
<div class="modal fade" id="selectModuleModal" tabindex="-1" aria-labelledby="selectModuleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectModuleModalLabel">
                    <i class="mdi mdi-folder text-primary"></i> Pilih Modul untuk Materi Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-4">Pilih modul untuk menambahkan Materi baru:</p>
                
                @if($modules->count() > 0)
                    <div class="row">
                        @foreach($modules as $module)
                        <div class="col-md-6 mb-3">
                            <div class="card module-card h-100" style="cursor: pointer;" onclick="selectLessonModule({{ $module->id }}, '{{ $module->title }}')">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $module->title }}</h6>
                                    <p class="card-text text-muted small">{{ Str::limit($module->description, 80) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge badge-primary">Modul {{ $module->order }}</span>
                                        <small class="text-muted">{{ $module->lessons->count() }} Materi</small>
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <strong>Mata Pelajaran:</strong> {{ $module->course->title }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="mdi mdi-folder" style="font-size: 48px; color: #e3e6f0;"></i>
                        <h6 class="mt-3 mb-2 text-muted">Tidak ada modul yang tersedia</h6>
                        <p class="text-muted">Anda perlu membuat modul terlebih dahulu sebelum menambahkan Materi.</p>
                        <a href="{{ route('courses.index') }}" class="btn btn-primary">
                            <i class="mdi mdi-plus"></i> Buat Modul
                        </a>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .filter-card {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #ffffff;
    border-radius: 16px;
    padding: 20px 24px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06), 0 1px 3px rgba(0,0,0,0.04);
    border: 1px solid #f0f0f0;
  }
  .filter-label {
    font-size: 11px; font-weight: 600; letter-spacing: 0.6px;
    text-transform: uppercase; color: #9ca3af; margin-bottom: 6px; display: block;
  }
  .filter-card .form-control {
    font-size: 14px; font-weight: 500; color: #111827;
    background: #f9fafb; border: 1.5px solid #e5e7eb;
    border-radius: 10px; padding: 9px 14px; height: auto;
    transition: all 0.2s; box-shadow: none;
  }
  .filter-card .form-control:focus {
    background: #fff; border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
  }
  .search-input-wrapper { position: relative; }
  .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 17px; pointer-events: none; }
  .search-input-wrapper .form-control { padding-left: 38px; }
  select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239ca3af' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; cursor: pointer; }
  .btn-search { font-size: 13px; font-weight: 600; background: linear-gradient(135deg,#6366f1,#4f46e5); color: #fff; border: none; border-radius: 10px; padding: 9px 20px; display: flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(99,102,241,0.3); transition: all 0.2s; cursor: pointer; }
  .btn-search:hover { background: linear-gradient(135deg,#4f46e5,#4338ca); transform: translateY(-1px); box-shadow: 0 4px 14px rgba(99,102,241,0.4); color:#fff; }
  .btn-reset { font-size: 13px; font-weight: 600; background: #f3f4f6; color: #6b7280; border: 1.5px solid #e5e7eb; border-radius: 10px; padding: 9px 14px; display: flex; align-items: center; gap: 6px; transition: all 0.2s; cursor: pointer; text-decoration: none; }
  .btn-reset:hover { background: #e5e7eb; color: #374151; }

    .table th {
        border-top: none;
        font-weight: 600;
        color: #495057;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .btn-group .btn {
        margin-right: 2px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    
    .module-card {
        transition: all 0.3s ease;
        border: 1px solid #e3e6f0;
    }
    
    .module-card:hover {
        border-color: #667eea;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        transform: translateY(-2px);
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

function selectLessonModule(moduleId) {
    window.location.href =
        "{{ route('modules.lessons.create', ':id') }}".replace(':id', moduleId);
}
</script>
@endpush
@endsection
