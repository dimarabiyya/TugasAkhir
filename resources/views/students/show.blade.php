@extends('layouts.skydash')

@section('content')

@php
    $levelColors = ['beginner' => ['bg'=>'#e3f9e5','c'=>'#1cc88a'], 'intermediate' => ['bg'=>'#fff3e8','c'=>'#f6c23e'], 'advanced' => ['bg'=>'#fde8e8','c'=>'#e74a3b']];
    $levelLabels = ['beginner' => 'Pemula', 'intermediate' => 'Menengah', 'advanced' => 'Lanjutan'];
@endphp

{{-- ===== PAGE HEADER ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
            <div class="card-body py-4 px-4">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-8 mb-3 mb-xl-0">
                        <div class="d-flex align-items-center" style="gap: 16px;">
                            {{-- Avatar --}}
                            <div style="position: relative; flex-shrink: 0;">
                                <img src="{{ $student->avatar_url }}" alt="{{ $student->name }}"
                                     style="width: 64px; height: 64px; border-radius: 50%; object-fit: cover; border: 3px solid rgba(255,255,255,0.4);">
                                <div style="position: absolute; bottom: 2px; right: 2px; width: 16px; height: 16px; border-radius: 50%; border: 2px solid #fff; background: {{ $student->email_verified_at ? '#1cc88a' : '#f6c23e' }};"></div>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-1">{{ $student->name }}</h4>
                                <div class="d-flex flex-wrap" style="gap: 6px; align-items: center;">
                                    <span style="background: rgba(255,255,255,0.2); color: #fff; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">
                                        #{{ $student->id }}
                                    </span>
                                    @if($student->level)
                                    @php $lc = $levelColors[$student->level] ?? ['bg'=>'rgba(255,255,255,0.15)','c'=>'#fff']; @endphp
                                    <span style="background: rgba(255,255,255,0.2); color: #fff; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">
                                        {{ $levelLabels[$student->level] ?? ucfirst($student->level) }}
                                    </span>
                                    @endif
                                    <span style="background: rgba(255,255,255,0.2); color: #fff; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">
                                        <i class="mdi mdi-email-outline mr-1"></i>{{ $student->email }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end" style="gap: 8px; flex-wrap: wrap;">
                        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
                        <a href="{{ route('students.edit', $student) }}"
                           class="btn font-weight-bold"
                           style="background: rgba(255,255,255,0.15); color: #fff; border-radius: 8px; font-size: 13px; border: 1px solid rgba(255,255,255,0.3);">
                            <i class="mdi mdi-pencil mr-1"></i> Edit
                        </a>
                        @endif
                        <a href="{{ route('students.index') }}"
                           class="btn font-weight-bold"
                           style="background: #fff; color: #4e73df; border-radius: 8px; font-size: 13px; border: none;">
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
    <div class="col-6 col-md-3 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm text-center" style="border-radius: 12px;">
            <div class="card-body py-3 px-3">
                <div style="background: #e8f0fe; border-radius: 8px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;">
                    <i class="mdi mdi-book-outline" style="font-size: 20px; color: #4e73df;"></i>
                </div>
                <p class="font-weight-bold text-dark mb-0" style="font-size: 22px;">{{ $stats['total_enrollments'] }}</p>
                <small class="text-muted">Total Pendaftaran</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm text-center" style="border-radius: 12px;">
            <div class="card-body py-3 px-3">
                <div style="background: #e3f9e5; border-radius: 8px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;">
                    <i class="mdi mdi-check-circle-outline" style="font-size: 20px; color: #1cc88a;"></i>
                </div>
                <p class="font-weight-bold text-dark mb-0" style="font-size: 22px;">{{ $stats['completed_courses'] }}</p>
                <small class="text-muted">Mapel Selesai</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center" style="border-radius: 12px;">
            <div class="card-body py-3 px-3">
                <div style="background: #e0f7fa; border-radius: 8px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;">
                    <i class="mdi mdi-play-circle-outline" style="font-size: 20px; color: #17a2b8;"></i>
                </div>
                <p class="font-weight-bold text-dark mb-0" style="font-size: 22px;">{{ $stats['total_lessons_completed'] }}</p>
                <small class="text-muted">Materi Selesai</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center" style="border-radius: 12px;">
            <div class="card-body py-3 px-3">
                <div style="background: #fff3e8; border-radius: 8px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;">
                    <i class="mdi mdi-help-circle-outline" style="font-size: 20px; color: #f6c23e;"></i>
                </div>
                <p class="font-weight-bold text-dark mb-0" style="font-size: 22px;">{{ number_format($stats['average_quiz_score'], 1) }}%</p>
                <small class="text-muted">Rata-rata Kuis</small>
            </div>
        </div>
    </div>
</div>

<div class="row">

    {{-- ===== LEFT COLUMN ===== --}}
    <div class="col-lg-8 mb-4">

        {{-- Mata Pelajaran Card --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center justify-content-between px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div class="d-flex align-items-center">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-book-open-outline" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <h5 class="mb-0 font-weight-bold text-dark">Mata Pelajaran</h5>
                    </div>
                    <a href="{{ route('courses.index') }}"
                       style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 5px 12px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s;"
                       onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                       onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                        <i class="mdi mdi-plus mr-1"></i> Jelajahi
                    </a>
                </div>

                @if($student->enrollments->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th style="padding: 10px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Mata Pelajaran</th>
                                <th style="padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Kemajuan</th>
                                <th style="padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Status</th>
                                <th style="padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($student->enrollments as $enrollment)
                            @php $pct = $enrollment->progress_percentage ?? 0; @endphp
                            <tr style="transition: background 0.15s ease;"
                                onmouseover="this.style.background='#f8f9fc';"
                                onmouseout="this.style.background='white';">
                                <td style="padding: 12px 20px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px;">{{ $enrollment->course->title }}</p>
                                    <small class="text-muted">{{ ucfirst($enrollment->course->level) }} &bull; {{ $enrollment->enrolled_at->format('d M Y') }}</small>
                                </td>
                                <td style="padding: 12px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; min-width: 140px;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div style="flex: 1; height: 6px; background: #e3e6f0; border-radius: 4px; overflow: hidden;">
                                            <div style="height: 100%; width: {{ $pct }}%; border-radius: 4px; background: {{ $pct >= 100 ? '#1cc88a' : ($pct >= 50 ? '#4e73df' : '#f6c23e') }};"></div>
                                        </div>
                                        <span style="font-size: 12px; font-weight: 600; color: #5a5c69; flex-shrink: 0;">{{ $pct }}%</span>
                                    </div>
                                </td>
                                <td style="padding: 12px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    @if($enrollment->completed_at)
                                        <span style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">Selesai</span>
                                    @elseif($pct > 0)
                                        <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">Berlangsung</span>
                                    @else
                                        <span style="background: #f4f6fb; color: #858796; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">Belum Mulai</span>
                                    @endif
                                </td>
                                <td style="padding: 12px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                                    <a href="{{ route('enrollments.show', $enrollment) }}"
                                       style="background: #e8f0fe; color: #4e73df; border-radius: 8px; width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;"
                                       onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                       onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                        <i class="mdi mdi-eye" style="font-size: 14px;"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="mdi mdi-book-open-outline" style="font-size: 36px; color: #d1d3e2;"></i>
                    <p class="text-muted mt-2 mb-0" style="font-size: 13px;">Siswa belum mengambil mata pelajaran apapun.</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Kuis Terbaru --}}
        @if($student->quizAttempts->count() > 0)
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center justify-content-between px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div class="d-flex align-items-center">
                        <div style="background: #fff3e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-help-circle-outline" style="font-size: 18px; color: #f6c23e;"></i>
                        </div>
                        <h5 class="mb-0 font-weight-bold text-dark">Percobaan Kuis Terbaru</h5>
                    </div>
                    @if($student->quizAttempts->count() > 5)
                    <small class="text-muted">{{ $student->quizAttempts->count() }} total</small>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th style="padding: 10px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Kuis</th>
                                <th style="padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Skor</th>
                                <th style="padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Status</th>
                                <th style="padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($student->quizAttempts->take(5) as $attempt)
                            <tr style="transition: background 0.15s ease;"
                                onmouseover="this.style.background='#f8f9fc';"
                                onmouseout="this.style.background='white';">
                                <td style="padding: 12px 20px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px;">{{ $attempt->quiz->title }}</p>
                                    <small class="text-muted">{{ $attempt->quiz->lesson->module->course->title }}</small>
                                </td>
                                <td style="padding: 12px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    @php $score = $attempt->score; @endphp
                                    <span style="background: {{ $score >= 70 ? '#e3f9e5' : ($score >= 50 ? '#fff3e8' : '#fde8e8') }}; color: {{ $score >= 70 ? '#1cc88a' : ($score >= 50 ? '#f6c23e' : '#e74a3b') }}; border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 700;">
                                        {{ $score }}%
                                    </span>
                                </td>
                                <td style="padding: 12px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    @if($attempt->completed_at)
                                        <span style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">Selesai</span>
                                    @else
                                        <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">Berlangsung</span>
                                    @endif
                                </td>
                                <td style="padding: 12px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <span style="font-size: 12.5px; color: #5a5c69;">{{ $attempt->created_at->format('d M Y') }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- ===== RIGHT COLUMN ===== --}}
    <div class="col-lg-4 mb-4">

        {{-- Info Card --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-account-outline" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Informasi Siswa</h5>
                </div>
                <div class="p-4">
                    @foreach([
                        ['label' => 'Nama Lengkap',    'icon' => 'mdi-account-outline',   'value' => $student->name],
                        ['label' => 'Email',            'icon' => 'mdi-email-outline',      'value' => $student->email],
                        ['label' => 'Telepon',          'icon' => 'mdi-phone-outline',      'value' => $student->phone ?? '—'],
                        ['label' => 'Bergabung',        'icon' => 'mdi-calendar-outline',   'value' => $student->created_at->format('d M Y')],
                        ['label' => 'Terakhir Update',  'icon' => 'mdi-update',             'value' => $student->updated_at->diffForHumans()],
                    ] as $item)
                    <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #f0f0f3;">
                        <span class="text-muted" style="font-size: 12.5px;"><i class="mdi {{ $item['icon'] }} mr-1"></i>{{ $item['label'] }}</span>
                        <span class="font-weight-bold text-dark" style="font-size: 12.5px; text-align: right; max-width: 60%;">{{ $item['value'] }}</span>
                    </div>
                    @endforeach

                    {{-- Level --}}
                    @if($student->level)
                    <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #f0f0f3;">
                        <span class="text-muted" style="font-size: 12.5px;"><i class="mdi mdi-signal-cellular-outline mr-1"></i>Tingkat</span>
                        @php $lc = $levelColors[$student->level] ?? ['bg'=>'#f4f6fb','c'=>'#858796']; @endphp
                        <span style="background: {{ $lc['bg'] }}; color: {{ $lc['c'] }}; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">
                            {{ $levelLabels[$student->level] ?? ucfirst($student->level) }}
                        </span>
                    </div>
                    @endif

                    {{-- Email status --}}
                    <div class="d-flex justify-content-between align-items-center py-2">
                        <span class="text-muted" style="font-size: 12.5px;"><i class="mdi mdi-email-check-outline mr-1"></i>Status Email</span>
                        @if($student->email_verified_at)
                            <span style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">Terverifikasi</span>
                        @else
                            <span style="background: #fff3e8; color: #f6c23e; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">Belum</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Progress Card --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e3f9e5; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-trending-up" style="font-size: 18px; color: #1cc88a;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Kemajuan Pembelajaran</h5>
                </div>
                <div class="p-4">
                    {{-- Course completion --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span style="font-size: 12.5px; color: #5a5c69;">Penyelesaian Mapel</span>
                            <span style="font-size: 12.5px; font-weight: 700; color: #2d3748;">{{ $stats['completed_courses'] }}/{{ $stats['total_enrollments'] }}</span>
                        </div>
                        <div style="height: 6px; background: #e3e6f0; border-radius: 4px; overflow: hidden;">
                            <div style="height: 100%; width: {{ $stats['total_enrollments'] > 0 ? ($stats['completed_courses'] / $stats['total_enrollments']) * 100 : 0 }}%; background: linear-gradient(90deg, #4e73df, #224abe); border-radius: 4px;"></div>
                        </div>
                    </div>
                    {{-- Quiz score --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span style="font-size: 12.5px; color: #5a5c69;">Performa Kuis</span>
                            <span style="font-size: 12.5px; font-weight: 700; color: #2d3748;">{{ number_format($stats['average_quiz_score'], 1) }}%</span>
                        </div>
                        <div style="height: 6px; background: #e3e6f0; border-radius: 4px; overflow: hidden;">
                            <div style="height: 100%; width: {{ $stats['average_quiz_score'] }}%; background: linear-gradient(90deg, #f6c23e, #e0a800); border-radius: 4px;"></div>
                        </div>
                    </div>
                    {{-- Total attempts --}}
                    <div class="d-flex justify-content-between py-2" style="border-top: 1px solid #f0f0f3;">
                        <span style="font-size: 12.5px; color: #5a5c69;">Total Percobaan Kuis</span>
                        <span style="font-size: 13px; font-weight: 700; color: #2d3748;">{{ $stats['total_quiz_attempts'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Admin Actions --}}
        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #fff3e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-cog-outline" style="font-size: 18px; color: #f6c23e;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Aksi Cepat</h5>
                </div>
                <div class="p-4">
                    <a href="{{ route('students.edit', $student) }}"
                       class="btn btn-block mb-3"
                       style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 10px; border: none;">
                        <i class="mdi mdi-pencil mr-1"></i> Edit Siswa
                    </a>
                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="m-0"
                          onsubmit="confirmDelete(event, 'Akun siswa ini akan dihapus secara permanen!');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-block"
                                style="background: #fff5f5; color: #e74a3b; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 10px; border: 1px solid #fdd; width: 100%; transition: all 0.2s;"
                                {{ $student->enrollments->count() > 0 ? 'disabled' : '' }}
                                onmouseover="if(!this.disabled){this.style.background='#e74a3b';this.style.color='#fff';}"
                                onmouseout="if(!this.disabled){this.style.background='#fff5f5';this.style.color='#e74a3b';}">
                            <i class="mdi mdi-delete mr-1"></i> Hapus Siswa
                        </button>
                    </form>
                    @if($student->enrollments->count() > 0)
                    <p class="text-muted mt-2 mb-0" style="font-size: 11px; text-align: center;">
                        <i class="mdi mdi-alert-circle-outline mr-1"></i>Tidak dapat dihapus masih memiliki pendaftaran
                    </p>
                    @endif
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

@endsection