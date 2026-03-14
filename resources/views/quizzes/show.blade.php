@extends('layouts.skydash')

@section('content')

@php
    $isAdmin = auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']);
@endphp

{{-- ===== PAGE HEADER ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
            <div class="card-body py-4 px-4">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-8 mb-3 mb-xl-0">
                        <div class="d-flex align-items-center" style="gap: 12px; margin-bottom: 8px;">
                            <h4 class="font-weight-bold text-white mb-0">{{ $quiz->title }}</h4>
                            @php
                                $statusCfg = [
                                    'published' => ['bg'=>'rgba(28,200,138,0.25)','c'=>'#fff','label'=>'Dipublikasikan'],
                                    'draft'     => ['bg'=>'rgba(246,194,62,0.3)', 'c'=>'#fff','label'=>'Draf'],
                                    'archived'  => ['bg'=>'rgba(255,255,255,0.2)','c'=>'#fff','label'=>'Diarsipkan'],
                                ];
                                $sc = $statusCfg[$quiz->status] ?? $statusCfg['draft'];
                            @endphp
                            <span style="background: {{ $sc['bg'] }}; color: {{ $sc['c'] }}; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700; flex-shrink: 0;">
                                {{ $sc['label'] }}
                            </span>
                            @if($quiz->isAvailable())
                            <span style="background: rgba(28,200,138,0.25); color: #fff; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700; flex-shrink: 0;">
                                <i class="mdi mdi-check mr-1"></i>Tersedia
                            </span>
                            @endif
                        </div>
                        {{-- Breadcrumb --}}
                        <div class="d-flex align-items-center flex-wrap" style="gap: 4px;">
                            <a href="{{ route('courses.index') }}" class="text-white-50" style="font-size: 12px; text-decoration: none;">Mata Pelajaran</a>
                            <span class="text-white-50" style="font-size: 12px;">›</span>
                            <span class="text-white-50" style="font-size: 12px;">{{ $quiz->lesson->module->course->title ?? 'N/A' }}</span>
                            <span class="text-white-50" style="font-size: 12px;">›</span>
                            <span class="text-white-50" style="font-size: 12px;">{{ $quiz->lesson->module->title ?? 'N/A' }}</span>
                            <span class="text-white-50" style="font-size: 12px;">›</span>
                            <span class="text-white-50" style="font-size: 12px;">{{ $quiz->lesson->title ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end flex-wrap" style="gap: 8px;">
                        @if($isAdmin)
                        <a href="{{ route('quiz.questions.index', $quiz) }}"
                           class="btn font-weight-bold"
                           style="background: rgba(255,255,255,0.15); color: #fff; border-radius: 8px; font-size: 13px; border: 1px solid rgba(255,255,255,0.3);">
                            <i class="mdi mdi-help-circle-outline mr-1"></i> Pertanyaan
                        </a>
                        <a href="{{ route('quizzes.edit', $quiz) }}"
                           class="btn font-weight-bold"
                           style="background: rgba(255,255,255,0.15); color: #fff; border-radius: 8px; font-size: 13px; border: 1px solid rgba(255,255,255,0.3);">
                            <i class="mdi mdi-pencil mr-1"></i> Edit
                        </a>
                        @endif
                        @if(!$isAdmin && $quiz->isAvailable() && $quiz->canUserAttempt(auth()->id()))
                        <a href="{{ route('quiz.taking.start', $quiz) }}"
                           class="btn font-weight-bold"
                           style="background: #1cc88a; color: #fff; border-radius: 8px; font-size: 13px; border: none;">
                            <i class="mdi mdi-play mr-1"></i> Mulai Kuis
                        </a>
                        @endif
                        <a href="{{ route('quizzes.index') }}"
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

{{-- Description / Instructions --}}
@if($quiz->description)
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #4e73df !important;">
            <div class="card-body py-3 px-4 d-flex align-items-center" style="gap: 10px;">
                <i class="mdi mdi-information-outline" style="font-size: 20px; color: #4e73df; flex-shrink: 0;"></i>
                <p class="mb-0 text-dark" style="font-size: 13.5px;">{{ $quiz->description }}</p>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">

    {{-- ===== LEFT COLUMN ===== --}}
    <div class="col-md-8 mb-4">

        {{-- Stat mini cards --}}
        <div class="row mb-4">
            @foreach([
                ['label'=>'Skor Lulus',   'value'=> $quiz->passing_score.'%',                                         'icon'=>'mdi-check-circle-outline',  'bg'=>'#e8f0fe','ic'=>'#4e73df'],
                ['label'=>'Batas Waktu',  'value'=> $quiz->time_limit_minutes ? $quiz->time_limit_minutes.'m' : '∞',  'icon'=>'mdi-clock-outline',         'bg'=>'#fde8e8','ic'=>'#e74a3b'],
                ['label'=>'Pertanyaan',   'value'=> $quiz->questions->count(),                                         'icon'=>'mdi-help-circle-outline',   'bg'=>'#fff3e8','ic'=>'#f6c23e'],
                ['label'=>'Total Upaya',  'value'=> $quiz->attempts->count(),                                          'icon'=>'mdi-account-group-outline', 'bg'=>'#e3f9e5','ic'=>'#1cc88a'],
            ] as $s)
            <div class="col-6 col-md-3 mb-3 mb-md-0">
                <div class="card border-0 shadow-sm text-center" style="border-radius: 12px;">
                    <div class="card-body py-3 px-2">
                        <div style="background: {{ $s['bg'] }}; border-radius: 8px; width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;">
                            <i class="mdi {{ $s['icon'] }}" style="font-size: 20px; color: {{ $s['ic'] }};"></i>
                        </div>
                        <h4 class="font-weight-bold text-dark mb-0" style="font-size: 20px;">{{ $s['value'] }}</h4>
                        <p class="text-muted mb-0" style="font-size: 11px;">{{ $s['label'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Quiz Settings (admin) --}}
        @if($isAdmin)
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-cog-outline" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Pengaturan Kuis</h5>
                </div>
                <div class="p-4">
                    <div class="row">
                        @foreach([
                            ['label'=>'Upaya Ganda',             'val'=> $quiz->allow_multiple_attempts, 'extra'=> $quiz->allow_multiple_attempts && $quiz->max_attempts ? '(Maks: '.$quiz->max_attempts.')' : ''],
                            ['label'=>'Acak Pertanyaan',         'val'=> $quiz->shuffle_questions,       'extra'=> ''],
                            ['label'=>'Acak Jawaban',            'val'=> $quiz->shuffle_answers,         'extra'=> ''],
                            ['label'=>'Tampilkan Jawaban Benar', 'val'=> $quiz->show_correct_answers,    'extra'=> ''],
                            ['label'=>'Penilaian Negatif',       'val'=> $quiz->negative_marking,        'extra'=> $quiz->negative_marking ? '(' . (($quiz->negative_mark_value ?? 0.25) * 100) . '%)' : ''],
                            ['label'=>'Izinkan Navigasi',        'val'=> $quiz->allow_navigation,        'extra'=> ''],
                        ] as $setting)
                        <div class="col-md-6 mb-2">
                            <div class="d-flex align-items-center justify-content-between py-2" style="border-bottom: 1px solid #f0f0f3;">
                                <span class="text-muted" style="font-size: 13px;">{{ $setting['label'] }}</span>
                                <div class="d-flex align-items-center" style="gap: 6px;">
                                    @if($setting['extra'])
                                        <small class="text-muted">{{ $setting['extra'] }}</small>
                                    @endif
                                    <span style="background: {{ $setting['val'] ? '#e3f9e5' : '#f4f6fb' }}; color: {{ $setting['val'] ? '#1cc88a' : '#858796' }}; border-radius: 6px; padding: 2px 9px; font-size: 11px; font-weight: 700;">
                                        {{ $setting['val'] ? 'Ya' : 'Tidak' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Schedule --}}
        @if($quiz->start_date || $quiz->end_date)
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e0f7fa; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-calendar-outline" style="font-size: 18px; color: #17a2b8;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Jadwal Kuis</h5>
                </div>
                <div class="p-4">
                    <div class="row">
                        @if($quiz->start_date)
                        <div class="col-md-6">
                            <p class="text-muted mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Dimulai</p>
                            <p class="font-weight-bold text-dark mb-0">{{ $quiz->start_date->format('d M Y, H:i') }}</p>
                        </div>
                        @endif
                        @if($quiz->end_date)
                        <div class="col-md-6">
                            <p class="text-muted mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Berakhir</p>
                            <p class="font-weight-bold text-dark mb-0">{{ $quiz->end_date->format('d M Y, H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Questions List (admin) --}}
        @if($isAdmin)
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center justify-content-between px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div class="d-flex align-items-center">
                        <div style="background: #fff3e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-help-circle-outline" style="font-size: 18px; color: #f6c23e;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Pertanyaan ({{ $quiz->questions->count() }})</h5>
                        </div>
                    </div>
                    <a href="{{ route('quiz.questions.index', $quiz) }}"
                       style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 5px 12px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s;"
                       onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                       onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                        <i class="mdi mdi-plus mr-1"></i> Tambah
                    </a>
                </div>

                @if($quiz->questions->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th style="padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">#</th>
                                <th style="padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Pertanyaan</th>
                                <th style="padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Tipe</th>
                                <th style="padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Poin</th>
                                <th style="padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Kesulitan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quiz->questions as $q)
                            @php
                                $diffCfg = ['easy'=>['#e3f9e5','#1cc88a','Mudah'],'medium'=>['#fff3e8','#f6c23e','Menengah'],'hard'=>['#fde8e8','#e74a3b','Sulit']];
                                $dc = $diffCfg[$q->difficulty] ?? null;
                            @endphp
                            <tr style="transition: background 0.15s;" onmouseover="this.style.background='#f8f9fc';" onmouseout="this.style.background='white';">
                                <td style="padding: 12px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 2px 9px; font-size: 12px; font-weight: 700;">{{ $q->order ?? $loop->iteration }}</span>
                                </td>
                                <td style="padding: 12px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; max-width: 260px;">
                                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px;">{{ Str::limit($q->question_text ?? $q->question, 55) }}</p>
                                </td>
                                <td style="padding: 12px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 3px 9px; font-size: 11px; font-weight: 600;">
                                        {{ $q->type == 'multiple_choice' ? 'Pilihan Ganda' : ucfirst(str_replace('_',' ',$q->type ?? '')) }}
                                    </span>
                                </td>
                                <td style="padding: 12px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                                    <span style="background: #fff3e8; color: #f6c23e; border-radius: 6px; padding: 3px 9px; font-size: 12px; font-weight: 700;">{{ $q->points }}</span>
                                </td>
                                <td style="padding: 12px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                                    @if($dc)
                                    <span style="background: {{ $dc[0] }}; color: {{ $dc[1] }}; border-radius: 6px; padding: 3px 9px; font-size: 11px; font-weight: 600;">{{ $dc[2] }}</span>
                                    @else
                                    <span class="text-muted" style="font-size: 12px;">—</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="mdi mdi-help-circle-outline" style="font-size: 36px; color: #d1d3e2;"></i>
                    <p class="text-muted mt-2 mb-0" style="font-size: 13px;">Belum ada pertanyaan</p>
                    <a href="{{ route('quiz.questions.create', $quiz) }}" class="btn btn-sm btn-primary mt-3" style="border-radius: 8px;">
                        <i class="mdi mdi-plus mr-1"></i> Tambah Pertanyaan Pertama
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Recent Attempts --}}
        @if($quiz->attempts->count() > 0)
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e3f9e5; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-account-group-outline" style="font-size: 18px; color: #1cc88a;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Upaya Terakhir ({{ $quiz->attempts->count() }})</h5>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th style="padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Siswa</th>
                                <th style="padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Upaya</th>
                                <th style="padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Skor</th>
                                <th style="padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Status</th>
                                <th style="padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quiz->attempts->take(10) as $attempt)
                            <tr style="transition: background 0.15s;" onmouseover="this.style.background='#f8f9fc';" onmouseout="this.style.background='white';">
                                <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                        <div style="background: linear-gradient(135deg, #4e73df, #224abe); border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <span class="text-white font-weight-bold" style="font-size: 12px;">{{ strtoupper(substr($attempt->user->name ?? 'U', 0, 1)) }}</span>
                                        </div>
                                        <span style="font-size: 13.5px; font-weight: 500; color: #2d3748;">{{ $attempt->user->name ?? 'Unknown' }}</span>
                                    </div>
                                </td>
                                <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                                    <span style="background: #f4f6fb; color: #858796; border-radius: 6px; padding: 3px 9px; font-size: 12px; font-weight: 600;">#{{ $attempt->attempt_number ?? 1 }}</span>
                                </td>
                                <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <span style="font-size: 13.5px; font-weight: 700; color: #2d3748;">{{ $attempt->score ?? 0 }} / {{ $attempt->total_points ?? $quiz->questions->sum('points') }}</span>
                                    @if($attempt->total_points > 0)
                                    <small class="text-muted ml-1">({{ round(($attempt->score / $attempt->total_points) * 100) }}%)</small>
                                    @endif
                                </td>
                                <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    @if($attempt->is_passed)
                                        <span style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">Lulus</span>
                                    @elseif($attempt->submitted)
                                        <span style="background: #fde8e8; color: #e74a3b; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">Gagal</span>
                                    @else
                                        <span style="background: #fff3e8; color: #f6c23e; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">Berlangsung</span>
                                    @endif
                                </td>
                                <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <small class="text-muted">{{ $attempt->created_at->format('d M Y') }}</small>
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

    {{-- ===== RIGHT SIDEBAR ===== --}}
    <div class="col-md-4 mb-4">

        {{-- Course Info --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; position: sticky; top: 80px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-book-outline" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Konteks Mata Pelajaran</h5>
                </div>
                <div class="p-4">
                    @foreach([
                        ['label'=>'Mata Pelajaran', 'icon'=>'mdi-library-outline',                    'val'=> $quiz->lesson->module->course->title ?? 'N/A'],
                        ['label'=>'Modul',           'icon'=>'mdi-folder-outline',                    'val'=> $quiz->lesson->module->title ?? 'N/A'],
                        ['label'=>'Materi',          'icon'=>'mdi-book-open-page-variant-outline',    'val'=> $quiz->lesson->title ?? 'N/A'],
                    ] as $info)
                    <div class="py-2" style="border-bottom: 1px solid #f0f0f3;">
                        <p class="text-muted mb-1" style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px;">
                            <i class="mdi {{ $info['icon'] }} mr-1"></i>{{ $info['label'] }}
                        </p>
                        <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px;">{{ $info['val'] }}</p>
                    </div>
                    @endforeach
                    {{-- Status info --}}
                    <div class="pt-3">
                        <div class="d-flex justify-content-between py-1">
                            <small class="text-muted">Dibuat</small>
                            <small class="font-weight-bold text-dark">{{ $quiz->created_at->format('d M Y') }}</small>
                        </div>
                        <div class="d-flex justify-content-between py-1">
                            <small class="text-muted">Diperbarui</small>
                            <small class="font-weight-bold text-dark">{{ $quiz->updated_at->format('d M Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistics (if has attempts) --}}
        @if($quiz->attempts->count() > 0)
        @php
            $completed = $quiz->attempts->where('submitted', true)->count();
            $passed    = $quiz->attempts->where('is_passed', true)->count();
            $avgScore  = $quiz->attempts->where('submitted', true)->avg('score') ?? 0;
            $passRate  = $completed > 0 ? ($passed / $completed) * 100 : 0;
        @endphp
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e0f7fa; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-chart-bar" style="font-size: 18px; color: #17a2b8;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Statistik</h5>
                </div>
                <div class="p-4">
                    @foreach([
                        ['label'=>'Total Poin',  'val'=> $quiz->questions->sum('points'), 'c'=>'#4e73df'],
                        ['label'=>'Selesai',     'val'=> $completed,                      'c'=>'#1cc88a'],
                        ['label'=>'Rata-rata',   'val'=> number_format($avgScore, 1),     'c'=>'#f6c23e'],
                        ['label'=>'Pass Rate',   'val'=> number_format($passRate, 1).'%', 'c'=>'#1cc88a'],
                    ] as $stat)
                    <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #f0f0f3;">
                        <span class="text-muted" style="font-size: 13px;">{{ $stat['label'] }}</span>
                        <span style="font-size: 15px; font-weight: 700; color: {{ $stat['c'] }};">{{ $stat['val'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Admin Actions --}}
        @if($isAdmin)
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #fff3e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-lightning-bolt" style="font-size: 18px; color: #f6c23e;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Aksi Cepat</h5>
                </div>
                <div class="p-4" style="display: flex; flex-direction: column; gap: 8px;">
                    <a href="{{ route('quiz.questions.index', $quiz) }}"
                       class="btn btn-block"
                       style="background: #e8f0fe; color: #4e73df; border-radius: 8px; font-weight: 600; font-size: 13px; border: none; padding: 10px; transition: all 0.2s;"
                       onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                       onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                        <i class="mdi mdi-help-circle-outline mr-1"></i> Kelola Pertanyaan ({{ $quiz->questions->count() }})
                    </a>
                    <a href="{{ route('quizzes.edit', $quiz) }}"
                       class="btn btn-block"
                       style="background: #e8f0fe; color: #4e73df; border-radius: 8px; font-weight: 600; font-size: 13px; border: none; padding: 10px; transition: all 0.2s;"
                       onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                       onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                        <i class="mdi mdi-pencil mr-1"></i> Edit Pengaturan
                    </a>
                    <a href="{{ route('quizzes.export', $quiz) }}"
                       class="btn btn-block"
                       style="background: #e3f9e5; color: #1cc88a; border-radius: 8px; font-weight: 600; font-size: 13px; border: none; padding: 10px; transition: all 0.2s;"
                       onmouseover="this.style.background='#1cc88a';this.style.color='#fff';"
                       onmouseout="this.style.background='#e3f9e5';this.style.color='#1cc88a';">
                        <i class="mdi mdi-microsoft-excel mr-1"></i> Export Excel
                    </a>
                    <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST" class="m-0"
                          onsubmit="confirmDelete(event, 'Kuis ini dan semua data terkait akan dihapus permanen.');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-block"
                                style="background: #fde8e8; color: #e74a3b; border-radius: 8px; font-weight: 600; font-size: 13px; border: none; padding: 10px; width: 100%; transition: all 0.2s;"
                                onmouseover="this.style.background='#e74a3b';this.style.color='#fff';"
                                onmouseout="this.style.background='#fde8e8';this.style.color='#e74a3b';">
                            <i class="mdi mdi-delete mr-1"></i> Hapus Kuis
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        {{-- Student Sidebar --}}
        @if(!$isAdmin)
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e3f9e5; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-play-circle-outline" style="font-size: 18px; color: #1cc88a;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Ambil Kuis</h5>
                </div>
                <div class="p-4">
                    @if($quiz->isAvailable())
                        @if($quiz->canUserAttempt(auth()->id()))
                        <a href="{{ route('quiz.taking.start', $quiz) }}"
                           class="btn btn-block mb-3"
                           style="background: linear-gradient(135deg, #1cc88a, #17a673); color: #fff; border-radius: 8px; font-weight: 600; font-size: 14px; padding: 12px; border: none; box-shadow: 0 4px 12px rgba(28,200,138,0.3);">
                            <i class="mdi mdi-play mr-1"></i> Mulai Kuis
                        </a>

                        {{-- User attempts --}}
                        @if(isset($userAttempts) && $userAttempts->count() > 0)
                        <p class="font-weight-bold text-dark mb-2" style="font-size: 13px;">Upaya Anda ({{ $userAttempts->count() }})</p>
                        @foreach($userAttempts->take(5) as $attempt)
                        <div class="p-3 mb-2" style="background: #f8f9fc; border-radius: 10px; border: 1px solid #eaecf4;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">Upaya #{{ $attempt->attempt_number }}</small>
                                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px;">
                                        {{ $attempt->score ?? 0 }}/{{ $attempt->total_points ?? $quiz->questions->sum('points') }}
                                        @if($attempt->total_points > 0)
                                        <small class="text-muted">({{ round(($attempt->score / $attempt->total_points) * 100) }}%)</small>
                                        @endif
                                    </p>
                                </div>
                                @if($attempt->is_passed)
                                    <span style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 3px 9px; font-size: 11px; font-weight: 700;">Lulus</span>
                                @elseif($attempt->submitted)
                                    <span style="background: #fde8e8; color: #e74a3b; border-radius: 6px; padding: 3px 9px; font-size: 11px; font-weight: 700;">Gagal</span>
                                @else
                                    <a href="{{ route('quiz.taking.show', ['quiz' => $quiz, 'attempt' => $attempt]) }}"
                                       style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 600; text-decoration: none;">Lanjutkan</a>
                                @endif
                            </div>
                            @if($attempt->completed_at)
                            <small class="text-muted">{{ $attempt->completed_at->format('d M Y') }}</small>
                            @endif
                        </div>
                        @endforeach
                        @endif

                        @else
                        {{-- Cannot attempt --}}
                        <div class="p-3 mb-3" style="background: #fff3e8; border-radius: 10px; border: 1px solid #fde68a;">
                            <p class="mb-0" style="font-size: 13px; color: #b8860b;">
                                <i class="mdi mdi-alert-circle-outline mr-1"></i>
                                @if(!$quiz->allow_multiple_attempts)
                                    Anda telah mencoba kuis ini.
                                @elseif($quiz->max_attempts)
                                    Upaya maksimal ({{ $quiz->max_attempts }}) telah tercapai.
                                @endif
                            </p>
                        </div>
                        @if(isset($bestAttempt) && $bestAttempt && $bestAttempt->total_points > 0)
                        <div class="text-center p-3" style="background: #e3f9e5; border-radius: 10px;">
                            <p class="text-muted mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Skor Terbaik</p>
                            <h3 class="font-weight-bold mb-0" style="color: #1cc88a;">{{ $bestAttempt->score }}/{{ $bestAttempt->total_points }}</h3>
                            <p class="text-muted mb-0" style="font-size: 12px;">{{ round(($bestAttempt->score / $bestAttempt->total_points) * 100) }}%</p>
                        </div>
                        @endif
                        @endif
                    @else
                    <div class="p-3" style="background: #e8f0fe; border-radius: 10px; border: 1px solid #c5d5f8;">
                        <p class="mb-0" style="font-size: 13px; color: #4e73df;">
                            <i class="mdi mdi-information-outline mr-1"></i>
                            @if($quiz->status !== 'published')
                                Kuis ini belum dipublikasikan.
                            @elseif($quiz->start_date && now() < $quiz->start_date)
                                Tersedia mulai {{ $quiz->start_date->format('d M Y') }}.
                            @elseif($quiz->end_date && now() > $quiz->end_date)
                                Kuis ini telah berakhir.
                            @endif
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

@endsection