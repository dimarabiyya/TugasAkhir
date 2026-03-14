@extends('layouts.skydash')

@php use Illuminate\Support\Facades\Storage; @endphp

@section('content')

@php
    $levelBg  = ['beginner' => '#e3f9e5', 'intermediate' => '#fff3e8', 'advanced' => '#fde8e8'];
    $levelClr = ['beginner' => '#1cc88a', 'intermediate' => '#f6c23e', 'advanced' => '#e74a3b'];
    $levelLbl = ['beginner' => 'Pemula',  'intermediate' => 'Menengah', 'advanced' => 'Mahir'];
@endphp

{{-- ===== PAGE HEADER ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px; overflow: hidden; position: relative;">
            {{-- BG thumbnail blur --}}
            @if($course->thumbnail)
            <div style="position: absolute; inset: 0; background: url('{{ Storage::url($course->thumbnail) }}') center/cover; opacity: 0.1;"></div>
            @endif
            <div class="card-body py-4 px-4" style="position: relative;">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-8 mb-3 mb-xl-0">
                        <div class="d-flex align-items-start" style="gap: 14px;">
                            {{-- Thumbnail mini --}}
                            @if($course->thumbnail)
                                <img src="{{ Storage::url($course->thumbnail) }}"
                                     style="width: 56px; height: 56px; object-fit: cover; border-radius: 10px; border: 2px solid rgba(255,255,255,0.3); flex-shrink: 0;"
                                     alt="{{ $course->title }}">
                            @else
                                <div style="background: rgba(255,255,255,0.2); border-radius: 10px; width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="mdi mdi-book-open-variant text-white" style="font-size: 28px;"></i>
                                </div>
                            @endif
                            <div>
                                <div class="d-flex align-items-center mb-1" style="gap: 8px; flex-wrap: wrap;">
                                    <span style="background: {{ $levelBg[$course->level] ?? '#e8f0fe' }}; color: {{ $levelClr[$course->level] ?? '#4e73df' }}; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">
                                        {{ $levelLbl[$course->level] ?? ucfirst($course->level) }}
                                    </span>
                                    <span style="background: {{ $course->is_published ? '#e3f9e5' : '#fff3e8' }}; color: {{ $course->is_published ? '#1cc88a' : '#f6c23e' }}; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">
                                        {{ $course->is_published ? 'Diterbitkan' : 'Draft' }}
                                    </span>
                                    @if(($course->price ?? 0) == 0)
                                    <span style="background: rgba(255,255,255,0.2); color: #fff; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">
                                        GRATIS
                                    </span>
                                    @endif
                                </div>
                                <h4 class="font-weight-bold text-white mb-1" style="line-height: 1.3;">{{ $course->title }}</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">{{ Str::limit($course->description, 90) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end" style="gap: 8px; flex-wrap: wrap;">
                        @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor')))
                            <a href="{{ route('courses.edit', $course) }}"
                               class="btn font-weight-bold"
                               style="background: #fff; color: #4e73df; border-radius: 8px; font-size: 13px; border: none;">
                                <i class="mdi mdi-pencil mr-1"></i> Edit
                            </a>
                        @endif
                        <a href="{{ route('courses.index') }}"
                           class="btn font-weight-bold"
                           style="background: rgba(255,255,255,0.2); color: #fff; border-radius: 8px; font-size: 13px; border: none;">
                            <i class="mdi mdi-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== STAT CARDS ===== --}}
<div class="row mb-4">
    @php
        $showStats = [
            ['label' => 'Total Siswa',  'value' => $course->enrollments->count(),  'icon' => 'mdi-account-group-outline', 'bg' => '#e8f0fe', 'ic' => '#4e73df'],
            ['label' => 'Modul',        'value' => $course->modules->count(),       'icon' => 'mdi-layers-outline',        'bg' => '#e3f9e5', 'ic' => '#1cc88a'],
            ['label' => 'Total Materi', 'value' => $course->lessons_count ?? 0,     'icon' => 'mdi-file-document-outline', 'bg' => '#e0f7fa', 'ic' => '#17a2b8'],
            ['label' => 'Durasi',       'value' => $course->duration_hours.'j',     'icon' => 'mdi-clock-outline',         'bg' => '#fff3e8', 'ic' => '#f6c23e'],
        ];
    @endphp
    @foreach($showStats as $s)
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

{{-- ===== MAIN CONTENT ===== --}}
<div class="row">

    {{-- ── LEFT: About + Modules ── --}}
    <div class="col-lg-8 mb-4">

        {{-- About Card --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3" style="gap: 10px;">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="mdi mdi-information-outline" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <h6 class="font-weight-bold text-dark mb-0" style="font-size: 14px;">Tentang Mata Pelajaran</h6>
                </div>
                <p class="text-muted mb-3" style="font-size: 14px; line-height: 1.8;">{{ $course->description }}</p>

                {{-- Instructor --}}
                @if($course->instructor)
                <div style="background: #f8f9fc; border-radius: 10px; padding: 12px 14px; display: flex; align-items: center; gap: 12px;">
                    @if($course->instructor->avatar)
                        <img src="{{ asset('storage/'.$course->instructor->avatar) }}"
                             style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #e3e6f0; flex-shrink: 0;"
                             alt="{{ $course->instructor->name }}">
                    @else
                        <img src="{{ $course->instructor->avatar_url }}"
                             style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #e3e6f0; flex-shrink: 0;"
                             alt="{{ $course->instructor->name }}"
                             onerror="this.src='{{ asset('images/landing/teacher_1.jpg') }}'">
                    @endif
                    <div>
                        <div style="font-size: 13px; font-weight: 700; color: #2d3748;">{{ $course->instructor->name }}</div>
                        <div style="font-size: 12px; color: #858796;">Guru / Instruktur</div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Modules Card --}}
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center" style="gap: 10px;">
                        <div style="background: #e3f9e5; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="mdi mdi-layers-outline" style="font-size: 18px; color: #1cc88a;"></i>
                        </div>
                        <h6 class="font-weight-bold text-dark mb-0" style="font-size: 14px;">
                            Modul Mata Pelajaran
                        </h6>
                    </div>
                    <div class="d-flex align-items-center" style="gap: 8px;">
                        <span style="background: #f0f0f3; color: #858796; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">
                            {{ $course->modules->count() }} modul
                        </span>
                        @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor')))
                            <a href="{{ route('modules.create', $course) }}"
                               style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 4px 12px; font-size: 11px; font-weight: 700; text-decoration: none; transition: all 0.2s;"
                               onmouseover="this.style.background='#1cc88a';this.style.color='#fff';"
                               onmouseout="this.style.background='#e3f9e5';this.style.color='#1cc88a';">
                                + Tambah
                            </a>
                        @endif
                    </div>
                </div>

                @if($course->modules->count() > 0)
                    @foreach($course->modules as $module)
                    <div style="border: 1px solid #eaecf4; border-radius: 10px; padding: 16px; margin-bottom: 10px; transition: all 0.2s;"
                         onmouseover="this.style.borderColor='#4e73df';this.style.boxShadow='0 4px 12px rgba(78,115,223,0.1)';"
                         onmouseout="this.style.borderColor='#eaecf4';this.style.boxShadow='';">
                        <div class="d-flex justify-content-between align-items-start">
                            <div style="flex: 1;">
                                <div class="d-flex align-items-center mb-2" style="gap: 8px;">
                                    <span style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 6px; padding: 2px 10px; font-size: 11px; font-weight: 700;">
                                        Modul {{ $module->order }}
                                    </span>
                                    @if($module->lessons->count() > 0)
                                        <span style="background: #e0f7fa; color: #17a2b8; border-radius: 6px; padding: 2px 8px; font-size: 11px; font-weight: 700;">
                                            {{ $module->lessons->count() }} materi
                                        </span>
                                    @endif
                                </div>
                                <a href="{{ route('modules.show', $module) }}"
                                   style="font-size: 14px; font-weight: 700; color: #2d3748; text-decoration: none; display: block; margin-bottom: 4px;"
                                   onmouseover="this.style.color='#4e73df';" onmouseout="this.style.color='#2d3748';">
                                    {{ $module->title }}
                                </a>
                                @if($module->description)
                                    <p class="text-muted mb-2" style="font-size: 12.5px; line-height: 1.5;">{{ Str::limit($module->description, 100) }}</p>
                                @endif

                                @if($module->lessons->count() > 0)
                                    <div style="margin-top: 8px;">
                                        @foreach($module->lessons->take(3) as $lesson)
                                            @php
                                                $lsnIcon  = ['video'=>'mdi-play-circle-outline','reading'=>'mdi-book-open-outline','audio'=>'mdi-volume-high','quiz'=>'mdi-pencil-circle-outline'];
                                                $lsnBg    = ['video'=>'#e8f0fe','reading'=>'#e3f9e5','audio'=>'#fff3e8','quiz'=>'#f3e8ff'];
                                                $lsnColor = ['video'=>'#4e73df','reading'=>'#1cc88a','audio'=>'#f6c23e','quiz'=>'#9b59b6'];
                                            @endphp
                                            <a href="{{ route('lessons.show', $lesson) }}"
                                               style="display: flex; align-items: center; gap: 8px; padding: 7px 10px; background: #f8f9fc; border-radius: 8px; margin-bottom: 5px; text-decoration: none; transition: background 0.15s;"
                                               onmouseover="this.style.background='#eaecf4';" onmouseout="this.style.background='#f8f9fc';">
                                                <span style="background: {{ $lsnBg[$lesson->type] ?? '#e8f0fe' }}; border-radius: 6px; width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                                    <i class="mdi {{ $lsnIcon[$lesson->type] ?? 'mdi-file-outline' }}" style="font-size: 14px; color: {{ $lsnColor[$lesson->type] ?? '#4e73df' }};"></i>
                                                </span>
                                                <span style="font-size: 12.5px; font-weight: 500; color: #2d3748;">{{ $lesson->title }}</span>
                                            </a>
                                        @endforeach
                                        @if($module->lessons->count() > 3)
                                            <p class="text-muted mb-0" style="font-size: 12px; padding-left: 4px; margin-top: 4px;">
                                                + {{ $module->lessons->count() - 3 }} materi lainnya
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor')))
                                <a href="{{ route('modules.edit', $module) }}"
                                   style="background: #e8f0fe; color: #4e73df; border-radius: 7px; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; text-decoration: none; flex-shrink: 0; margin-left: 10px; transition: all 0.2s;"
                                   onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                   onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                    <i class="mdi mdi-pencil" style="font-size: 14px;"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <div style="background: #f0f0f3; border-radius: 50%; width: 64px; height: 64px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                            <i class="mdi mdi-folder-open-outline" style="font-size: 30px; color: #c4c6d0;"></i>
                        </div>
                        <h6 class="font-weight-bold text-dark mb-1">Belum ada modul</h6>
                        <p class="text-muted mb-3" style="font-size: 13px;">Tambahkan modul untuk mengatur konten mata pelajaran</p>
                        @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor')))
                            <a href="{{ route('modules.create', $course) }}" class="btn btn-primary btn-sm" style="border-radius: 8px; font-weight: 600;">
                                <i class="mdi mdi-plus mr-1"></i> Tambah Modul Pertama
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── RIGHT: Sidebar ── --}}
    <div class="col-lg-4">

        {{-- ── Enrollment card (student) ── --}}
        @if(auth()->check() && !auth()->user()->hasAnyRole(['admin', 'instructor']))
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; border: 2px solid #4e73df !important;">
            <div class="card-body p-4">
                @if($isEnrolled)
                    <div class="d-flex align-items-center mb-3" style="gap: 10px;">
                        <div style="background: #e3f9e5; border-radius: 8px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="mdi mdi-check-circle-outline" style="font-size: 22px; color: #1cc88a;"></i>
                        </div>
                        <div>
                            <div style="font-size: 13px; font-weight: 700; color: #1cc88a;">Sudah Bergabung ✓</div>
                            <div style="font-size: 12px; color: #858796;">Anda terdaftar di mata pelajaran ini</div>
                        </div>
                    </div>

                    @if($enrollment)
                    <div style="background: #f8f9fc; border-radius: 10px; padding: 12px 14px; margin-bottom: 14px;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span style="font-size: 12px; font-weight: 600; color: #858796;">Progres Belajar</span>
                            <span style="font-size: 13px; font-weight: 700; color: #4e73df;">{{ $enrollment->progress_percentage }}%</span>
                        </div>
                        <div style="height: 8px; background: #e3e6f0; border-radius: 4px; overflow: hidden; margin-bottom: 8px;">
                            <div style="height: 100%; width: {{ $enrollment->progress_percentage }}%; background: linear-gradient(90deg, #4e73df, #224abe); border-radius: 4px; transition: width 0.6s ease;"></div>
                        </div>
                        <div style="font-size: 12px; color: #858796;">Bergabung {{ $enrollment->enrolled_at->translatedFormat('d M Y') }}</div>
                    </div>
                    @endif

                    <a href="{{ $course->url }}"
                       style="display: block; background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 10px; padding: 12px; font-size: 14px; font-weight: 700; text-align: center; text-decoration: none; margin-bottom: 8px; transition: all 0.2s;"
                       onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                        <i class="mdi mdi-play-circle-outline mr-1"></i> Lanjutkan Belajar
                    </a>
                    <form action="{{ route('enrollments.destroy', $enrollment) }}" method="POST"
                          onsubmit="event.preventDefault(); confirmDelete(event, 'Berhenti berlangganan mata pelajaran ini?');">
                        @csrf @method('DELETE')
                        <button type="submit"
                                style="display: block; width: 100%; background: transparent; color: #e74a3b; border: 1px solid #fca5a5; border-radius: 10px; padding: 10px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s;"
                                onmouseover="this.style.background='#fde8e8';" onmouseout="this.style.background='transparent';">
                            Berhenti Berlangganan
                        </button>
                    </form>

                @else
                    <div class="text-center mb-3">
                        <h6 class="font-weight-bold text-dark mb-1" style="font-size: 15px;">{{ Str::limit($course->title, 38) }}</h6>
                        @if(($course->price ?? 0) > 0)
                            <div style="font-size: 24px; font-weight: 800; color: #4e73df; margin: 6px 0;">Rp{{ number_format($course->price, 0, ',', '.') }}</div>
                        @else
                            <span style="background: #e3f9e5; color: #1cc88a; border-radius: 8px; padding: 5px 16px; font-size: 13px; font-weight: 700; display: inline-block; margin: 6px 0;">GRATIS</span>
                        @endif
                    </div>

                    @if($course->is_published)
                        <form action="{{ route('enrollments.store') }}" method="POST" class="mb-3">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <button type="submit"
                                    style="display: block; width: 100%; background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border: none; border-radius: 10px; padding: 13px; font-size: 14px; font-weight: 700; cursor: pointer; transition: opacity 0.2s;"
                                    onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                                Gabung Sekarang →
                            </button>
                        </form>
                    @else
                        <button disabled style="display: block; width: 100%; background: #d1d3e2; color: #fff; border: none; border-radius: 10px; padding: 13px; font-size: 14px; font-weight: 700; cursor: not-allowed; margin-bottom: 12px;">
                            Belum Tersedia
                        </button>
                    @endif

                    <div style="border-top: 1px solid #eaecf4; padding-top: 12px;">
                        @foreach([
                            ['mdi-clock-outline', $course->duration_hours.' Jam', 'Durasi'],
                            ['mdi-signal-cellular-3', ($levelLbl[$course->level] ?? ucfirst($course->level)), 'Tingkat'],
                            ['mdi-layers-outline', $course->modules->count().' Modul', 'Modul'],
                            ['mdi-file-document-outline', ($course->lessons_count ?? 0).' Materi', 'Materi'],
                        ] as [$icon, $val, $lbl])
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 7px 0; border-bottom: 1px solid #f0f0f3;">
                            <span style="font-size: 12.5px; color: #858796; display: flex; align-items: center; gap: 7px;">
                                <i class="mdi {{ $icon }}" style="font-size: 15px;"></i>{{ $lbl }}
                            </span>
                            <span style="font-size: 13px; font-weight: 700; color: #2d3748;">{{ $val }}</span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        @endif

        {{-- ── Quick Actions (admin/instructor) ── --}}
        @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor')))
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3" style="gap: 10px;">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="mdi mdi-lightning-bolt-outline" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <h6 class="font-weight-bold text-dark mb-0" style="font-size: 14px;">Aksi Cepat</h6>
                </div>

                <a href="{{ route('courses.edit', $course) }}"
                   style="display: flex; align-items: center; justify-content: center; gap: 8px; background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 10px; padding: 11px; font-size: 13px; font-weight: 700; text-decoration: none; margin-bottom: 8px; transition: opacity 0.2s;"
                   onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                    <i class="mdi mdi-pencil-outline" style="font-size: 15px;"></i> Edit Mata Pelajaran
                </a>

                <form action="{{ route('courses.destroy', $course) }}" method="POST" class="mb-2"
                      onsubmit="event.preventDefault(); confirmDelete(event, 'Hapus mata pelajaran ini secara permanen?');">
                    @csrf @method('DELETE')
                    <button type="submit"
                            style="display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; background: #fde8e8; color: #e74a3b; border: none; border-radius: 10px; padding: 10px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.background='#e74a3b';this.style.color='#fff';"
                            onmouseout="this.style.background='#fde8e8';this.style.color='#e74a3b';">
                        <i class="mdi mdi-delete-outline" style="font-size: 15px;"></i> Hapus Mata Pelajaran
                    </button>
                </form>

                @if(auth()->user()->hasRole('admin'))
                <form action="{{ route('courses.toggle-published', $course) }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit"
                            style="display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; background: {{ $course->is_published ? '#fff3e8' : '#e3f9e5' }}; color: {{ $course->is_published ? '#f6c23e' : '#1cc88a' }}; border: none; border-radius: 10px; padding: 10px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.opacity='0.8';" onmouseout="this.style.opacity='1';">
                        <i class="mdi mdi-{{ $course->is_published ? 'eye-off-outline' : 'eye-outline' }}" style="font-size: 15px;"></i>
                        {{ $course->is_published ? 'Jadikan Draft' : 'Terbitkan' }}
                    </button>
                </form>
                @endif

                {{-- Metadata --}}
                <div style="border-top: 1px solid #eaecf4; margin-top: 14px; padding-top: 14px;">
                    <div style="margin-bottom: 8px;">
                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 3px;">Dibuat</div>
                        <div style="font-size: 13px; font-weight: 600; color: #2d3748;">{{ $course->created_at->translatedFormat('d M Y') }}</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 3px;">Diperbarui</div>
                        <div style="font-size: 13px; font-weight: 600; color: #2d3748;">{{ $course->updated_at->translatedFormat('d M Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

@endsection