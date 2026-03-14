@extends('layouts.skydash')

@section('content')

@php
    $score     = $attempt->score ?? 0;
    $pass      = $score >= 75;
    $answered  = count($attempt->answers ?? []);
    $total     = $exam->questions->count();
    $accuracy  = $total > 0 ? round(($answered / $total) * 100) : 0;
@endphp

<div class="row justify-content-center py-4">
    <div class="col-12 col-md-8 col-lg-6">

        {{-- ===== RESULT CARD ===== --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; overflow: hidden;">

            {{-- Top gradient banner --}}
            <div style="background: {{ $pass ? 'linear-gradient(135deg, #1cc88a 0%, #17a673 100%)' : 'linear-gradient(135deg, #4e73df 0%, #224abe 100%)' }}; padding: 36px 24px; text-align: center;">
                {{-- Icon circle --}}
                <div style="background: rgba(255,255,255,0.2); border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; border: 3px solid rgba(255,255,255,0.35);">
                    <i class="mdi {{ $pass ? 'mdi-trophy-outline' : 'mdi-book-open-outline' }}" style="font-size: 38px; color: #fff;"></i>
                </div>
                <h3 class="font-weight-bold text-white mb-1">Ujian Selesai!</h3>
                <p class="text-white-50 mb-0" style="font-size: 13px;">{{ $exam->title }}</p>
            </div>

            {{-- Score display --}}
            <div style="text-align: center; padding: 28px 24px 20px; border-bottom: 1px solid #f0f0f3;">
                <p class="text-muted mb-2" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.8px;">Nilai Kamu</p>
                <div style="font-size: 64px; font-weight: 800; line-height: 1; color: {{ $pass ? '#1cc88a' : ($score >= 50 ? '#f6c23e' : '#e74a3b') }}; letter-spacing: -2px;">
                    {{ number_format($score, 1) }}
                </div>
                <div class="mt-2">
                    @if($pass)
                        <span style="background: #e3f9e5; color: #1cc88a; border-radius: 20px; padding: 5px 16px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;">
                            <i class="mdi mdi-check-circle" style="font-size: 14px;"></i> LULUS
                        </span>
                    @else
                        <span style="background: #fde8e8; color: #e74a3b; border-radius: 20px; padding: 5px 16px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;">
                            <i class="mdi mdi-close-circle" style="font-size: 14px;"></i> TIDAK LULUS
                        </span>
                    @endif
                </div>
            </div>

            {{-- Stats row --}}
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); border-bottom: 1px solid #f0f0f3;">
                @foreach([
                    ['label' => 'Total Soal',  'value' => $total,    'icon' => 'mdi-help-circle-outline',  'color' => '#4e73df', 'bg' => '#e8f0fe'],
                    ['label' => 'Terjawab',    'value' => $answered, 'icon' => 'mdi-check-circle-outline', 'color' => '#1cc88a', 'bg' => '#e3f9e5'],
                    ['label' => 'Waktu',       'value' => $attempt->submitted_at->format('H:i'), 'icon' => 'mdi-clock-check-outline', 'color' => '#f6c23e', 'bg' => '#fff3cd'],
                ] as $i => $stat)
                <div style="padding: 18px 12px; text-align: center; {{ $i < 2 ? 'border-right: 1px solid #f0f0f3;' : '' }}">
                    <div style="background: {{ $stat['bg'] }}; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;">
                        <i class="mdi {{ $stat['icon'] }}" style="font-size: 18px; color: {{ $stat['color'] }};"></i>
                    </div>
                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 16px; line-height: 1;">{{ $stat['value'] }}</p>
                    <p class="mb-0 text-muted" style="font-size: 10px; margin-top: 2px;">{{ $stat['label'] }}</p>
                </div>
                @endforeach
            </div>

            {{-- Score breakdown bar --}}
            <div style="padding: 20px 24px; border-bottom: 1px solid #f0f0f3;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span style="font-size: 12px; color: #858796; font-weight: 600;">Skor</span>
                    <span style="font-size: 12px; font-weight: 700; color: {{ $pass ? '#1cc88a' : '#e74a3b' }};">{{ number_format($score, 1) }} / 100</span>
                </div>
                <div style="background: #f0f0f3; border-radius: 8px; height: 10px; overflow: hidden;">
                    <div style="height: 100%; width: {{ $score }}%; border-radius: 8px; background: {{ $pass ? 'linear-gradient(90deg,#1cc88a,#17a673)' : ($score >= 50 ? 'linear-gradient(90deg,#f6c23e,#e0a800)' : 'linear-gradient(90deg,#e74a3b,#c0392b)') }}; transition: width 1s ease;"></div>
                </div>
                <div class="d-flex justify-content-between mt-1">
                    <span style="font-size: 10px; color: #adb5bd;">0</span>
                    <span style="font-size: 10px; color: #adb5bd; position: relative; left: {{ min($score, 98) - 50 }}%;">
                        <i class="mdi mdi-map-marker" style="color: #4e73df; font-size: 12px;"></i>
                    </span>
                    <span style="font-size: 10px; color: #adb5bd;">100</span>
                </div>
                {{-- KKM line indicator --}}
                <div style="position: relative; margin-top: 4px;">
                    <div style="position: absolute; left: 75%; transform: translateX(-50%); display: flex; flex-direction: column; align-items: center;">
                        <div style="width: 1px; height: 8px; background: #858796;"></div>
                        <span style="font-size: 9px; color: #858796; white-space: nowrap;">KKM 75</span>
                    </div>
                </div>
            </div>

            {{-- Motivational message --}}
            <div style="padding: 20px 24px; background: {{ $pass ? '#f0fdf8' : '#f8f9fc' }}; border-bottom: 1px solid #f0f0f3;">
                <div class="d-flex align-items-start" style="gap: 12px;">
                    <div style="background: {{ $pass ? '#e3f9e5' : '#e8f0fe' }}; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px;">
                        <i class="mdi {{ $pass ? 'mdi-star-outline' : 'mdi-lightbulb-outline' }}" style="font-size: 19px; color: {{ $pass ? '#1cc88a' : '#4e73df' }};"></i>
                    </div>
                    <div>
                        <p class="mb-0 font-weight-bold" style="font-size: 13px; color: {{ $pass ? '#1cc88a' : '#4e73df' }};">
                            {{ $pass ? 'Luar Biasa!' : 'Jangan Menyerah!' }}
                        </p>
                        <p class="mb-0 text-muted" style="font-size: 12px; line-height: 1.5; margin-top: 2px;">
                            @if($pass)
                                Kamu berhasil melewati KKM dengan nilai <strong>{{ number_format($score, 1) }}</strong>. Pertahankan prestasimu!
                            @else
                                Nilai kamu <strong>{{ number_format($score, 1) }}</strong>, sedikit lagi mencapai KKM. Terus belajar dan semangat!
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Action --}}
            <div style="padding: 20px 24px;">
                <a href="{{ route('exams.index') }}"
                   style="width: 100%; padding: 12px; border-radius: 10px; border: none; background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; font-size: 14px; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; transition: opacity 0.2s; box-shadow: 0 4px 14px rgba(78,115,223,.3);"
                   onmouseover="this.style.opacity='0.9';"
                   onmouseout="this.style.opacity='1';">
                    <i class="mdi mdi-home-outline" style="font-size: 18px;"></i> Kembali ke Daftar Ujian
                </a>
            </div>

        </div>

        {{-- Submission confirmed note --}}
        <div style="background: #e3f9e5; border-radius: 10px; padding: 12px 16px; display: flex; align-items: center; gap: 10px;">
            <i class="mdi mdi-shield-check-outline" style="font-size: 20px; color: #1cc88a; flex-shrink: 0;"></i>
            <p class="mb-0" style="font-size: 12px; color: #1cc88a; font-weight: 600;">
                Jawaban kamu telah berhasil dikirim pada {{ $attempt->submitted_at->format('d M Y, H:i:s') }} WIB
            </p>
        </div>

    </div>
</div>

@push('styles')
<style>
    /* Animate score bar on load */
    @keyframes growBar {
        from { width: 0%; }
        to   { width: {{ $score }}%; }
    }
</style>
@endpush

@endsection