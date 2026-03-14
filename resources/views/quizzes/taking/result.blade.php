@extends('layouts.skydash')

@section('content')

{{-- ===== RESULT HERO CARD ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm"
             style="background: linear-gradient(135deg, {{ $attempt->is_passed ? '#1cc88a 0%, #17a673' : '#e74a3b 0%, #c0392b' }} 100%); border-radius: 12px;">
            <div class="card-body py-5 text-center">

                {{-- Icon --}}
                <div style="background: rgba(255,255,255,0.2); border-radius: 50%; width: 90px; height: 90px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <i class="mdi {{ $attempt->is_passed ? 'mdi-check-circle-outline' : 'mdi-close-circle-outline' }} text-white" style="font-size: 50px;"></i>
                </div>

                {{-- Title --}}
                <h2 class="font-weight-bold text-white mb-2">
                    {{ $attempt->is_passed ? '🎉 Selamat, Kamu Lulus!' : 'Kuis Selesai' }}
                </h2>
                <p class="text-white mb-4" style="opacity: 0.8; font-size: 14px;">{{ $quiz->title }}</p>

                {{-- Score --}}
                <div style="background: rgba(255,255,255,0.15); border-radius: 12px; padding: 20px 40px; display: inline-block; margin-bottom: 28px;">
                    <h1 class="text-white font-weight-bold mb-0" style="font-size: 52px; line-height: 1; text-shadow: 0 2px 4px rgba(0,0,0,0.15);">
                        {{ $attempt->score }} <span style="font-size: 28px; opacity: 0.7;">/ {{ $attempt->total_points }}</span>
                    </h1>
                    <p class="text-white mb-0 mt-1" style="font-size: 22px; font-weight: 700; opacity: 0.9;">
                        {{ number_format($attempt->score_percentage, 1) }}%
                    </p>
                </div>

                {{-- Meta row --}}
                <div class="row justify-content-center">
                    <div class="col-4 col-md-2">
                        <p class="text-white mb-1" style="font-size: 12px; opacity: 0.75; text-transform: uppercase; letter-spacing: 0.5px;">Skor Lulus</p>
                        <h5 class="text-white font-weight-bold mb-0">{{ $quiz->passing_score }}%</h5>
                    </div>
                    <div class="col-4 col-md-2">
                        <p class="text-white mb-1" style="font-size: 12px; opacity: 0.75; text-transform: uppercase; letter-spacing: 0.5px;">Skor Anda</p>
                        <h5 class="text-white font-weight-bold mb-0">{{ number_format($attempt->score_percentage, 1) }}%</h5>
                    </div>
                    <div class="col-4 col-md-2">
                        <p class="text-white mb-1" style="font-size: 12px; opacity: 0.75; text-transform: uppercase; letter-spacing: 0.5px;">Status</p>
                        <span style="background: rgba(255,255,255,0.25); color: #fff; border-radius: 20px; padding: 4px 16px; font-size: 13px; font-weight: 700;">
                            {{ $attempt->is_passed ? 'LULUS' : 'GAGAL' }}
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- ===== DETAIL STATS ===== --}}
<div class="row mb-4">
    @foreach([
        ['label' => 'Jawaban Benar',       'value' => $attempt->correct_answers ?? 0,   'icon' => 'mdi-check-circle-outline',  'bg' => '#e3f9e5', 'ic' => '#1cc88a'],
        ['label' => 'Jawaban Salah',        'value' => $attempt->incorrect_answers ?? 0, 'icon' => 'mdi-close-circle-outline',  'bg' => '#fde8e8', 'ic' => '#e74a3b'],
        ['label' => 'Belum Dijawab',        'value' => $attempt->unanswered_questions ?? 0, 'icon' => 'mdi-help-circle-outline','bg' => '#fff3e8', 'ic' => '#f6c23e'],
        ['label' => 'Durasi Pengerjaan',    'value' => $attempt->formatted_duration ?? '--', 'icon' => 'mdi-clock-outline',      'bg' => '#e0f7fa', 'ic' => '#17a2b8'],
    ] as $s)
    <div class="col-6 col-md-3 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-3 text-center">
                <div style="background: {{ $s['bg'] }}; border-radius: 10px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
                    <i class="mdi {{ $s['icon'] }}" style="font-size: 22px; color: {{ $s['ic'] }};"></i>
                </div>
                <h3 class="font-weight-bold text-dark mb-0" style="font-size: 24px;">{{ $s['value'] }}</h3>
                <p class="text-muted mb-0" style="font-size: 12px; margin-top: 2px;">{{ $s['label'] }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ===== QUESTION REVIEW ===== --}}
@if($quiz->show_correct_answers && isset($attempt->answers_review))
@php
    $review    = is_array($attempt->answers_review) ? $attempt->answers_review : json_decode($attempt->answers_review, true) ?? [];
    $questions = $quiz->questions;
@endphp
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">

                {{-- Header --}}
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-clipboard-list-outline" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Tinjauan Pertanyaan</h5>
                        <small class="text-muted">{{ $questions->count() }} pertanyaan</small>
                    </div>
                </div>

                <div class="p-4">
                    @foreach($questions as $index => $question)
                    @php
                        $qReview   = $review[$question->id] ?? null;
                        $isCorrect = $qReview['is_correct'] ?? false;
                    @endphp

                    <div class="mb-4 p-4"
                         style="border-radius: 12px; border: 2px solid {{ $isCorrect ? '#1cc88a' : '#e74a3b' }}; background: {{ $isCorrect ? '#f6fffb' : '#fffaf9' }}; transition: all 0.2s;"
                         onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.08)';"
                         onmouseout="this.style.transform=''; this.style.boxShadow='';">

                        {{-- Question Header --}}
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div class="d-flex align-items-center" style="gap: 8px; flex-wrap: wrap;">
                                <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">
                                    Soal {{ $index + 1 }}
                                </span>
                                <span style="background: {{ $isCorrect ? '#e3f9e5' : '#fde8e8' }}; color: {{ $isCorrect ? '#1cc88a' : '#e74a3b' }}; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">
                                    <i class="mdi {{ $isCorrect ? 'mdi-check-circle' : 'mdi-close-circle' }} mr-1"></i>
                                    {{ $isCorrect ? 'Benar' : 'Salah' }}
                                </span>
                                <span style="background: #e0f7fa; color: #17a2b8; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">
                                    {{ $question->points }} Poin
                                </span>
                            </div>
                            <div style="background: {{ $isCorrect ? '#e3f9e5' : '#fde8e8' }}; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="mdi {{ $isCorrect ? 'mdi-check' : 'mdi-close' }}" style="font-size: 18px; color: {{ $isCorrect ? '#1cc88a' : '#e74a3b' }};"></i>
                            </div>
                        </div>

                        {{-- Question Text --}}
                        <h6 class="font-weight-bold text-dark mb-3" style="font-size: 14px; line-height: 1.5;">
                            {{ $question->question_text ?? $question->question }}
                        </h6>

                        {{-- Answers --}}
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            @foreach($question->answers as $answer)
                            @php
                                $userSelected    = $qReview && in_array($answer->id, ($qReview['user_answer'] ?? []));
                                $isCorrectAnswer = $answer->is_correct;
                            @endphp
                            <div class="d-flex align-items-center p-3"
                                 style="border-radius: 8px; border: 1.5px solid {{ $isCorrectAnswer ? '#1cc88a' : ($userSelected ? '#e74a3b' : '#eaecf4') }};
                                        background: {{ $isCorrectAnswer ? '#e3f9e5' : ($userSelected ? '#fde8e8' : '#f8f9fc') }};">
                                <div style="flex-shrink: 0; margin-right: 10px;">
                                    @if($isCorrectAnswer)
                                        <div style="background: #1cc88a; border-radius: 50%; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center;">
                                            <i class="mdi mdi-check text-white" style="font-size: 13px;"></i>
                                        </div>
                                    @elseif($userSelected)
                                        <div style="background: #e74a3b; border-radius: 50%; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center;">
                                            <i class="mdi mdi-close text-white" style="font-size: 13px;"></i>
                                        </div>
                                    @else
                                        <div style="border: 2px solid #d1d3e2; border-radius: 50%; width: 22px; height: 22px;"></div>
                                    @endif
                                </div>
                                <span style="font-size: 13.5px; flex: 1;
                                             color: {{ $isCorrectAnswer ? '#1cc88a' : ($userSelected ? '#e74a3b' : '#5a5c69') }};
                                             font-weight: {{ ($isCorrectAnswer || $userSelected) ? '600' : '400' }};">
                                    {{ $answer->answer_text }}
                                </span>
                                @if($isCorrectAnswer)
                                    <span style="background: #1cc88a; color: #fff; border-radius: 6px; padding: 2px 8px; font-size: 10px; font-weight: 700; margin-left: 8px; flex-shrink: 0;">Benar</span>
                                @elseif($userSelected)
                                    <span style="background: #e74a3b; color: #fff; border-radius: 6px; padding: 2px 8px; font-size: 10px; font-weight: 700; margin-left: 8px; flex-shrink: 0;">Jawaban Anda</span>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        {{-- Explanation --}}
                        @if($question->explanation)
                        <div class="mt-3 p-3" style="background: #e8f0fe; border-radius: 8px; border-left: 3px solid #4e73df;">
                            <p class="mb-0" style="font-size: 13px; color: #3d3d3d;">
                                <i class="mdi mdi-information-outline mr-1" style="color: #4e73df;"></i>
                                <strong>Penjelasan:</strong> {{ $question->explanation }}
                            </p>
                        </div>
                        @endif

                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
@endif

{{-- ===== ACTION BUTTONS ===== --}}
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body px-4 py-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 10px;">
                    <p class="text-muted mb-0" style="font-size: 12px;">
                        <i class="mdi mdi-information-outline mr-1 text-primary"></i>
                        Hasil kuis telah disimpan otomatis
                    </p>
                    <div class="d-flex" style="gap: 8px; flex-wrap: wrap;">
                        <a href="{{ $quiz->url }}"
                           class="btn"
                           style="background: #f4f6fb; color: #6b7280; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 20px; border: 1px solid #e3e6f0; transition: all 0.2s;"
                           onmouseover="this.style.background='#e3e6f0';" onmouseout="this.style.background='#f4f6fb';">
                            <i class="mdi mdi-arrow-left mr-1"></i> Kembali ke Kuis
                        </a>
                        @if($quiz->canUserAttempt(auth()->id()))
                        <a href="{{ route('quiz.taking.start', $quiz) }}"
                           style="background: linear-gradient(135deg, #1cc88a, #17a673); color: #fff; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 20px; border: none; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 4px 12px rgba(28,200,138,0.3); transition: all 0.2s;"
                           onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                            <i class="mdi mdi-refresh mr-1"></i> Coba Lagi
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection