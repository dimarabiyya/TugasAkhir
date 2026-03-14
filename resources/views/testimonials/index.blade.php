@extends('layouts.skydash')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
            <div class="card-body py-4 px-4">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-8 mb-3 mb-xl-0">
                        <div class="d-flex align-items-center">
                            <div style="background: rgba(255,255,255,0.2); border-radius: 10px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; margin-right: 14px; flex-shrink: 0;">
                                <i class="mdi mdi-comment-quote-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Aduan & Testimoni Siswa</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Aspirasi dan pengalaman siswa yang telah dipublikasikan</p>
                            </div>
                        </div>
                    </div>
                    @auth
                    @if(auth()->user()->hasRole('student'))
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('testimonials.create') }}" class="btn btn-light font-weight-bold" style="border-radius: 8px; font-size: 13px; color: #4e73df;">
                            <i class="mdi mdi-plus mr-1"></i> Tambah Testimoni
                        </a>
                    </div>
                    @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== SEARCH & FILTER ===== --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body p-4">
        <form action="{{ route('testimonials.index') }}" method="GET">
            <div class="row align-items-end" style="gap: 0; row-gap: 12px;">

                {{-- Search --}}
                <div class="col-md-5">
                    <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 6px; display: block;">
                        <i class="mdi mdi-magnify mr-1"></i> Cari Aduan
                    </label>
                    <div style="position: relative;">
                        <i class="mdi mdi-magnify" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-size: 18px; color: #adb5bd; pointer-events: none;"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Ketik kata kunci..."
                               style="width: 100%; padding: 10px 14px 10px 38px; border: 1px solid #d1d3e2; border-radius: 8px; font-size: 13px; color: #3d3d3d; outline: none; transition: border-color 0.2s;"
                               onfocus="this.style.borderColor='#4e73df';"
                               onblur="this.style.borderColor='#d1d3e2';">
                    </div>
                </div>

                {{-- Kursus --}}
                <div class="col-md-3">
                    <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 6px; display: block;">
                        <i class="mdi mdi-library-outline mr-1"></i> Mata Pelajaran
                    </label>
                    <div style="position: relative;">
                        <select name="course_id"
                                style="width: 100%; padding: 10px 36px 10px 14px; border: 1px solid #d1d3e2; border-radius: 8px; font-size: 13px; color: #3d3d3d; background: #fff; appearance: none; -webkit-appearance: none; outline: none; cursor: pointer; transition: border-color 0.2s;"
                                onfocus="this.style.borderColor='#4e73df';"
                                onblur="this.style.borderColor='#d1d3e2';">
                            <option value="">Semua Mata Pelajaran</option>
                            @foreach($courses ?? [] as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                            @endforeach
                        </select>
                        <i class="mdi mdi-chevron-down" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); font-size: 18px; color: #adb5bd; pointer-events: none;"></i>
                    </div>
                </div>

                {{-- Featured --}}
                <div class="col-md-2">
                    <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 6px; display: block;">
                        <i class="mdi mdi-star-outline mr-1"></i> Filter
                    </label>
                    <div style="position: relative;">
                        <select name="featured"
                                style="width: 100%; padding: 10px 36px 10px 14px; border: 1px solid #d1d3e2; border-radius: 8px; font-size: 13px; color: #3d3d3d; background: #fff; appearance: none; -webkit-appearance: none; outline: none; cursor: pointer; transition: border-color 0.2s;"
                                onfocus="this.style.borderColor='#4e73df';"
                                onblur="this.style.borderColor='#d1d3e2';">
                            <option value="">Semua</option>
                            <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Unggulan</option>
                        </select>
                        <i class="mdi mdi-chevron-down" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); font-size: 18px; color: #adb5bd; pointer-events: none;"></i>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="col-md-2 d-flex" style="gap: 6px; align-items: flex-end;">
                    <button type="submit"
                            style="flex: 1; padding: 10px 12px; border-radius: 8px; border: none; background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 4px; white-space: nowrap; box-shadow: 0 3px 8px rgba(78,115,223,.3); transition: opacity 0.2s;"
                            onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                        <i class="mdi mdi-magnify" style="font-size: 16px;"></i> Cari
                    </button>
                    @if(request()->hasAny(['search', 'course_id', 'featured']))
                    <a href="{{ route('testimonials.index') }}"
                       style="padding: 10px 12px; border-radius: 8px; border: 1px solid #d1d3e2; background: #fff; color: #858796; font-size: 13px; text-decoration: none; display: flex; align-items: center; justify-content: center; transition: background 0.2s;"
                       title="Reset filter"
                       onmouseover="this.style.background='#f0f0f3';" onmouseout="this.style.background='#fff';">
                        <i class="mdi mdi-close" style="font-size: 16px;"></i>
                    </a>
                    @endif
                </div>

            </div>
        </form>
    </div>
</div>

{{-- ===== TESTIMONIAL CARDS ===== --}}
@if($testimonials->count() > 0)

<div class="row">
    @foreach($testimonials as $testimonial)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card border-0 shadow-sm h-100"
             style="border-radius: 14px; overflow: hidden; transition: all 0.25s cubic-bezier(.4,0,.2,1);"
             onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 10px 28px rgba(78,115,223,0.12)';"
             onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='';">

            {{-- Featured bar --}}
            @if($testimonial->is_featured)
            <div style="height: 4px; background: linear-gradient(90deg, #f6c23e, #e0a800);"></div>
            @else
            <div style="height: 4px; background: #f0f0f3;"></div>
            @endif

            <div class="card-body p-4 d-flex flex-column">

                {{-- Rating + Featured badge --}}
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div style="display: flex; align-items: center; gap: 2px;">
                        @if($testimonial->rating)
                            @for($i = 1; $i <= 5; $i++)
                            <i class="mdi {{ $i <= $testimonial->rating ? 'mdi-star' : 'mdi-star-outline' }}" style="font-size: 16px; color: {{ $i <= $testimonial->rating ? '#f6c23e' : '#d1d3e2' }};"></i>
                            @endfor
                            <span style="font-size: 11px; color: #858796; margin-left: 5px; font-weight: 600;">{{ number_format($testimonial->rating, 1) }}</span>
                        @else
                            <span style="font-size: 11px; color: #adb5bd; font-style: italic;">Tidak ada rating</span>
                        @endif
                    </div>
                    @if($testimonial->is_featured)
                    <span style="background: #fff3cd; color: #b8860b; border-radius: 20px; padding: 3px 10px; font-size: 10px; font-weight: 700; display: inline-flex; align-items: center; gap: 3px;">
                        <i class="mdi mdi-star" style="font-size: 11px;"></i> Unggulan
                    </span>
                    @endif
                </div>

                {{-- Testimonial text --}}
                <div style="flex: 1; margin-bottom: 16px;">
                    <p style="font-size: 13px; color: #4a5568; line-height: 1.7; font-style: italic; margin: 0;">
                        "{{ Str::limit($testimonial->testimonial_text, 200) }}"
                    </p>
                </div>

                {{-- Divider --}}
                <div style="height: 1px; background: #f0f0f3; margin-bottom: 14px;"></div>

                {{-- User info --}}
                <div class="d-flex align-items-center" style="gap: 10px; margin-bottom: 10px;">
                    <div style="flex-shrink: 0;">
                        @if($testimonial->user->avatar)
                            <img src="{{ asset('storage/' . $testimonial->user->avatar) }}"
                                 alt="{{ $testimonial->user->name }}"
                                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #e8f0fe;">
                        @else
                            <img src="{{ $testimonial->user->avatar_url }}"
                                 alt="{{ $testimonial->user->name }}"
                                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #e8f0fe;"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                            <div style="display: none; width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #4e73df, #224abe); align-items: center; justify-content: center; flex-shrink: 0;">
                                <span style="color: #fff; font-size: 15px; font-weight: 700;">{{ strtoupper(substr($testimonial->user->name, 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>
                    <div style="flex: 1; overflow: hidden;">
                        <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $testimonial->user->name }}</p>
                        @if($testimonial->course)
                        <p class="mb-0" style="font-size: 11px; color: #4e73df; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <i class="mdi mdi-book-open-outline mr-1"></i>{{ Str::limit($testimonial->course->title, 28) }}
                        </p>
                        @else
                        <p class="mb-0" style="font-size: 11px; color: #858796;">
                            <i class="mdi mdi-account-outline mr-1"></i>Aduan Umum
                        </p>
                        @endif
                    </div>
                    <div style="flex-shrink: 0;">
                        <small style="font-size: 10px; color: #adb5bd;">
                            {{ $testimonial->created_at->format('d M Y') }}
                        </small>
                    </div>
                </div>

                {{-- Own testimonial actions --}}
                @auth
                @if(auth()->id() == $testimonial->user_id)
                <div style="border-top: 1px solid #f0f0f3; padding-top: 12px; display: flex; gap: 6px;">
                    <a href="{{ route('testimonials.edit', $testimonial) }}"
                       style="flex: 1; padding: 7px 10px; border-radius: 8px; background: #e8f0fe; color: #4e73df; font-size: 12px; font-weight: 600; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 5px; transition: all 0.2s;"
                       onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                       onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                        <i class="mdi mdi-pencil-outline" style="font-size: 14px;"></i> Edit
                    </a>
                    <form action="{{ route('testimonials.destroy', $testimonial) }}" method="POST" style="flex: 1; margin: 0;">
                        @csrf @method('DELETE')
                        <button type="submit"
                                onclick="return confirmDelete(event, 'Testimoni ini akan dihapus permanen!')"
                                style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #fde8e8; color: #e74a3b; font-size: 12px; font-weight: 600; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 5px; transition: all 0.2s;"
                                onmouseover="this.style.background='#e74a3b';this.style.color='#fff';"
                                onmouseout="this.style.background='#fde8e8';this.style.color='#e74a3b';">
                            <i class="mdi mdi-delete-outline" style="font-size: 14px;"></i> Hapus
                        </button>
                    </form>
                </div>
                @endif
                @endauth

            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Pagination --}}
@if($testimonials->hasPages())
<div class="d-flex justify-content-center mt-2 mb-4">
    {{ $testimonials->links() }}
</div>
@endif

@else

{{-- ===== EMPTY STATE ===== --}}
<div class="card border-0 shadow-sm text-center py-5" style="border-radius: 14px;">
    <div class="card-body">
        <div style="background: #f0f0f3; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
            <i class="mdi mdi-comment-off-outline" style="font-size: 40px; color: #c4c6d0;"></i>
        </div>
        <h5 class="font-weight-bold text-dark mb-1">
            @if(request()->hasAny(['search', 'course_id', 'featured']))
                Tidak Ada Hasil Ditemukan
            @else
                Belum Ada Testimoni
            @endif
        </h5>
        <p class="text-muted mb-3" style="font-size: 13px; max-width: 300px; margin: 0 auto 16px;">
            @if(request()->hasAny(['search', 'course_id', 'featured']))
                Coba sesuaikan kata kunci atau filter pencarian kamu.
            @else
                Belum ada testimoni yang dipublikasikan.
            @endif
        </p>
        <div class="d-flex justify-content-center" style="gap: 8px; flex-wrap: wrap;">
            @if(request()->hasAny(['search', 'course_id', 'featured']))
            <a href="{{ route('testimonials.index') }}" class="btn btn-outline-secondary" style="border-radius: 8px; font-size: 13px;">
                <i class="mdi mdi-filter-off-outline mr-1"></i> Reset Filter
            </a>
            @endif
            @auth
            @if(auth()->user()->hasRole('student'))
            <a href="{{ route('testimonials.create') }}" class="btn btn-primary" style="border-radius: 8px; font-size: 13px; font-weight: 600;">
                <i class="mdi mdi-plus mr-1"></i> Jadilah yang Pertama
            </a>
            @endif
            @endauth
        </div>
    </div>
</div>

@endif

@endsection