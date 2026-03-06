@extends('layouts.skydash')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Kelola Aduan Siswa</h3>
                <p class="text-muted">Setujui, tolak, dan kelola aduan siswa</p>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="card-title mb-0">Total Testimoni</p>
                        <h3 class="mb-0">{{ $stats['total'] }}</h3>
                    </div>
                    <div class="icon-lg bg-primary text-white rounded">
                        <i class="mdi mdi-comment-multiple-outline"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="card-title mb-0">Disetujui</p>
                        <h3 class="mb-0 text-success">{{ $stats['approved'] }}</h3>
                    </div>
                    <div class="icon-lg bg-success text-white rounded">
                        <i class="mdi mdi-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="card-title mb-0">Menunggu</p>
                        <h3 class="mb-0 text-warning">{{ $stats['pending'] }}</h3>
                    </div>
                    <div class="icon-lg bg-warning text-white rounded">
                        <i class="mdi mdi-clock-outline"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="card-title mb-0">Unggulan</p>
                        <h3 class="mb-0 text-info">{{ $stats['featured'] }}</h3>
                    </div>
                    <div class="icon-lg bg-info text-white rounded">
                        <i class="mdi mdi-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="filter-card">
                <form action="{{ route('testimonials.manage') }}" method="GET" id="searchForm">
                    <div class="row align-items-end g-3">
                        <div class="col-md-4">
                            <label for="search" class="filter-label">Cari Aduan Siswa</label>
                            <input type="text" 
                                name="search" 
                                class="form-control search-input" 
                                placeholder="Cari aduan siswa..." 
                                value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="filter-label">Status Aduan</label>
                            <select name="status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="featured" class="filter-label">Tampilkan</label>
                            <select name="featured" class="form-control">
                                <option value="">Semua Testimoni</option>
                                <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>Hanya Unggulan</option>
                                <option value="0" {{ request('featured') === '0' ? 'selected' : '' }}>Bukan Unggulan</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary btn-sm flex-grow-1">
                                    <i class="mdi mdi-magnify"></i> Cari
                                </button>
                                <a href="{{ route('testimonials.index') }}" class="btn btn-reset" title="Reset">
                                    <i class="mdi mdi-refresh"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
    </div>
</div>

<!-- Testimonials Table -->
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Mata Pelajaran</th>
                                <th>Aduan Siswa</th>
                                <th>Penilaian</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($testimonials as $testimonial)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($testimonial->user->avatar)
                                            <img src="{{ asset('storage/' . $testimonial->user->avatar) }}" 
                                                 alt="{{ $testimonial->user->name }}" 
                                                 class="mr-2 rounded-circle"
                                                 style="width: 32px; height: 32px; object-fit: cover;">
                                        @else
                                            <img src="{{ $testimonial->user->avatar_url }}" 
                                                 alt="{{ $testimonial->user->name }}" 
                                                 class="mr-2 rounded-circle"
                                                 style="width: 32px; height: 32px; object-fit: cover;"
                                                 onerror="this.src='{{ asset('images/landing/testimonials_user.jpg') }}'">
                                        @endif
                                        <div>
                                            <div class="font-weight-bold">{{ $testimonial->user->name }}</div>
                                            <small class="text-muted">{{ $testimonial->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($testimonial->course)
                                        <span class="badge badge-info">{{ Str::limit($testimonial->course->title, 30) }}</span>
                                    @else
                                        <span class="text-muted">Umum</span>
                                    @endif
                                </td>
                                <td style="max-width: 300px;">
                                    <div style="max-height: 60px; overflow: hidden; text-overflow: ellipsis;">
                                        "{{ Str::limit($testimonial->testimonial_text, 100) }}"
                                    </div>
                                </td>
                                <td>
                                    @if($testimonial->rating)
                                        <div style="color: #ffb606;">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $testimonial->rating)
                                                    <i class="mdi mdi-star"></i>
                                                @else
                                                    <i class="mdi mdi-star-outline"></i>
                                                @endif
                                            @endfor
                                            <small class="text-muted ml-1">({{ $testimonial->rating }}/5)</small>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($testimonial->is_approved)
                                        <span class="badge badge-success">Disetujui</span>
                                    @else
                                        <span class="badge badge-warning">Menunggu</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $testimonial->created_at->format('M d, Y') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm gap-1" role="group">
                                        @if(!$testimonial->is_approved)
                                        <form action="{{ route('testimonials.approve', $testimonial) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm" title="Approve" style="border-radius: 12px 0px 0px 12px">
                                                <i class="mdi mdi-check"></i>
                                            </button>
                                        </form>
                                        @else
                                        <form action="{{ route('testimonials.reject', $testimonial) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-warning btn-sm" title="Reject" style="border-radius:12px 0px 0px 12px">
                                                <i class="mdi mdi-close"></i>
                                            </button>
                                        </form>
                                        @endif

                                        @if($testimonial->is_approved)
                                        <form action="{{ route('testimonials.toggle-featured', $testimonial) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-{{ $testimonial->is_featured ? 'info' : 'secondary' }} btn-sm" title="{{ $testimonial->is_featured ? 'Hapus dari Unggulan' : 'Tandai sebagai Unggulan' }}" style="border-radius: 0px 0px 0px 0px">
                                                <i class="mdi mdi-star{{ $testimonial->is_featured ? '' : '-outline' }}"></i>
                                            </button>
                                        </form>
                                        @endif

                                        <a href="{{ route('testimonials.index', $testimonial) }}" 
                                           class="btn btn-info btn-sm" 
                                           target="_blank"
                                           title="View">
                                            <i class="mdi mdi-eye"></i>
                                        </a>

                                        <form action="{{ route('testimonials.destroy', $testimonial) }}" 
                                              method="POST" 
                                              class="d-inline" 
                                              onsubmit="return confirm('Kamu yakin menghapus aduan siswa?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete" style="border-radius: 0px 12px 12px 0px; ">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="mdi mdi-comment-remove-outline" style="font-size: 48px; color: #ccc;"></i>
                                    <h5 class="mt-3">Tidak ada testimoni ditemukan</h5>
                                    <p class="text-muted">Coba sesuaikan kriteria pencarian Anda.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $testimonials->links() }}
                </div>
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
    
    .table-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e3e6f0;
    }
    
    .student-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
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
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
</style>
@endpush

@push('scripts')
<script>
    // Show success message if any
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });
    @endif
</script>
@endpush
@endsection

