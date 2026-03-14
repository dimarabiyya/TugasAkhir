@extends('layouts.skydash')

@php
use Illuminate\Support\Facades\Storage;
@endphp

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
                                <i class="mdi mdi-book-open-variant text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))
                                    <h4 class="font-weight-bold text-white mb-0">Manajemen Mata Pelajaran</h4>
                                    <p class="text-white-50 mb-0" style="font-size: 13px;">Kelola dan atur semua mata pelajaran di platform Anda</p>
                                @else
                                    <h4 class="font-weight-bold text-white mb-0">Mata Pelajaran Tersedia</h4>
                                    <p class="text-white-50 mb-0" style="font-size: 13px;">Jelajahi dan daftar mata pelajaran</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('courses.create') }}"
                           class="btn font-weight-bold"
                           style="background: #fff; color: #4e73df; border-radius: 8px; font-size: 13px; border: none;">
                            <i class="mdi mdi-plus mr-1"></i> Tambah Mapel Baru
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== STAT CARDS ===== --}}
<div class="row mb-4">
    @php
        $allCourses = $courses instanceof \Illuminate\Pagination\LengthAwarePaginator ? $courses->getCollection() : $courses;
        $courseStats = [
            ['label' => 'Total Mapel',    'value' => $courses instanceof \Illuminate\Pagination\LengthAwarePaginator ? $courses->total() : $courses->count(), 'icon' => 'mdi-book-open-variant',  'bg' => '#e8f0fe', 'ic' => '#4e73df'],
            ['label' => 'Diterbitkan',    'value' => $allCourses->where('is_published', true)->count(),   'icon' => 'mdi-check-circle-outline', 'bg' => '#e3f9e5', 'ic' => '#1cc88a'],
            ['label' => 'Draf',           'value' => $allCourses->where('is_published', false)->count(),  'icon' => 'mdi-pencil-box-outline',   'bg' => '#fff3e8', 'ic' => '#f6c23e'],
            ['label' => 'Total Modul',    'value' => $allCourses->sum(fn($c) => $c->modules->count()),    'icon' => 'mdi-layers-outline',       'bg' => '#e0f7fa', 'ic' => '#17a2b8'],
        ];
    @endphp
    @foreach($courseStats as $s)
    <div class="col-6 col-md-3 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">{{ $s['label'] }}</p>
                        <h3 class="font-weight-bold text-dark mb-0" style="font-size: 26px;">{{ $s['value'] }}</h3>
                    </div>
                    <div style="background: {{ $s['bg'] }}; border-radius: 10px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="mdi {{ $s['icon'] }}" style="font-size: 22px; color: {{ $s['ic'] }};"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ===== FILTER BAR ===== --}}
@if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-3">
                <form action="{{ route('courses.index') }}" method="GET">
                    <div class="row align-items-end" style="row-gap: 10px;">
                        <div class="col-md-4">
                            <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 5px; display: block;">Cari Mata Pelajaran</label>
                            <div style="position: relative;">
                                <i class="mdi mdi-magnify" style="position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: #adb5bd; font-size: 16px;"></i>
                                <input type="text" name="search" class="form-control" placeholder="Ketik kata kunci…"
                                       value="{{ request('search') }}"
                                       style="padding-left: 38px; border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 42px;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 5px; display: block;">Tingkat</label>
                            <select name="level" class="form-control" style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 42px; appearance: none; -webkit-appearance: none; padding-right: 36px; cursor: pointer;">
                                <option value="">Semua Tingkat</option>
                                <option value="beginner"     {{ request('level') == 'beginner'     ? 'selected' : '' }}>Pemula</option>
                                <option value="intermediate" {{ request('level') == 'intermediate' ? 'selected' : '' }}>Menengah</option>
                                <option value="advanced"     {{ request('level') == 'advanced'     ? 'selected' : '' }}>Lanjutan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 5px; display: block;">Status</label>
                            <select name="published" class="form-control" style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 42px; appearance: none; -webkit-appearance: none; padding-right: 36px; cursor: pointer;">
                                <option value="">Semua Status</option>
                                <option value="1" {{ request('published') == '1' ? 'selected' : '' }}>Diterbitkan</option>
                                <option value="0" {{ request('published') == '0' ? 'selected' : '' }}>Draf</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex" style="gap: 8px;">
                            <button type="submit" class="btn btn-primary flex-fill" style="border-radius: 8px; font-size: 13px; font-weight: 600;">
                                <i class="mdi mdi-magnify mr-1"></i> Cari
                            </button>
                            <a href="{{ route('courses.index') }}" title="Reset"
                               style="border-radius: 8px; background: #f0f0f3; color: #858796; border: none; padding: 0 12px; display: flex; align-items: center; text-decoration: none;"
                               onmouseover="this.style.background='#e3e6f0';" onmouseout="this.style.background='#f0f0f3';">
                                <i class="mdi mdi-refresh" style="font-size: 17px;"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ===== COURSE CARDS GRID ===== --}}
<div class="row">
    @forelse($courses as $course)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card border-0 shadow-sm h-100"
             style="border-radius: 12px; border: 1px solid #eaecf4 !important; transition: all 0.22s ease; overflow: hidden;"
             onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 24px rgba(78,115,223,0.12)';"
             onmouseout="this.style.transform='';this.style.boxShadow='';">

            {{-- Thumbnail --}}
            @if($course->thumbnail)
                <img src="{{ Storage::url($course->thumbnail) }}"
                     alt="{{ $course->title }}"
                     style="width: 100%; height: 160px; object-fit: cover;">
            @else
                <div style="height: 160px; background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); display: flex; align-items: center; justify-content: center;">
                    <i class="mdi mdi-book-open-variant" style="font-size: 52px; color: rgba(255,255,255,0.25);"></i>
                </div>
            @endif

            <div class="card-body p-4 d-flex flex-column">

                {{-- Instructor + Level badge --}}
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center" style="gap: 5px; flex: 1; min-width: 0;">
                        @if($course->instructor)
                            @if($course->instructor->avatar)
                                <img src="{{ asset('storage/'.$course->instructor->avatar) }}"
                                     style="width: 18px; height: 18px; border-radius: 50%; object-fit: cover; flex-shrink: 0;" alt="">
                            @else
                                <i class="mdi mdi-account-circle-outline text-muted" style="font-size: 16px; flex-shrink: 0;"></i>
                            @endif
                        @else
                            <i class="mdi mdi-account-outline text-muted" style="font-size: 14px; flex-shrink: 0;"></i>
                        @endif
                        <span class="text-muted" style="font-size: 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ optional($course->instructor)->name ?? 'Belum ditugaskan' }}
                        </span>
                    </div>
                    @php
                        $levelBg  = ['beginner' => '#e3f9e5', 'intermediate' => '#fff3e8', 'advanced' => '#fde8e8'];
                        $levelClr = ['beginner' => '#1cc88a', 'intermediate' => '#f6c23e', 'advanced' => '#e74a3b'];
                        $levelLbl = ['beginner' => 'Pemula',  'intermediate' => 'Menengah', 'advanced' => 'Lanjutan'];
                    @endphp
                    <span style="flex-shrink: 0; margin-left: 8px;
                        background: {{ $levelBg[$course->level] ?? '#e8f0fe' }};
                        color: {{ $levelClr[$course->level] ?? '#4e73df' }};
                        border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">
                        {{ $levelLbl[$course->level] ?? ucfirst($course->level) }}
                    </span>
                </div>

                {{-- Title --}}
                <h5 class="font-weight-bold text-dark mb-2" style="font-size: 14.5px; line-height: 1.4;">{{ $course->title }}</h5>

                {{-- Description --}}
                <p class="text-muted mb-3" style="font-size: 12.5px; line-height: 1.6; flex: 1;">
                    {{ Str::limit($course->description, 80) }}
                </p>

                {{-- Meta: duration + modules + status --}}
                <div class="d-flex align-items-center mb-3" style="gap: 10px; flex-wrap: wrap;">
                    <span class="d-flex align-items-center text-muted" style="font-size: 12px; gap: 3px;">
                        <i class="mdi mdi-clock-outline" style="font-size: 14px;"></i> {{ $course->duration_hours }}j
                    </span>
                    <span class="d-flex align-items-center text-muted" style="font-size: 12px; gap: 3px;">
                        <i class="mdi mdi-layers-outline" style="font-size: 14px;"></i> {{ $course->modules->count() }} modul
                    </span>
                    <span style="
                        background: {{ $course->is_published ? '#e3f9e5' : '#fff3e8' }};
                        color: {{ $course->is_published ? '#1cc88a' : '#f6c23e' }};
                        border-radius: 6px; padding: 2px 9px; font-size: 11px; font-weight: 700;">
                        {{ $course->is_published ? 'Diterbitkan' : 'Draf' }}
                    </span>
                </div>

                {{-- Actions --}}
                <div class="d-flex mt-auto" style="gap: 6px;">
                    <a href="{{ $course->url }}"
                       class="btn flex-fill btn-sm"
                       style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 8px; font-size: 13px; font-weight: 600; padding: 8px; border: none;">
                        <i class="mdi mdi-eye mr-1"></i> Buka Mapel
                    </a>
                    @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))
                    <a href="{{ route('courses.edit', $course) }}" title="Edit"
                       style="background: #e8f0fe; color: #4e73df; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s; flex-shrink: 0;"
                       onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                       onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                        <i class="mdi mdi-pencil" style="font-size: 15px;"></i>
                    </a>
                    <form action="{{ route('courses.destroy', $course) }}" method="POST" class="d-inline m-0"
                          onsubmit="event.preventDefault(); confirmDelete(event);">
                        @csrf @method('DELETE')
                        <button type="submit" title="Hapus"
                                style="background: #fde8e8; color: #e74a3b; border: none; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; flex-shrink: 0;"
                                onmouseover="this.style.background='#e74a3b';this.style.color='#fff';"
                                onmouseout="this.style.background='#fde8e8';this.style.color='#e74a3b';">
                            <i class="mdi mdi-delete" style="font-size: 15px;"></i>
                        </button>
                    </form>
                    @endif
                </div>

            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body text-center py-5">
                <div style="background: #f0f0f3; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="mdi mdi-book-open-page-variant-outline" style="font-size: 40px; color: #c4c6d0;"></i>
                </div>
                <h5 class="font-weight-bold text-dark mb-1">Belum Ada Mata Pelajaran</h5>
                <p class="text-muted mb-4" style="font-size: 14px;">
                    @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))
                        Mulai dengan membuat mata pelajaran pertama Anda!
                    @else
                        Belum ada mata pelajaran yang tersedia saat ini.
                    @endif
                </p>
                @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))
                <a href="{{ route('courses.create') }}" class="btn btn-primary" style="border-radius: 8px; font-weight: 600; padding: 10px 24px;">
                    <i class="mdi mdi-plus mr-1"></i> Buat Mata Pelajaran Pertama
                </a>
                @endif
            </div>
        </div>
    </div>
    @endforelse
</div>

@endsection