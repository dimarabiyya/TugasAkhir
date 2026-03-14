@extends('layouts.skydash')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
            <div class="card-body py-4 px-4">
                <div class="d-flex align-items-center">
                    <div style="background: rgba(255,255,255,0.2); border-radius: 10px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; margin-right: 14px; flex-shrink: 0;">
                        <i class="mdi mdi-pencil-box-outline text-white" style="font-size: 26px;"></i>
                    </div>
                    <div>
                        <h4 class="font-weight-bold text-white mb-0">Ujian Tersedia</h4>
                        <p class="text-white-50 mb-0" style="font-size: 13px;">Pilih ujian yang ingin kamu kerjakan hari ini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== STAT SUMMARY ===== --}}
@php
    $total     = $exams->count();
    $selesai   = 0;
    $aktif     = 0;
    $menunggu  = 0;
    foreach ($exams as $exam) {
        $attempt = $exam->attempts()->where('user_id', auth()->id())->first();
        if ($attempt && $attempt->submitted_at) { $selesai++; }
        elseif (now() >= $exam->start_time && now() <= $exam->end_time) { $aktif++; }
        else { $menunggu++; }
    }
@endphp

<div class="row mb-4">
    @foreach([
        ['label' => 'Total Ujian',   'value' => $total,    'icon' => 'mdi-file-document-multiple-outline', 'bg' => '#e8f0fe', 'color' => '#4e73df'],
        ['label' => 'Bisa Dikerjakan','value' => $aktif,   'icon' => 'mdi-play-circle-outline',            'bg' => '#e3f9e5', 'color' => '#1cc88a'],
        ['label' => 'Menunggu',      'value' => $menunggu, 'icon' => 'mdi-clock-outline',                  'bg' => '#fff3cd', 'color' => '#f6c23e'],
        ['label' => 'Sudah Selesai', 'value' => $selesai,  'icon' => 'mdi-check-circle-outline',           'bg' => '#f0f0f3', 'color' => '#858796'],
    ] as $stat)
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-3 d-flex align-items-center" style="gap: 12px;">
                <div style="background: {{ $stat['bg'] }}; border-radius: 10px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="mdi {{ $stat['icon'] }}" style="font-size: 22px; color: {{ $stat['color'] }};"></i>
                </div>
                <div>
                    <p class="mb-0 text-muted" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px;">{{ $stat['label'] }}</p>
                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 22px; line-height: 1.2;">{{ $stat['value'] }}</p>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ===== EXAM CARDS ===== --}}
<div class="row">
    @forelse($exams as $exam)
    @php
        $attempt   = $exam->attempts()->where('user_id', auth()->id())->first();
        $isDone    = $attempt && $attempt->submitted_at;
        $isActive  = !$isDone && now() >= $exam->start_time && now() <= $exam->end_time;
        $isPending = !$isDone && !$isActive;
        $isPast    = now() > $exam->end_time && !$isDone;
    @endphp

    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card border-0 shadow-sm h-100"
             style="border-radius: 14px; transition: all 0.25s cubic-bezier(.4,0,.2,1); overflow: hidden; {{ $isActive ? 'border: 2px solid #1cc88a !important;' : '' }}"
             onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 10px 30px rgba(78,115,223,0.15)';"
             onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='';">

            {{-- Status top bar --}}
            <div style="height: 4px; background: {{ $isDone ? '#858796' : ($isActive ? 'linear-gradient(90deg,#1cc88a,#17a673)' : ($isPast ? '#e74a3b' : 'linear-gradient(90deg,#f6c23e,#e0a800)')) }};"></div>

            <div class="card-body p-4">

                {{-- Header --}}
                <div class="d-flex align-items-start mb-3" style="gap: 12px;">
                    <div style="background: {{ $isDone ? '#f0f0f3' : ($isActive ? '#e3f9e5' : '#e8f0fe') }}; border-radius: 10px; width: 46px; height: 46px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="mdi {{ $isDone ? 'mdi-check-circle-outline' : ($isActive ? 'mdi-play-circle-outline' : 'mdi-clock-outline') }}"
                           style="font-size: 24px; color: {{ $isDone ? '#858796' : ($isActive ? '#1cc88a' : '#f6c23e') }};"></i>
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <h6 class="font-weight-bold text-dark mb-0" style="font-size: 14px; line-height: 1.3; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $exam->title }}</h6>
                        <p class="mb-0 mt-1" style="font-size: 12px; color: #4e73df; font-weight: 600;">{{ $exam->course->title }}</p>
                    </div>

                    {{-- Status badge --}}
                    @if($isDone)
                        <span style="background: #f0f0f3; color: #858796; border-radius: 20px; padding: 3px 10px; font-size: 10px; font-weight: 700; white-space: nowrap; flex-shrink: 0;">Selesai</span>
                    @elseif($isActive)
                        <span style="background: #e3f9e5; color: #1cc88a; border-radius: 20px; padding: 3px 10px; font-size: 10px; font-weight: 700; white-space: nowrap; flex-shrink: 0; animation: pulse 2s infinite;">Aktif</span>
                    @elseif($isPast)
                        <span style="background: #fde8e8; color: #e74a3b; border-radius: 20px; padding: 3px 10px; font-size: 10px; font-weight: 700; white-space: nowrap; flex-shrink: 0;">Terlewat</span>
                    @else
                        <span style="background: #fff3cd; color: #b8860b; border-radius: 20px; padding: 3px 10px; font-size: 10px; font-weight: 700; white-space: nowrap; flex-shrink: 0;">Menunggu</span>
                    @endif
                </div>

                {{-- Info rows --}}
                <div style="background: #f8f9fc; border-radius: 10px; padding: 12px 14px; margin-bottom: 16px;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span style="font-size: 12px; color: #858796; display: flex; align-items: center; gap: 5px;">
                            <i class="mdi mdi-timer-outline" style="font-size: 14px;"></i> Durasi
                        </span>
                        <span style="font-size: 12px; font-weight: 700; color: #2d3748;">{{ $exam->duration }} menit</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span style="font-size: 12px; color: #858796; display: flex; align-items: center; gap: 5px;">
                            <i class="mdi mdi-calendar-clock-outline" style="font-size: 14px;"></i> Mulai
                        </span>
                        <span style="font-size: 12px; font-weight: 700; color: #2d3748;">{{ $exam->start_time->format('d M, H:i') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span style="font-size: 12px; color: #858796; display: flex; align-items: center; gap: 5px;">
                            <i class="mdi mdi-calendar-remove-outline" style="font-size: 14px;"></i> Batas
                        </span>
                        <span style="font-size: 12px; font-weight: 700; color: {{ $isPast ? '#e74a3b' : '#2d3748' }};">{{ $exam->end_time->format('d M, H:i') }}</span>
                    </div>

                    {{-- Soal count --}}
                    <div style="border-top: 1px solid #eaecf4; margin-top: 10px; padding-top: 10px;" class="d-flex justify-content-between align-items-center">
                        <span style="font-size: 12px; color: #858796; display: flex; align-items: center; gap: 5px;">
                            <i class="mdi mdi-help-circle-outline" style="font-size: 14px;"></i> Soal
                        </span>
                        <span style="font-size: 12px; font-weight: 700; color: #2d3748;">{{ $exam->questions->count() }} soal</span>
                    </div>
                </div>

                {{-- CTA Button --}}
                @if($isDone)
                    <button disabled
                        style="width: 100%; padding: 10px; border-radius: 8px; border: none; background: #f0f0f3; color: #858796; font-size: 13px; font-weight: 600; cursor: not-allowed; display: flex; align-items: center; justify-content: center; gap: 6px;">
                        <i class="mdi mdi-check-circle"></i> Sudah Dikerjakan
                    </button>
                @elseif($isActive)
                    <a href="{{ route('exams.start', $exam->id) }}"
                       style="width: 100%; padding: 10px; border-radius: 8px; border: none; background: linear-gradient(135deg, #1cc88a, #17a673); color: #fff; font-size: 13px; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 6px; text-decoration: none; transition: all 0.2s; box-shadow: 0 4px 12px rgba(28,200,138,0.35);"
                       onmouseover="this.style.transform='scale(1.02)';this.style.boxShadow='0 6px 18px rgba(28,200,138,0.5)';"
                       onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 4px 12px rgba(28,200,138,0.35)';">
                        <i class="mdi mdi-play-circle-outline"></i> Mulai Ujian Sekarang
                    </a>
                @elseif($isPast)
                    <button disabled
                        style="width: 100%; padding: 10px; border-radius: 8px; border: none; background: #fde8e8; color: #e74a3b; font-size: 13px; font-weight: 600; cursor: not-allowed; display: flex; align-items: center; justify-content: center; gap: 6px;">
                        <i class="mdi mdi-close-circle-outline"></i> Waktu Habis
                    </button>
                @else
                    <button disabled
                        style="width: 100%; padding: 10px; border-radius: 8px; border: none; background: #fff3cd; color: #b8860b; font-size: 13px; font-weight: 600; cursor: not-allowed; display: flex; align-items: center; justify-content: center; gap: 6px;">
                        <i class="mdi mdi-clock-outline"></i> Belum Dibuka
                    </button>
                @endif

            </div>
        </div>
    </div>

    @empty
    {{-- Empty State --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm text-center py-5" style="border-radius: 14px;">
            <div class="card-body">
                <div style="background: #f0f0f3; border-radius: 50%; width: 90px; height: 90px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <i class="mdi mdi-pencil-box-outline" style="font-size: 46px; color: #c4c6d0;"></i>
                </div>
                <h5 class="font-weight-bold text-dark mb-1">Belum Ada Ujian</h5>
                <p class="text-muted mb-0" style="font-size: 13px; max-width: 300px; margin: 0 auto;">Belum ada ujian yang dijadwalkan untuk kelas kamu. Periksa kembali nanti.</p>
            </div>
        </div>
    </div>
    @endforelse
</div>

@push('styles')
<style>
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50%       { opacity: 0.6; }
    }
</style>
@endpush

@endsection