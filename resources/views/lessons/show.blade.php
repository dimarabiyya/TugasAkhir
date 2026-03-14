@extends('layouts.skydash')

@section('content')

@php
    $typeCfg = [
        'video'       => ['bg'=>'#e0f7fa','c'=>'#17a2b8','icon'=>'mdi-play-circle-outline','label'=>'Video'],
        'reading'     => ['bg'=>'#e3f9e5','c'=>'#1cc88a','icon'=>'mdi-text','label'=>'Reading'],
        'audio'       => ['bg'=>'#fff3e8','c'=>'#f6c23e','icon'=>'mdi-music-note','label'=>'Audio'],
        'interactive' => ['bg'=>'#e8f0fe','c'=>'#4e73df','icon'=>'mdi-gesture-tap','label'=>'Interaktif'],
        'quiz'        => ['bg'=>'#fde8e8','c'=>'#e74a3b','icon'=>'mdi-help-circle-outline','label'=>'Kuis'],
    ];
    $tc = $typeCfg[$lesson->type] ?? ['bg'=>'#f4f6fb','c'=>'#858796','icon'=>'mdi-file-outline','label'=>ucfirst($lesson->type)];
    $isAdmin = auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor');
@endphp

{{-- ===== PAGE HEADER ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
            <div class="card-body py-4 px-4">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-8 mb-3 mb-xl-0">
                        <div class="d-flex align-items-center" style="gap: 10px; margin-bottom: 8px; flex-wrap: wrap;">
                            <h4 class="font-weight-bold text-white mb-0">{{ $lesson->title }}</h4>
                            <span style="background: {{ $tc['bg'] }}; color: {{ $tc['c'] }}; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">
                                <i class="mdi {{ $tc['icon'] }} mr-1"></i>{{ $tc['label'] }}
                            </span>
                            <span style="background: rgba(255,255,255,0.2); color: #fff; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">
                                Materi {{ $lesson->order }}
                            </span>
                            @if($lesson->is_free)
                            <span style="background: rgba(28,200,138,0.25); color: #fff; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">Gratis</span>
                            @else
                            <span style="background: rgba(255,255,255,0.15); color: #fff; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">Berbayar</span>
                            @endif
                        </div>
                        <p class="text-white-50 mb-0" style="font-size: 13px;">
                            <i class="mdi mdi-folder-outline mr-1"></i>{{ $lesson->module->title }}
                            <span class="mx-1">·</span>
                            <i class="mdi mdi-library-outline mr-1"></i>{{ $lesson->module->course->title }}
                        </p>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end flex-wrap" style="gap: 8px;">
                        @if($isAdmin)
                        <a href="{{ route('lessons.edit', $lesson) }}"
                           class="btn font-weight-bold"
                           style="background: rgba(255,255,255,0.15); color: #fff; border-radius: 8px; font-size: 13px; border: 1px solid rgba(255,255,255,0.3);">
                            <i class="mdi mdi-pencil mr-1"></i> Edit
                        </a>
                        @endif
                        <a href="{{ route('modules.show', $lesson->module) }}"
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

<div class="row">

    {{-- ===== LEFT COLUMN ===== --}}
    <div class="col-md-8 mb-4">

        {{-- Lesson Info Card --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-information-outline" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Deskripsi Materi</h5>
                </div>
                <div class="p-4">
                    @if($lesson->description)
                    <p class="text-dark mb-4" style="line-height: 1.8; font-size: 14px;">{{ $lesson->description }}</p>
                    @else
                    <p class="text-muted mb-4" style="font-style: italic;">Tidak ada deskripsi untuk materi ini.</p>
                    @endif

                    {{-- 4 Stat mini cards --}}
                    <div class="row" style="row-gap: 10px;">
                        @foreach([
                            ['label'=>'Urutan',  'val'=>$lesson->order,                                                          'icon'=>'mdi-sort-numeric-ascending',  'bg'=>'#e8f0fe','ic'=>'#4e73df'],
                            ['label'=>'Durasi',  'val'=>$lesson->duration_minutes ? $lesson->duration_minutes.'m' : '—',         'icon'=>'mdi-clock-outline',           'bg'=>'#e0f7fa','ic'=>'#17a2b8'],
                            ['label'=>'Tipe',    'val'=>ucfirst($lesson->type),                                                  'icon'=>$tc['icon'],                   'bg'=>$tc['bg'],'ic'=>$tc['c']],
                            ['label'=>'Dibuat',  'val'=>$lesson->created_at->format('d M Y'),                                   'icon'=>'mdi-calendar-outline',        'bg'=>'#e3f9e5','ic'=>'#1cc88a'],
                        ] as $s)
                        <div class="col-6 col-md-3">
                            <div class="p-3 text-center" style="background: #f8f9fc; border-radius: 10px; border: 1px solid #eaecf4;">
                                <div style="background: {{ $s['bg'] }}; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;">
                                    <i class="mdi {{ $s['icon'] }}" style="font-size: 18px; color: {{ $s['ic'] }};"></i>
                                </div>
                                <p class="text-muted mb-0" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.4px; font-weight: 600;">{{ $s['label'] }}</p>
                                <p class="font-weight-bold text-dark mb-0" style="font-size: 13px;">{{ $s['val'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Konten Materi --}}
        @if($lesson->content_url || $lesson->content_text)
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #fff3e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-play-circle-outline" style="font-size: 18px; color: #f6c23e;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Konten Materi</h5>
                </div>
                <div class="p-4">
                    @if($lesson->content_url)
                    <div class="mb-4">
                        <p class="text-muted mb-2" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px;">Konten Eksternal</p>
                        <a href="{{ $lesson->content_url }}" target="_blank"
                           class="btn"
                           style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 10px 20px; border: none; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="mdi mdi-open-in-new" style="font-size: 16px;"></i> Buka Konten
                        </a>
                        <p class="text-muted mt-2 mb-0" style="font-size: 12px;">{{ $lesson->content_url }}</p>
                    </div>
                    @endif
                    @if($lesson->content_text)
                    <div>
                        <p class="text-muted mb-2" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px;">Teks Konten</p>
                        <div style="background: #f8f9fc; border-radius: 10px; padding: 16px; border: 1px solid #eaecf4; font-size: 13.5px; line-height: 1.7; color: #3d3d3d;">
                            {!! nl2br(e($lesson->content_text)) !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Kuis Terkait --}}
        @if($lesson->quiz->count())
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #fde8e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-help-circle-outline" style="font-size: 18px; color: #e74a3b;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Kuis Terkait ({{ $lesson->quiz->count() }})</h5>
                </div>
                <div class="p-4" style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach($lesson->quiz as $quiz)
                    <div style="border: 1px solid #eaecf4; border-radius: 10px; padding: 16px; background: #f8f9fc;">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h6 class="font-weight-bold text-dark mb-0" style="font-size: 14px;">{{ $quiz->title }}</h6>
                            <a href="{{ route('quizzes.show', $quiz) }}"
                               style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 5px 12px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s; white-space: nowrap;"
                               onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                               onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                <i class="mdi mdi-eye mr-1"></i> Lihat Kuis
                            </a>
                        </div>
                        @if($quiz->description)
                        <p class="text-muted mb-3" style="font-size: 13px;">{{ Str::limit($quiz->description, 120) }}</p>
                        @endif
                        <div class="d-flex flex-wrap" style="gap: 8px;">
                            <span style="background: #e0f7fa; color: #17a2b8; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">
                                <i class="mdi mdi-help-circle-outline mr-1"></i>{{ $quiz->questions->count() }} Soal
                            </span>
                            <span style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">
                                <i class="mdi mdi-check-circle-outline mr-1"></i>{{ $quiz->passing_score }}% Lulus
                            </span>
                            <span style="background: #fff3e8; color: #f6c23e; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">
                                <i class="mdi mdi-clock-outline mr-1"></i>{{ $quiz->time_limit_minutes ? $quiz->time_limit_minutes.'m' : '∞' }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </div>

    {{-- ===== SIDEBAR ===== --}}
    <div class="col-md-4 mb-4">

        {{-- Modul Info --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e0f7fa; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-folder-outline" style="font-size: 18px; color: #17a2b8;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Informasi Modul</h5>
                </div>
                <div class="p-4">
                    <h6 class="font-weight-bold text-dark mb-1">{{ $lesson->module->title }}</h6>
                    <p class="text-muted mb-1" style="font-size: 12px;">Modul {{ $lesson->module->order }}</p>
                    @if($lesson->module->description)
                    <p class="text-muted mb-3" style="font-size: 13px;">{{ Str::limit($lesson->module->description, 90) }}</p>
                    @endif
                    <a href="{{ route('modules.show', $lesson->module) }}"
                       class="btn btn-block mb-3"
                       style="background: #e8f0fe; color: #4e73df; border-radius: 8px; font-weight: 600; font-size: 13px; border: none; padding: 10px; transition: all 0.2s;"
                       onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                       onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                        <i class="mdi mdi-eye mr-1"></i> Lihat Modul
                    </a>
                    <div style="background: #f8f9fc; border-radius: 8px; padding: 12px;">
                        @foreach([
                            ['label'=>'Jumlah Materi', 'val'=> $lesson->module->lessons->count()],
                            ['label'=>'Mata Pelajaran','val'=> $lesson->module->course->title],
                            ['label'=>'Level',         'val'=> ucfirst($lesson->module->course->level)],
                        ] as $info)
                        <div class="d-flex justify-content-between py-1" style="border-bottom: 1px solid #eaecf4;">
                            <small class="text-muted">{{ $info['label'] }}</small>
                            <small class="font-weight-bold text-dark">{{ $info['val'] }}</small>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Admin Actions --}}
        @if($isAdmin)
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #fff3e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-lightning-bolt" style="font-size: 18px; color: #f6c23e;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Tindakan Cepat</h5>
                </div>
                <div class="p-4">
                    {{-- Meta --}}
                    <div style="background: #f8f9fc; border-radius: 8px; padding: 12px; margin-bottom: 14px;">
                        @foreach([
                            ['label'=>'ID Materi',    'val'=> '#'.$lesson->id],
                            ['label'=>'Dibuat',       'val'=> $lesson->created_at->format('d M Y')],
                            ['label'=>'Diperbarui',   'val'=> $lesson->updated_at->format('d M Y')],
                        ] as $m)
                        <div class="d-flex justify-content-between py-1" style="border-bottom: 1px solid #eaecf4;">
                            <small class="text-muted">{{ $m['label'] }}</small>
                            <small class="font-weight-bold text-dark">{{ $m['val'] }}</small>
                        </div>
                        @endforeach
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <a href="{{ route('lessons.edit', $lesson) }}"
                           class="btn btn-block"
                           style="background: #e8f0fe; color: #4e73df; border-radius: 8px; font-weight: 600; font-size: 13px; border: none; padding: 10px; transition: all 0.2s;"
                           onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                           onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                            <i class="mdi mdi-pencil mr-1"></i> Edit Materi
                        </a>
                        <a href="{{ route('quizzes.create', ['lesson' => $lesson->id]) }}"
                           class="btn btn-block"
                           style="background: #e3f9e5; color: #1cc88a; border-radius: 8px; font-weight: 600; font-size: 13px; border: none; padding: 10px; transition: all 0.2s;"
                           onmouseover="this.style.background='#1cc88a';this.style.color='#fff';"
                           onmouseout="this.style.background='#e3f9e5';this.style.color='#1cc88a';">
                            <i class="mdi mdi-plus mr-1"></i> Tambah Kuis
                        </a>
                        <form action="{{ route('lessons.destroy', $lesson->id) }}" method="POST" class="m-0"
                              onsubmit="confirmDelete(event, 'Materi ini akan dihapus permanen beserta semua data progresnya.'); return false;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-block"
                                    {{ $lesson->quiz->count() ? 'disabled' : '' }}
                                    style="background: #fde8e8; color: #e74a3b; border-radius: 8px; font-weight: 600; font-size: 13px; border: none; padding: 10px; width: 100%; transition: all 0.2s; {{ $lesson->quiz->count() ? 'opacity:0.5;cursor:not-allowed;' : '' }}"
                                    onmouseover="if(!this.disabled){this.style.background='#e74a3b';this.style.color='#fff';}"
                                    onmouseout="if(!this.disabled){this.style.background='#fde8e8';this.style.color='#e74a3b';}">
                                <i class="mdi mdi-delete mr-1"></i> Hapus Materi
                            </button>
                        </form>
                        @if($lesson->quiz->count())
                        <small class="text-muted" style="font-size: 11.5px;">
                            <i class="mdi mdi-alert-circle-outline mr-1 text-warning"></i>Hapus kuis terlebih dahulu sebelum menghapus materi.
                        </small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Statistik --}}
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e3f9e5; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-chart-bar" style="font-size: 18px; color: #1cc88a;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Statistik Materi</h5>
                </div>
                <div class="p-4">
                    @foreach([
                        ['label'=>'Durasi',  'val'=> $lesson->duration_minutes ? $lesson->duration_minutes.'m' : '—', 'c'=>'#4e73df'],
                        ['label'=>'Tipe',    'val'=> ucfirst($lesson->type),                                          'c'=>$tc['c']],
                        ['label'=>'Usia',    'val'=> $lesson->created_at->diffForHumans(),                            'c'=>'#1cc88a'],
                    ] as $s)
                    <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #f0f0f3;">
                        <span class="text-muted" style="font-size: 13px;">{{ $s['label'] }}</span>
                        <span style="font-size: 13.5px; font-weight: 700; color: {{ $s['c'] }};">{{ $s['val'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
function confirmDelete(event, message) {
    const form = event.currentTarget;
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74a3b',
        cancelButtonColor: '#858796',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        customClass: { popup: 'rounded' }
    }).then((result) => {
        if (result.isConfirmed) form.submit();
    });
}
</script>
@endpush

@endsection