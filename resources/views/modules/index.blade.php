@extends('layouts.skydash')

@section('content')
<!-- Header Section -->
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <div class="d-flex align-items-center">
                    <div>
                        <h3 class="font-weight-bold mb-2">Manajemen Modul</h3>
                        <p class="text-muted mb-0">Kelola modul Mata Pelajaran dan kontennya</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-4">
                <div class="justify-content-end d-flex">
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
                        <button type="button" class="btn btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectCourseModal">
                            <i class="icon-plus"></i> Buat Modul
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
        <div class="body-card">
            <div class="filter-card">
                <form method="GET" action="{{ route('modules.index') }}" id="searchForm">
                    <div class="row align-items-end g-3">
                        <div class="col-md-6">
                            <label for="search" class="filter-label">Cari Modul</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                value="{{ request('search') }}" placeholder="Cari berdasarkan judul, deskripsi, atau Mata Pelajaran...">
                        </div>
                        <div class="col-md-4">
                            <label for="course_id" class="filter-label">Filter berdasarkan Mata Pelajaran</label>
                            <select class="form-control" id="course_id" name="course_id">
                                <option value="">Semua Mata Pelajaran</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary btn-sm flex-grow-1">
                                    <i class="mdi mdi-magnify"></i> Cari
                                </button>
                                <a href="{{ route('modules.index') }}" class="btn btn-reset" title="Reset">
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

<!-- Modules List -->
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">
                        <i class="icon-folder text-primary"></i> Semua Modul ({{ $modules->total() }})
                    </h4>
                </div>

                @if($modules->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Urutan</th>
                                    <th>Judul</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Pelajaran</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modules as $module)
                                <tr>
                                    <td>
                                        <span class="badge badge-primary">{{ $module->order }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-1 font-weight-bold">{{ $module->title }}</h6>
                                            <small class="text-muted">ID: {{ $module->id }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <a href="{{ route('courses.show', $module->course) }}" class="text-primary">
                                                {{ $module->course->title }}
                                            </a>
                                            <br>
                                            <small class="text-muted">{{ $module->course->level }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $module->lessons->count() }} {{ Str::plural('Lesson', $module->lessons->count()) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($module->description)
                                            <p class="text-muted mb-0">{{ Str::limit($module->description, 80) }}</p>
                                        @else
                                            <span class="text-muted">Tidak ada deskripsi</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('modules.show', $module) }}" class="btn btn-sm btn-info" title="Lihat">
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
                                                <a href="{{ route('modules.edit', $module) }}" class="btn btn-sm btn-primary" title="Edit">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <form action="{{ route('modules.destroy', $module) }}" method="POST" class="d-inline"
                                                      onsubmit="event.preventDefault(); confirmDelete(event, 'Apakah Anda yakin ingin menghapus modul ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
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
                        {{ $modules->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="icon-folder" style="font-size: 64px; color: #e3e6f0;"></i>
                        <h5 class="mt-3 mb-2 text-muted">Tidak ada modul yang ditemukan</h5>
                        <p class="text-muted">
                            @if(request()->hasAny(['search', 'course_id']))
                                Coba sesuaikan kriteria pencarian Anda
                            @else
                                Belum ada modul yang dibuat
                            @endif
                        </p>
                        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectCourseModal">
                                <i class="icon-plus"></i> Buat Modul
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Course Selection Modal -->
<div class="modal fade" id="selectCourseModal" tabindex="-1" aria-labelledby="selectCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectCourseModalLabel">
                    <i class="icon-book text-primary"></i> Pilih Mata Pelajaran untuk Modul Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-4">Pilih Mata Pelajaran untuk menambahkan modul baru:</p>
                
                @if($courses->count() > 0)
                    <div class="row">s
                        @foreach($courses as $course)
                        <div class="col-md-6 mb-3">
                            <div class="card course-card h-100" style="cursor: pointer;" onclick="selectCourse({{ $course->id }}, '{{ $course->title }}')">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $course->title }}</h6>
                                    <p class="card-text text-muted small">{{ Str::limit($course->description, 80) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge badge-{{ $course->level == 'beginner' ? 'success' : ($course->level == 'intermediate' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($course->level) }}
                                        </span>
                                        <small class="text-muted">{{ $course->modules->count() }} modules</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="icon-book" style="font-size: 48px; color: #e3e6f0;"></i>
                        <h6 class="mt-3 mb-2 text-muted">Tidak ada Mata Pelajaran yang tersedia</h6>
                        <p class="text-muted">Anda perlu membuat Mata Pelajaran terlebih dahulu sebelum menambahkan modul.</p>
                        <a href="{{ route('courses.create') }}" class="btn btn-primary">
                            <i class="icon-plus"></i> Buat Mata Pelajaran
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
    
    .course-card {
        transition: all 0.3s ease;
        border: 1px solid #e3e6f0;
    }
    
    .course-card:hover {
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

function selectCourse(courseId, courseTitle) {
    // Redirect to create module page for selected course
    window.location.href = `/courses/${courseId}/modules/create`;
}
</script>
@endpush
@endsection
