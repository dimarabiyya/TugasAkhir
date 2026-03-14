@extends('layouts.skydash')

@section('content')

@php $isAdmin = auth()->user()->hasAnyRole(['admin', 'instructor']); @endphp

{{-- ===== PAGE HEADER ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
            <div class="card-body py-4 px-4">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-8 mb-3 mb-xl-0">
                        <div class="d-flex align-items-center flex-wrap" style="gap: 10px; margin-bottom: 8px;">
                            <h4 class="font-weight-bold text-white mb-0">{{ $module->title }}</h4>
                            <span style="background: rgba(255,255,255,0.2); color: #fff; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">Modul {{ $module->order }}</span>
                            <span style="background: rgba(255,255,255,0.2); color: #fff; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">
                                {{ $module->lessons->count() }} Materi
                            </span>
                            <span style="background: rgba(255,255,255,0.15); color: #fff; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700; text-transform: capitalize;">
                                {{ $module->course->level }}
                            </span>
                        </div>
                        <p class="text-white-50 mb-0" style="font-size: 13px;">
                            <i class="mdi mdi-library-outline mr-1"></i>{{ $module->course->title }}
                        </p>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end flex-wrap" style="gap: 8px;">
                        @if($isAdmin)
                        <a href="{{ route('modules.edit', $module) }}"
                           class="btn font-weight-bold"
                           style="background: rgba(255,255,255,0.15); color: #fff; border-radius: 8px; font-size: 13px; border: 1px solid rgba(255,255,255,0.3);">
                            <i class="mdi mdi-pencil mr-1"></i> Edit
                        </a>
                        @endif
                        <a href="{{ route('courses.show', $module->course) }}"
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

        {{-- Modul Info --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-information-outline" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Ikhtisar Modul</h5>
                </div>
                <div class="p-4">
                    @if($module->description)
                    <p class="text-dark mb-4" style="line-height: 1.8; font-size: 14px;">{{ $module->description }}</p>
                    @else
                    <p class="text-muted mb-4" style="font-style: italic;">Tidak ada deskripsi untuk modul ini.</p>
                    @endif

                    <div class="row" style="row-gap: 10px;">
                        @foreach([
                            ['label'=>'Urutan', 'val'=> $module->order,                          'icon'=>'mdi-sort-numeric-ascending', 'bg'=>'#e8f0fe','ic'=>'#4e73df'],
                            ['label'=>'Materi', 'val'=> $module->lessons->count(),               'icon'=>'mdi-book-open-outline',      'bg'=>'#e3f9e5','ic'=>'#1cc88a'],
                            ['label'=>'Dibuat', 'val'=> $module->created_at->format('d M Y'),    'icon'=>'mdi-calendar-outline',       'bg'=>'#e0f7fa','ic'=>'#17a2b8'],
                        ] as $s)
                        <div class="col-4">
                            <div class="text-center p-3" style="background: #f8f9fc; border-radius: 10px; border: 1px solid #eaecf4;">
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

        {{-- Daftar Materi --}}
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center justify-content-between px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div class="d-flex align-items-center">
                        <div style="background: #e3f9e5; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-book-open-outline" style="font-size: 18px; color: #1cc88a;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Materi Modul ({{ $module->lessons->count() }})</h5>
                        </div>
                    </div>
                    @if($isAdmin)
                    <a href="{{ route('modules.lessons.create', $module) }}"
                       style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 6px 12px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s;"
                       onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                       onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                        <i class="mdi mdi-plus mr-1"></i> Tambah Materi
                    </a>
                    @endif
                </div>

                @if($module->lessons->count() > 0)
                <div class="p-4" style="display: flex; flex-direction: column; gap: 10px;">
                    @foreach($module->lessons->sortBy('order') as $lesson)
                    @php
                        $typeCfg = [
                            'video'       => ['bg'=>'#e0f7fa','c'=>'#17a2b8','icon'=>'mdi-play-circle-outline'],
                            'reading'     => ['bg'=>'#e3f9e5','c'=>'#1cc88a','icon'=>'mdi-text'],
                            'audio'       => ['bg'=>'#fff3e8','c'=>'#f6c23e','icon'=>'mdi-music-note'],
                            'interactive' => ['bg'=>'#e8f0fe','c'=>'#4e73df','icon'=>'mdi-gesture-tap'],
                            'quiz'        => ['bg'=>'#fde8e8','c'=>'#e74a3b','icon'=>'mdi-help-circle-outline'],
                        ];
                        $tc = $typeCfg[$lesson->type] ?? ['bg'=>'#f4f6fb','c'=>'#858796','icon'=>'mdi-file-outline'];
                    @endphp
                    <div style="border: 1.5px solid #eaecf4; border-radius: 10px; background: #fff; transition: all 0.2s;"
                         onmouseover="this.style.borderColor='#4e73df'; this.style.background='#f8faff'; this.style.transform='translateY(-1px)';"
                         onmouseout="this.style.borderColor='#eaecf4'; this.style.background='#fff'; this.style.transform='';">
                        <a href="{{ route('lessons.show', $lesson) }}" class="d-block p-3" style="text-decoration: none; color: inherit;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center" style="gap: 10px; flex: 1; min-width: 0;">
                                    <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 2px 9px; font-size: 11px; font-weight: 700; flex-shrink: 0;">{{ $lesson->order }}</span>
                                    <div style="min-width: 0;">
                                        <p class="mb-0 font-weight-bold text-dark" style="font-size: 13.5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $lesson->title }}</p>
                                        @if($lesson->description)
                                        <small class="text-muted">{{ Str::limit($lesson->description, 70) }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-shrink-0 ml-3" style="gap: 6px;">
                                    <span style="background: {{ $tc['bg'] }}; color: {{ $tc['c'] }}; border-radius: 6px; padding: 3px 9px; font-size: 11px; font-weight: 600; white-space: nowrap;">
                                        <i class="mdi {{ $tc['icon'] }}" style="font-size: 12px;"></i> {{ ucfirst($lesson->type) }}
                                    </span>
                                    @if($lesson->is_free)
                                    <span style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 3px 8px; font-size: 10px; font-weight: 700;">Gratis</span>
                                    @endif
                                    @if($lesson->duration_minutes)
                                    <small class="text-muted" style="font-size: 11.5px; white-space: nowrap;">
                                        <i class="mdi mdi-clock-outline mr-1"></i>{{ $lesson->duration_minutes }}m
                                    </small>
                                    @endif
                                    @if($isAdmin)
                                    <a href="{{ route('lessons.edit', $lesson) }}"
                                       onclick="event.stopPropagation();"
                                       style="background: #e8f0fe; color: #4e73df; border-radius: 6px; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;"
                                       onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                       onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                        <i class="mdi mdi-pencil" style="font-size: 13px;"></i>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-5">
                    <div style="background: #f0f0f3; border-radius: 50%; width: 72px; height: 72px; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px;">
                        <i class="mdi mdi-book-open-outline" style="font-size: 36px; color: #c4c6d0;"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-1">Belum Ada Materi</h5>
                    <p class="text-muted mb-3" style="font-size: 13.5px;">Tambahkan materi untuk mengorganisir konten modul ini.</p>
                    @if($isAdmin)
                    <a href="{{ route('modules.lessons.create', $module) }}" class="btn btn-primary" style="border-radius: 8px; font-weight: 600; padding: 10px 24px;">
                        <i class="mdi mdi-plus mr-1"></i> Tambah Materi Pertama
                    </a>
                    @endif
                </div>
                @endif

            </div>
        </div>

    </div>

    {{-- ===== SIDEBAR ===== --}}
    <div class="col-md-4 mb-4">

        {{-- Info Mata Pelajaran --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e0f7fa; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-library-outline" style="font-size: 18px; color: #17a2b8;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Informasi Mata Pelajaran</h5>
                </div>
                <div class="p-4">
                    <h6 class="font-weight-bold text-dark mb-1">{{ $module->course->title }}</h6>
                    <p class="text-muted mb-3" style="font-size: 12.5px; text-transform: capitalize;">Level {{ $module->course->level }}</p>
                    @if($module->course->description)
                    <p class="text-muted mb-3" style="font-size: 13px;">{{ Str::limit($module->course->description, 90) }}</p>
                    @endif
                    <a href="{{ route('courses.show', $module->course) }}"
                       class="btn btn-block mb-3"
                       style="background: #e8f0fe; color: #4e73df; border-radius: 8px; font-weight: 600; font-size: 13px; border: none; padding: 10px; transition: all 0.2s;"
                       onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                       onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                        <i class="mdi mdi-eye mr-1"></i> Lihat Mata Pelajaran
                    </a>
                    <div style="background: #f8f9fc; border-radius: 8px; padding: 12px;">
                        @foreach([
                            ['label'=>'Modul',         'val'=> $module->course->modules->count()],
                            ['label'=>'Total Materi',  'val'=> $module->course->lessons_count],
                            ['label'=>'Durasi',        'val'=> $module->course->duration_hours.'h'],
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

        {{-- Tindakan Cepat (admin) --}}
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
                    <div style="background: #f8f9fc; border-radius: 8px; padding: 12px; margin-bottom: 14px;">
                        @foreach([
                            ['label'=>'ID Modul',   'val'=> '#'.$module->id],
                            ['label'=>'Dibuat',     'val'=> $module->created_at->format('d M Y')],
                            ['label'=>'Diperbarui', 'val'=> $module->updated_at->format('d M Y')],
                        ] as $m)
                        <div class="d-flex justify-content-between py-1" style="border-bottom: 1px solid #eaecf4;">
                            <small class="text-muted">{{ $m['label'] }}</small>
                            <small class="font-weight-bold text-dark">{{ $m['val'] }}</small>
                        </div>
                        @endforeach
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <a href="{{ route('modules.edit', $module) }}"
                           class="btn btn-block"
                           style="background: #e8f0fe; color: #4e73df; border-radius: 8px; font-weight: 600; font-size: 13px; border: none; padding: 10px; transition: all 0.2s;"
                           onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                           onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                            <i class="mdi mdi-pencil mr-1"></i> Edit Modul
                        </a>
                        <a href="{{ route('modules.lessons.create', $module) }}"
                           class="btn btn-block"
                           style="background: #e3f9e5; color: #1cc88a; border-radius: 8px; font-weight: 600; font-size: 13px; border: none; padding: 10px; transition: all 0.2s;"
                           onmouseover="this.style.background='#1cc88a';this.style.color='#fff';"
                           onmouseout="this.style.background='#e3f9e5';this.style.color='#1cc88a';">
                            <i class="mdi mdi-plus mr-1"></i> Tambah Materi
                        </a>
                        <form action="{{ route('modules.destroy', $module) }}" method="POST" class="m-0"
                              onsubmit="confirmDelete(event, 'Modul ini akan dihapus permanen beserta semua materinya.');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-block"
                                    {{ $module->lessons->count() > 0 ? 'disabled' : '' }}
                                    style="background: {{ $module->lessons->count() > 0 ? '#f4f6fb' : '#fde8e8' }}; color: {{ $module->lessons->count() > 0 ? '#adb5bd' : '#e74a3b' }}; border-radius: 8px; font-weight: 600; font-size: 13px; border: none; padding: 10px; width: 100%; {{ $module->lessons->count() > 0 ? 'cursor:not-allowed;' : 'cursor:pointer;' }} transition: all 0.2s;"
                                    onmouseover="if(!this.disabled){this.style.background='#e74a3b';this.style.color='#fff';}"
                                    onmouseout="if(!this.disabled){this.style.background='#fde8e8';this.style.color='#e74a3b';}">
                                <i class="mdi mdi-delete mr-1"></i> Hapus Modul
                            </button>
                        </form>
                        @if($module->lessons->count() > 0)
                        <small class="text-muted" style="font-size: 11.5px;">
                            <i class="mdi mdi-alert-circle-outline mr-1 text-warning"></i>Hapus semua materi terlebih dahulu.
                        </small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Statistik Modul --}}
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e3f9e5; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-chart-bar" style="font-size: 18px; color: #1cc88a;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Statistik Modul</h5>
                </div>
                <div class="p-4">
                    @foreach([
                        ['label'=>'Materi',  'val'=> $module->lessons->count(),             'c'=>'#4e73df'],
                        ['label'=>'Urutan',  'val'=> $module->order,                        'c'=>'#17a2b8'],
                        ['label'=>'Usia',    'val'=> $module->created_at->diffForHumans(),  'c'=>'#1cc88a'],
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