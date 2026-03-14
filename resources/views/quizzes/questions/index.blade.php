@extends('layouts.skydash')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
            <div class="card-body py-4 px-4">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-8 mb-3 mb-xl-0">
                        <div class="d-flex align-items-center mb-2">
                            <div class="icon-wrapper mr-3" style="background: rgba(255,255,255,0.2); border-radius: 10px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                <i class="mdi mdi-help-circle-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Kelola Pertanyaan</h4>
                                <p class="text-white-50 mb-0" style="font-size: 14px;">{{ $quiz->title }}</p>
                            </div>
                        </div>
                        <nav aria-label="breadcrumb" class="mt-2">
                            <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('courses.index') }}" class="text-white-50" style="text-decoration: none; font-size: 12px;">
                                        <i class="mdi mdi-book-open-variant mr-1"></i>Mata Pelajaran
                                    </a>
                                </li>
                                <li class="breadcrumb-item text-white-50" style="font-size: 12px;">{{ $quiz->lesson->module->course->title ?? 'N/A' }}</li>
                                <li class="breadcrumb-item text-white-50" style="font-size: 12px;">{{ $quiz->lesson->module->title ?? 'N/A' }}</li>
                                <li class="breadcrumb-item text-white-50" style="font-size: 12px;">{{ $quiz->lesson->title ?? 'N/A' }}</li>
                                <li class="breadcrumb-item text-white active" style="font-size: 12px;">{{ $quiz->title }}</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="d-flex justify-content-xl-end gap-2">
                            <a href="{{ route('quiz.questions.create', $quiz) }}" class="btn btn-light font-weight-bold mr-2" style="border-radius: 8px; font-size: 13px;">
                                <i class="mdi mdi-plus-circle mr-1"></i> Tambah Pertanyaan
                            </a>
                            <a href="{{ $quiz->url }}" class="btn btn-light font-weight-bold" style="border-radius: 8px; font-size: 13px;">
                                <i class="mdi mdi-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== QUIZ INFO CARDS ===== --}}
<div class="row mb-4">
    {{-- Judul Kuis --}}
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body d-flex align-items-center p-3">
                <div class="info-icon mr-3" style="background: #e8f0fe; border-radius: 10px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="mdi mdi-clipboard-text-outline" style="font-size: 22px; color: #4e73df;"></i>
                </div>
                <div>
                    <p class="mb-0 text-muted" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Judul Kuis</p>
                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px;">{{ Str::limit($quiz->title, 20) }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Pertanyaan --}}
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body d-flex align-items-center p-3">
                <div class="info-icon mr-3" style="background: #e3f9e5; border-radius: 10px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="mdi mdi-format-list-numbered" style="font-size: 22px; color: #1cc88a;"></i>
                </div>
                <div>
                    <p class="mb-0 text-muted" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Total Pertanyaan</p>
                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 22px;">{{ $quiz->questions->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Poin --}}
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body d-flex align-items-center p-3">
                <div class="info-icon mr-3" style="background: #fff3cd; border-radius: 10px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="mdi mdi-star-circle-outline" style="font-size: 22px; color: #f6c23e;"></i>
                </div>
                <div>
                    <p class="mb-0 text-muted" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Total Poin</p>
                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 22px;">{{ $quiz->questions->sum('points') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Status --}}
    <div class="col-6 col-md-3 mb-3">
        @php
            $statusConfig = [
                'draft'     => ['color' => '#f6c23e', 'bg' => '#fff3cd', 'icon' => 'mdi-pencil-circle-outline',  'label' => 'Draf'],
                'published' => ['color' => '#1cc88a', 'bg' => '#e3f9e5', 'icon' => 'mdi-check-circle-outline',   'label' => 'Dipublikasikan'],
                'archived'  => ['color' => '#858796', 'bg' => '#f0f0f3', 'icon' => 'mdi-archive-outline',        'label' => 'Diarsipkan'],
            ];
            $sc = $statusConfig[$quiz->status] ?? $statusConfig['archived'];
        @endphp
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body d-flex align-items-center p-3">
                <div class="info-icon mr-3" style="background: {{ $sc['bg'] }}; border-radius: 10px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="mdi {{ $sc['icon'] }}" style="font-size: 22px; color: {{ $sc['color'] }};"></i>
                </div>
                <div>
                    <p class="mb-0 text-muted" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Status</p>
                    <span class="badge mt-1" style="background: {{ $sc['bg'] }}; color: {{ $sc['color'] }}; border-radius: 6px; font-size: 12px; padding: 4px 10px;">
                        {{ $sc['label'] }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== QUESTIONS TABLE ===== --}}
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-4">

                {{-- Card Header --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-help-box-outline" style="font-size: 20px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Daftar Pertanyaan</h5>
                            <small class="text-muted">{{ $quiz->questions->count() }} pertanyaan terdaftar</small>
                        </div>
                    </div>
                    @if($quiz->questions->count() > 0)
                    <a href="{{ route('quiz.questions.create', $quiz) }}" class="btn btn-primary btn-sm" style="border-radius: 8px; font-size: 13px;">
                        <i class="mdi mdi-plus mr-1"></i> Tambah
                    </a>
                    @endif
                </div>

                @if($quiz->questions->count() > 0)
                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle" style="border-collapse: separate; border-spacing: 0;">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th style="border: none; padding: 12px 16px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; font-weight: 700; border-radius: 8px 0 0 8px;">#</th>
                                <th style="border: none; padding: 12px 16px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; font-weight: 700;">Pertanyaan</th>
                                <th style="border: none; padding: 12px 16px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; font-weight: 700;">Tipe</th>
                                <th style="border: none; padding: 12px 16px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; font-weight: 700; text-align: center;">Poin</th>
                                <th style="border: none; padding: 12px 16px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; font-weight: 700; text-align: center;">Jawaban</th>
                                <th style="border: none; padding: 12px 16px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; font-weight: 700; text-align: center;">Kesulitan</th>
                                <th style="border: none; padding: 12px 16px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; font-weight: 700; text-align: center; border-radius: 0 8px 8px 0;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quiz->questions->sortBy('order') as $question)
                            @php
                                $difficultyConfig = [
                                    'easy'   => ['color' => '#1cc88a', 'bg' => '#e3f9e5', 'icon' => 'mdi-signal-cellular-1',   'label' => 'Mudah'],
                                    'medium' => ['color' => '#f6c23e', 'bg' => '#fff3cd', 'icon' => 'mdi-signal-cellular-2',   'label' => 'Menengah'],
                                    'hard'   => ['color' => '#e74a3b', 'bg' => '#fde8e8', 'icon' => 'mdi-signal-cellular-3',   'label' => 'Sulit'],
                                ];
                                $dc = $difficultyConfig[$question->difficulty] ?? null;
                            @endphp
                            <tr style="border-bottom: 1px solid #f0f0f3;">
                                {{-- Nomor --}}
                                <td style="padding: 14px 16px;">
                                    <div style="background: #4e73df; color: white; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700;">
                                        {{ $question->order ?? $loop->iteration }}
                                    </div>
                                </td>

                                {{-- Pertanyaan --}}
                                <td style="padding: 14px 16px; max-width: 320px;">
                                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px; line-height: 1.4;">
                                        {{ Str::limit($question->question_text ?? $question->question, 70) }}
                                    </p>
                                    @if($question->explanation)
                                        <p class="mb-0 mt-1" style="font-size: 12px; color: #858796;">
                                            <i class="mdi mdi-information-outline mr-1" style="color: #4e73df;"></i>{{ Str::limit($question->explanation, 50) }}
                                        </p>
                                    @endif
                                </td>

                                {{-- Tipe --}}
                                <td style="padding: 14px 16px;">
                                    <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; white-space: nowrap;">
                                        <i class="mdi mdi-radiobox-marked mr-1"></i>
                                        {{ $question->type == 'multiple_choice' ? 'Pilihan Ganda' : ucfirst(str_replace('_', ' ', $question->type ?? 'Pilihan Ganda')) }}
                                    </span>
                                </td>

                                {{-- Poin --}}
                                <td style="padding: 14px 16px; text-align: center;">
                                    <div style="display: inline-flex; align-items: center; background: #fff3cd; border-radius: 6px; padding: 4px 10px;">
                                        <i class="mdi mdi-star mr-1" style="color: #f6c23e; font-size: 14px;"></i>
                                        <span style="color: #b8860b; font-weight: 700; font-size: 14px;">{{ $question->points }}</span>
                                    </div>
                                </td>

                                {{-- Jawaban --}}
                                <td style="padding: 14px 16px; text-align: center;">
                                    <div style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                                        <span style="background: #f0f0f3; color: #5a5c69; border-radius: 6px; padding: 3px 10px; font-size: 13px; font-weight: 600;">
                                            <i class="mdi mdi-format-list-bulleted mr-1"></i>{{ $question->answers->count() }}
                                        </span>
                                        @if($question->answers->where('is_correct', true)->count() > 0)
                                            <span style="font-size: 11px; color: #1cc88a; font-weight: 600;">
                                                <i class="mdi mdi-check-circle" style="font-size: 12px;"></i>
                                                {{ $question->answers->where('is_correct', true)->count() }} benar
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Kesulitan --}}
                                <td style="padding: 14px 16px; text-align: center;">
                                    @if($dc)
                                        <span style="background: {{ $dc['bg'] }}; color: {{ $dc['color'] }}; border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; white-space: nowrap;">
                                            <i class="mdi {{ $dc['icon'] }} mr-1" style="font-size: 14px;"></i>{{ $dc['label'] }}
                                        </span>
                                    @else
                                        <span class="text-muted" style="font-size: 13px;">—</span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td style="padding: 14px 16px; text-align: center;">
                                    <div class="d-flex justify-content-center" style="gap: 6px;">
                                        <a href="{{ route('quiz.questions.edit', [$quiz, $question]) }}"
                                           class="btn btn-sm"
                                           title="Edit Pertanyaan"
                                           style="background: #e8f0fe; color: #4e73df; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border: none; transition: all 0.2s;"
                                           onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                           onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                            <i class="mdi mdi-pencil-outline" style="font-size: 16px;"></i>
                                        </a>
                                        <form action="{{ route('quiz.questions.destroy', [$quiz, $question]) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="event.preventDefault(); confirmDelete(event, 'Apakah Anda yakin ingin menghapus pertanyaan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    title="Hapus Pertanyaan"
                                                    style="background: #fde8e8; color: #e74a3b; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.2s;"
                                                    onmouseover="this.style.background='#e74a3b';this.style.color='#fff';"
                                                    onmouseout="this.style.background='#fde8e8';this.style.color='#e74a3b';">
                                                <i class="mdi mdi-delete-outline" style="font-size: 16px;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @else
                {{-- Empty State --}}
                <div class="text-center py-5">
                    <div style="background: #f0f0f3; border-radius: 50%; width: 100px; height: 100px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="mdi mdi-help-circle-outline" style="font-size: 52px; color: #c4c6d0;"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-1">Belum ada pertanyaan</h5>
                    <p class="text-muted mb-4" style="font-size: 14px;">Tambahkan pertanyaan pertama Anda untuk memulai kuis ini.</p>
                    <a href="{{ route('quiz.questions.create', $quiz) }}" class="btn btn-primary" style="border-radius: 8px; padding: 10px 24px; font-weight: 600;">
                        <i class="mdi mdi-plus-circle-outline mr-2"></i> Tambah Pertanyaan Pertama
                    </a>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .table-hover tbody tr:hover {
        background-color: #f8f9fc !important;
        transition: background-color 0.15s ease;
    }

    .table thead th {
        border-bottom: none !important;
    }

    .table td {
        border-top: none !important;
        vertical-align: middle;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255,255,255,0.4);
        content: "›";
    }

    .card {
        transition: box-shadow 0.2s ease;
    }

    .card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;
    }
</style>
@endpush

@endsection