@extends('layouts.skydash')

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
                                <i class="mdi mdi-file-question-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))
                                    <h4 class="font-weight-bold text-white mb-0">Daftar Kuis</h4>
                                    <p class="text-white-50 mb-0" style="font-size: 13px;">Kelola semua kuis untuk pelajaran Anda</p>
                                @else
                                    <h4 class="font-weight-bold text-white mb-0">Kuis yang Tersedia</h4>
                                    <p class="text-white-50 mb-0" style="font-size: 13px;">Uji pengetahuan Anda dengan kuis-kuis ini</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== STAT CARDS ===== --}}
@if($quizzes->count() > 0)
@php
    $totalQuizzes    = $quizzes->total();
    $publishedQuizzes = $quizzes->filter(fn($q) => $q->status == 'published')->count();
    $totalQuestions  = $quizzes->sum(fn($q) => $q->questions->count());
    $totalAttempts   = $quizzes->sum(fn($q) => $q->attempts->count());
@endphp
<div class="row mb-4">
    @foreach([
        ['label' => 'Total Kuis',        'value' => $totalQuizzes,     'icon' => 'mdi-file-question-outline',          'bg' => '#e8f0fe', 'ic' => '#4e73df'],
        ['label' => 'Dipublikasikan',    'value' => $publishedQuizzes, 'icon' => 'mdi-checkbox-marked-circle-outline', 'bg' => '#e3f9e5', 'ic' => '#1cc88a'],
        ['label' => 'Total Pertanyaan',  'value' => $totalQuestions,   'icon' => 'mdi-help-circle-outline',            'bg' => '#fde8e8', 'ic' => '#e74a3b'],
        ['label' => 'Total Dikerjakan',  'value' => $totalAttempts,    'icon' => 'mdi-check-circle-outline',           'bg' => '#e0f7fa', 'ic' => '#17a2b8'],
    ] as $s)
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
@endif

{{-- ===== TABLE CARD ===== --}}
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">

                {{-- Card Header --}}
                <div class="d-flex align-items-center justify-content-between px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div class="d-flex align-items-center">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-format-list-bulleted" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Semua Kuis</h5>
                            <small class="text-muted">{{ $quizzes->total() }} kuis terdaftar</small>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0" style="border-collapse: separate; border-spacing: 0;">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th style="padding: 12px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Judul Kuis</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Mata Pelajaran</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Status</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Skor / Waktu</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Soal</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Upaya</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($quizzes as $quiz)
                            <tr style="transition: background 0.15s ease;"
                                onmouseover="this.style.background='#f8f9fc';"
                                onmouseout="this.style.background='white';">

                                {{-- Judul --}}
                                <td style="padding: 14px 20px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; max-width: 240px;">
                                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 13.5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $quiz->title }}</p>
                                    @if($quiz->description)
                                    <small class="text-muted">{{ Str::limit($quiz->description, 50) }}</small>
                                    @endif
                                </td>

                                {{-- Mata Pelajaran & Materi --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; max-width: 200px;">
                                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 12.5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ Str::limit($quiz->lesson->module->course->title ?? 'N/A', 28) }}
                                    </p>
                                    <small class="text-muted" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; max-width: 200px;">
                                        <i class="mdi mdi-book-open-outline mr-1"></i>{{ Str::limit($quiz->lesson->title ?? 'N/A', 28) }}
                                    </small>
                                </td>

                                {{-- Status --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    @php
                                        $statusCfg = [
                                            'published' => ['bg'=>'#e3f9e5','c'=>'#1cc88a','label'=>'Dipublikasikan','icon'=>'mdi-check-circle'],
                                            'draft'     => ['bg'=>'#fff3e8','c'=>'#f6c23e','label'=>'Draf',           'icon'=>'mdi-pencil'],
                                            'archived'  => ['bg'=>'#f4f6fb','c'=>'#858796','label'=>'Diarsipkan',     'icon'=>'mdi-archive'],
                                        ];
                                        $sc = $statusCfg[$quiz->status] ?? $statusCfg['draft'];
                                    @endphp
                                    <span style="background: {{ $sc['bg'] }}; color: {{ $sc['c'] }}; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700; white-space: nowrap;">
                                        <i class="mdi {{ $sc['icon'] }} mr-1"></i>{{ $sc['label'] }}
                                    </span>
                                    @if($quiz->isAvailable())
                                    <br><small style="color: #1cc88a; font-size: 11px;"><i class="mdi mdi-check mr-1"></i>Tersedia</small>
                                    @endif
                                </td>

                                {{-- Skor / Waktu --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                                    <div class="d-flex flex-column align-items-center" style="gap: 4px;">
                                        <span style="background: #e0f7fa; color: #17a2b8; border-radius: 6px; padding: 3px 9px; font-size: 11px; font-weight: 700;">
                                            <i class="mdi mdi-check mr-1"></i>{{ $quiz->passing_score }}%
                                        </span>
                                        <span style="font-size: 11px; color: #858796;">
                                            <i class="mdi mdi-clock-outline mr-1"></i>{{ $quiz->time_limit_minutes ? $quiz->time_limit_minutes.'m' : '∞' }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Soal --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                                    <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 700;">
                                        {{ $quiz->questions->count() }}
                                    </span>
                                </td>

                                {{-- Upaya --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                                    <span style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 700;">
                                        {{ $quiz->attempts->count() }}
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                                    <div class="d-flex align-items-center justify-content-center" style="gap: 5px;">

                                        {{-- View --}}
                                        <a href="{{ $quiz->url }}" title="Lihat Detail"
                                           style="background: #e8f0fe; color: #4e73df; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;"
                                           onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                           onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                            <i class="mdi mdi-eye" style="font-size: 15px;"></i>
                                        </a>

                                        @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))

                                        {{-- Edit --}}
                                        <a href="{{ route('quizzes.edit', $quiz) }}" title="Edit"
                                           style="background: #e8f0fe; color: #4e73df; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;"
                                           onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                           onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                            <i class="mdi mdi-pencil" style="font-size: 15px;"></i>
                                        </a>

                                        {{-- Manage Questions --}}
                                        <a href="{{ route('quiz.questions.index', $quiz) }}" title="Kelola Pertanyaan"
                                           style="background: #fff3e8; color: #f6c23e; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;"
                                           onmouseover="this.style.background='#f6c23e';this.style.color='#fff';"
                                           onmouseout="this.style.background='#fff3e8';this.style.color='#f6c23e';">
                                            <i class="mdi mdi-help-circle-outline" style="font-size: 15px;"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST" class="d-inline m-0"
                                              onsubmit="confirmDelete(event, 'Kuis ini akan dihapus permanen beserta semua pertanyaan dan upaya.');">
                                            @csrf @method('DELETE')
                                            <button type="submit" title="Hapus"
                                                    style="background: #fde8e8; color: #e74a3b; border: none; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;"
                                                    onmouseover="this.style.background='#e74a3b';this.style.color='#fff';"
                                                    onmouseout="this.style.background='#fde8e8';this.style.color='#e74a3b';">
                                                <i class="mdi mdi-delete" style="font-size: 15px;"></i>
                                            </button>
                                        </form>

                                        @elseif(auth()->check() && !auth()->user()->hasAnyRole(['admin', 'instructor']))
                                            @if($quiz->isAvailable() && $quiz->canUserAttempt(auth()->id()))
                                            {{-- Start Quiz --}}
                                            <a href="{{ route('quiz.taking.start', $quiz) }}" title="Mulai Kuis"
                                               style="background: linear-gradient(135deg, #1cc88a, #17a673); color: #fff; border-radius: 8px; width: auto; height: 32px; padding: 6px 14px; font-size: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s;"
                                               onmouseover="this.style.opacity='0.88';" onmouseout="this.style.opacity='1';">
                                                <i class="mdi mdi-play" style="font-size: 15px;"></i> Mulai
                                            </a>
                                            @endif
                                        @endif

                                    </div>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="padding: 48px 20px; text-align: center;">
                                    <div style="background: #f0f0f3; border-radius: 50%; width: 72px; height: 72px; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px;">
                                        <i class="mdi mdi-file-question-outline" style="font-size: 36px; color: #c4c6d0;"></i>
                                    </div>
                                    <h5 class="font-weight-bold text-dark mb-1">Kuis Tidak Ditemukan</h5>
                                    <p class="text-muted mb-3" style="font-size: 13px;">
                                        @if(request('search') || request('status') || request('lesson_id'))
                                            Coba sesuaikan kata kunci pencarian Anda.
                                        @else
                                            Belum ada kuis yang dibuat.
                                        @endif
                                    </p>
                                    @if(auth()->user()->hasAnyRole(['admin', 'instructor']) && !request()->hasAny(['search','status','lesson_id']))
                                    <a href="{{ route('lessons.index') }}" class="btn btn-primary" style="border-radius: 8px; font-weight: 600; padding: 10px 24px;">
                                        <i class="mdi mdi-plus mr-1"></i> Tambah Kuis
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($quizzes->hasPages())
                <div class="px-4 py-3" style="border-top: 1px solid #f0f0f3; background: #fafbff; border-radius: 0 0 12px 12px;">
                    <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 8px;">
                        <p class="text-muted mb-0" style="font-size: 12px;">
                            Menampilkan {{ $quizzes->firstItem() }}–{{ $quizzes->lastItem() }} dari {{ $quizzes->total() }} kuis
                        </p>
                        {{ $quizzes->withQueryString()->links() }}
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection