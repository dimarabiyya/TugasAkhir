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
                                <i class="mdi mdi-chart-bar text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">{{ $exam->title }}</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">
                                    {{ $exam->course->title }}
                                    <span style="margin: 0 6px; opacity: 0.4;">|</span>
                                    {{ $exam->questions->count() }} butir soal
                                    <span style="margin: 0 6px; opacity: 0.4;">|</span>
                                    {{ $exam->duration }} menit
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('exams.index') }}" class="btn btn-light font-weight-bold" style="border-radius: 8px; font-size: 13px;">
                            <i class="mdi mdi-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== PER CLASSROOM ===== --}}
@foreach($classrooms as $classroom)

@php
    $students     = $classroom->students;
    $totalSiswa   = $students->count();
    $selesai      = $students->filter(fn($s) => $s->examAttempts->first() && $s->examAttempts->first()->submitted_at)->count();
    $mengerjakan  = $students->filter(fn($s) => $s->examAttempts->first() && !$s->examAttempts->first()->submitted_at)->count();
    $belumMasuk   = $totalSiswa - $selesai - $mengerjakan;
    $avgScore     = $selesai > 0
        ? $students->filter(fn($s) => $s->examAttempts->first() && $s->examAttempts->first()->submitted_at)
                   ->avg(fn($s) => $s->examAttempts->first()->score)
        : null;
@endphp

<div class="mb-4">

    {{-- Classroom title + export --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center">
            <div style="background: #e8f0fe; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                <i class="mdi mdi-google-classroom" style="font-size: 20px; color: #4e73df;"></i>
            </div>
            <div>
                <h5 class="mb-0 font-weight-bold text-dark">{{ $classroom->name }}</h5>
                <small class="text-muted">{{ $totalSiswa }} siswa terdaftar</small>
            </div>
        </div>
        <a href="{{ route('exams.export', [$exam->id, $classroom->id]) }}"
           style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; background: #e3f9e5; color: #1cc88a; font-size: 13px; font-weight: 600; text-decoration: none; border: 1px solid #b8efd8; transition: all 0.2s;"
           onmouseover="this.style.background='#1cc88a';this.style.color='#fff';"
           onmouseout="this.style.background='#e3f9e5';this.style.color='#1cc88a';">
            <i class="mdi mdi-microsoft-excel" style="font-size: 16px;"></i> Export Excel
        </a>
    </div>

    {{-- Mini stat cards per classroom --}}
    <div class="row mb-3">
        @foreach([
            ['label' => 'Selesai',           'value' => $selesai,     'icon' => 'mdi-check-circle-outline',  'bg' => '#e3f9e5', 'color' => '#1cc88a'],
            ['label' => 'Sedang Mengerjakan','value' => $mengerjakan,  'icon' => 'mdi-pencil-outline',        'bg' => '#e8f0fe', 'color' => '#4e73df'],
            ['label' => 'Belum Masuk',       'value' => $belumMasuk,   'icon' => 'mdi-account-off-outline',   'bg' => '#f0f0f3', 'color' => '#858796'],
            ['label' => 'Rata-rata Nilai',   'value' => $avgScore !== null ? number_format($avgScore, 1) : 'N/A', 'icon' => 'mdi-star-outline', 'bg' => '#fff3cd', 'color' => '#f6c23e'],
        ] as $stat)
        <div class="col-6 col-md-3 mb-2">
            <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                <div class="card-body p-3 d-flex align-items-center" style="gap: 10px;">
                    <div style="background: {{ $stat['bg'] }}; border-radius: 8px; width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="mdi {{ $stat['icon'] }}" style="font-size: 19px; color: {{ $stat['color'] }};"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-muted" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px;">{{ $stat['label'] }}</p>
                        <p class="mb-0 font-weight-bold text-dark" style="font-size: 18px; line-height: 1.2;">{{ $stat['value'] }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0" style="border-collapse: separate; border-spacing: 0;">
                    <thead>
                        <tr style="background: #f8f9fc;">
                            <th style="padding: 12px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Siswa</th>
                            <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Status</th>
                            <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Kecurangan</th>
                            <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Waktu Selesai</th>
                            <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        @php $attempt = $student->examAttempts->first(); @endphp
                        <tr style="transition: background 0.15s;"
                            onmouseover="this.style.background='#f8f9fc';"
                            onmouseout="this.style.background='white';">

                            {{-- Siswa --}}
                            <td style="padding: 13px 20px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                <div class="d-flex align-items-center" style="gap: 10px;">
                                    <div style="background: linear-gradient(135deg, #4e73df, #224abe); border-radius: 50%; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <i class="mdi mdi-account" style="font-size: 17px; color: #fff;"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px;">{{ $student->name }}</p>
                                        <p class="mb-0 text-muted" style="font-size: 11px;">{{ $student->email }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Status --}}
                            <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                @if($attempt && $attempt->submitted_at)
                                    <span style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="mdi mdi-check-circle" style="font-size: 13px;"></i> Selesai
                                    </span>
                                @elseif($attempt)
                                    <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="mdi mdi-pencil" style="font-size: 13px;"></i> Sedang Mengerjakan
                                    </span>
                                @else
                                    <span style="background: #f0f0f3; color: #858796; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="mdi mdi-account-off-outline" style="font-size: 13px;"></i> Belum Masuk
                                    </span>
                                @endif
                            </td>

                            <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                @if($attempt)
                                    <span class="badge {{ ($attempt->cheat_attempts >= 2) ? 'bg-danger' : 'bg-warning' }}">
                                        {{ $attempt->cheat_attempts ?? 0 }} kali
                                    </span>
                                @else
                                    <span class="text-muted small">Belum ada data</span>
                                @endif
                            </td>

                            {{-- Waktu --}}
                            <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                @if($attempt && $attempt->submitted_at)
                                    <span style="font-size: 12px; color: #3d3d3d; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="mdi mdi-clock-check-outline" style="font-size: 14px; color: #1cc88a;"></i>
                                        {{ $attempt->submitted_at->format('d M Y, H:i') }}
                                    </span>
                                @else
                                    <span style="color: #c4c6d0; font-size: 13px;">—</span>
                                @endif
                            </td>

                            {{-- Nilai --}}
                            <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                                @if($attempt && $attempt->submitted_at)
                                    @php $score = $attempt->score; $pass = $score >= 75; @endphp
                                    <div style="display: inline-flex; flex-direction: column; align-items: center; gap: 2px;">
                                        <span style="font-size: 18px; font-weight: 700; color: {{ $pass ? '#1cc88a' : '#e74a3b' }}; line-height: 1;">
                                            {{ number_format($score, 1) }}
                                        </span>
                                        <span style="font-size: 10px; font-weight: 600; color: {{ $pass ? '#1cc88a' : '#e74a3b' }};">
                                            {{ $pass ? 'LULUS' : 'TIDAK LULUS' }}
                                        </span>
                                    </div>
                                @else
                                    <span style="color: #c4c6d0; font-size: 13px;">N/A</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endforeach

@endsection