@extends('layouts.skydash')

@section('content')

<!-- Testimonials -->
<div class="elements">
    <div class="container">
        <!-- Title -->
        <div class="row">
            <div class="col">
                <div class="elements_title text-center">
                    <h1>Daftar Aduan siswa</h1>
                    <p class="text-muted mt-3">Baca testimoni dari siswa yang telah mengikuti kursus kami</p>
                </div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="row">
            <div class="col-lg-8">
                    <div class="filter-card">
                        <form action="{{ route('testimonials.index') }}" method="GET" id="searchForm">
                            <div class="row align-items-end g-3">
                                <div class="col-md-6">
                                    <label for="search" class="filter-label">Cari Aduan</label>
                                     <input type="text" 
                                         name="search" 
                                         class="form-control" 
                                         placeholder="Cari Aduan..." 
                                         value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <select name="course_id" class="form-control">
                                        <option value="">Semua Kursus</option>
                                        @foreach($courses ?? [] as $course)
                                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <select name="featured" class="form-control">
                                        <option value="">All Testimonials</option>
                                        <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Featured Only</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="button button_1 mr-2">
                                        <span>Cari</span>
                                    </button>
                                    @if(request()->hasAny(['search', 'course_id', 'featured']))
                                    <a href="{{ route('testimonials.index') }}" class="button button_outline">
                                        <span>Bersihkan Filter</span>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                
            </div>
        </div>

        <!-- Testimonials Grid -->
        @if($testimonials->count() > 0)
        <div class="row icon_boxes_container">
            @foreach($testimonials as $testimonial)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="icon_box text-left d-flex flex-column align-items-start justify-content-start h-100" 
                     style="background: #f8f9fa; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); height: 100%;">
                    <!-- Rating Stars -->
                    @if($testimonial->rating)
                    <div class="mb-3" style="color: #ffb606;">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $testimonial->rating)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                        <span class="ml-2 text-muted">({{ $testimonial->rating }}/5)</span>
                    </div>
                    @endif

                    <!-- Testimonial Text -->
                    <div class="mb-3" style="flex-grow: 1;">
                        <p style="font-style: italic; color: #555; line-height: 1.8;">
                            "{{ Str::limit($testimonial->testimonial_text, 200) }}"
                        </p>
                    </div>

                    <!-- User Info -->
                    <div class="d-flex align-items-center w-100" style="border-top: 1px solid #e9ecef; padding-top: 15px;">
                        <div class="mr-3">
                            @if($testimonial->user->avatar)
                                <img src="{{ asset('storage/' . $testimonial->user->avatar) }}" 
                                     alt="{{ $testimonial->user->name }}" 
                                     style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                            @else
                                <img src="{{ $testimonial->user->avatar_url }}" 
                                     alt="{{ $testimonial->user->name }}" 
                                     style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;"
                                     onerror="this.src='{{ asset('images/landing/testimonials_user.jpg') }}'">
                            @endif
                        </div>
                        <div style="flex: 1;">
                            <h6 class="mb-1" style="color: #1e40af; font-weight: 600;">{{ $testimonial->user->name }}</h6>
                            @if($testimonial->course)
                            <p class="text-muted mb-0" style="font-size: 0.875rem;">
                                <i class="fas fa-book mr-1"></i>{{ Str::limit($testimonial->course->title, 30) }}
                            </p>
                            @else
                            <p class="text-muted mb-0" style="font-size: 0.875rem;">Student</p>
                            @endif
                        </div>
                        @if($testimonial->is_featured)
                        <div>
                            <span class="badge badge-warning" style="font-size: 0.75rem;">
                                <i class="fas fa-star"></i> Featured
                            </span>
                        </div>
                        @endif
                    </div>

                    <!-- Date -->
                    <div class="mt-2 w-100">
                        <small class="text-muted">
                            <i class="mdi mdi-calendar mr-1"></i>{{ $testimonial->created_at->format('M d, Y') }}
                        </small>
                    </div>

                    <!-- Action Buttons (for own testimonial) -->
                    @auth
                        @if(auth()->id() == $testimonial->user_id)
                        <div class="mt-3 w-100" style="border-top: 1px solid #e9ecef; padding-top: 10px;">
                            <a href="{{ route('testimonials.edit', $testimonial) }}" class="btn btn-sm btn-outline-primary mr-2">
                                <i class="mdi mdi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('testimonials.destroy', $testimonial) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                        @endif
                    @endauth
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row mt-5">
            <div class="col">
                <div class="d-flex justify-content-center">
                    {{ $testimonials->links() }}
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col text-center py-5">
                <i class="fas fa-comments" style="font-size: 64px; color: #ccc;"></i>
                <h4 class="mt-3">Tidak ada testimoni ditemukan</h4>
                <p class="text-muted">
                    @if(request()->hasAny(['search', 'course_id', 'featured']))
                        Coba sesuaikan kriteria pencarian Anda.
                    @else
                        Belum ada testimoni yang dipublikasikan.
                    @endif
                </p>
                @auth
                @if(auth()->user()->hasRole('student'))
                <a href="{{ route('testimonials.create') }}" class="button button_1 mt-3">
                    <span>Jadilah yang Pertama Membagikan</span>
                </a>
                @endif
                @endauth
            </div>
        </div>
        @endif
    </div>
</div>

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/landing/elements_styles.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/landing/elements_responsive.css') }}">
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

    .button_outline {
        background: transparent;
        border: 2px solid #ffb606;
        height: 48px;
        padding-left: 38px;
        padding-right: 38px;
        border-radius: 0px;
        text-align: center;
        cursor: pointer;
        display: inline-block;
        transition: all 200ms ease;
        text-decoration: none;
    }
    
    .button_outline span {
        font-size: 14px;
        font-weight: 700;
        color: #ffb606;
        text-transform: uppercase;
        line-height: 48px;
        white-space: nowrap;
        text-decoration: none;
    }
    
    .button_outline:hover {
        background: #ffb606;
    }
    
    .button_outline:hover span {
        color: #FFFFFF;
    }

    .icon_box {
        transition: all 0.3s ease;
    }

    .icon_box:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/landing/elements_custom.js') }}"></script>
@endpush
@endsection

