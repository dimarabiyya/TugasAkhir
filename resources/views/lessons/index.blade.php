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
                                <i class="mdi mdi-book-open-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Manajemen Materi</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Kelola materi mata pelajaran dan kontennya</p>
                            </div>
                        </div>
                    </div>
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <button type="button"
                                data-bs-toggle="modal" data-bs-target="#selectModuleModal"
                                class="btn font-weight-bold"
                                style="background: #fff; color: #4e73df; border-radius: 8px; font-size: 13px; border: none;">
                            <i class="mdi mdi-plus mr-1"></i> Buat Materi
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== FILTER CARD ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('lessons.index') }}" id="searchForm">
                    <div class="row align-items-end" style="gap: 0; row-gap: 12px;">

                        {{-- Search --}}
                        <div class="col-md-4">
                            <label class="mb-1" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796;">Cari Materi</label>
                            <div style="position: relative;">
                                <i class="mdi mdi-magnify" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #adb5bd; font-size: 17px; pointer-events: none;"></i>
                                <input type="text" class="form-control" name="search"
                                       value="{{ request('search') }}"
                                       placeholder="Judul, deskripsi, atau mata pelajaran..."
                                       style="padding-left: 38px; border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 42px;"
                                       onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                       onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                            </div>
                        </div>

                        {{-- Filter Modul --}}
                        <div class="col-md-3">
                            <label class="mb-1" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796;">Modul</label>
                            <div style="position: relative;">
                                <select class="form-control" name="module_id"
                                        style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 42px; appearance: none; -webkit-appearance: none; padding-right: 36px; cursor: pointer;"
                                        onfocus="this.style.borderColor='#4e73df';" onblur="this.style.borderColor='#d1d3e2';">
                                    <option value="">Semua Modul</option>
                                    @foreach($modules as $module)
                                    <option value="{{ $module->id }}" {{ request('module_id') == $module->id ? 'selected' : '' }}>
                                        {{ $module->course->title }} — {{ $module->title }}
                                    </option>
                                    @endforeach
                                </select>
                                <i class="mdi mdi-chevron-down" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #adb5bd; font-size: 18px; pointer-events: none;"></i>
                            </div>
                        </div>

                        {{-- Filter Tipe --}}
                        <div class="col-md-3">
                            <label class="mb-1" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796;">Tipe</label>
                            <div style="position: relative;">
                                <select class="form-control" name="type"
                                        style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 42px; appearance: none; -webkit-appearance: none; padding-right: 36px; cursor: pointer;"
                                        onfocus="this.style.borderColor='#4e73df';" onblur="this.style.borderColor='#d1d3e2';">
                                    <option value="">Semua Tipe</option>
                                    @foreach($lessonTypes as $type)
                                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                                    @endforeach
                                </select>
                                <i class="mdi mdi-chevron-down" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #adb5bd; font-size: 18px; pointer-events: none;"></i>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="col-md-2 d-flex" style="gap: 8px;">
                            <button type="submit"
                                    style="flex: 1; background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; height: 42px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 4px;">
                                <i class="mdi mdi-magnify"></i> Cari
                            </button>
                            <a href="{{ route('lessons.index') }}"
                               style="background: #f4f6fb; color: #6b7280; border-radius: 8px; border: 1px solid #e3e6f0; width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; text-decoration: none; flex-shrink: 0; transition: all 0.2s;"
                               title="Reset"
                               onmouseover="this.style.background='#e3e6f0';" onmouseout="this.style.background='#f4f6fb';">
                                <i class="mdi mdi-refresh" style="font-size: 17px;"></i>
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ===== TABLE CARD ===== --}}
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">

                {{-- Card Header --}}
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-book-open-outline" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Semua Materi</h5>
                        <small class="text-muted">{{ $lessons->total() }} materi terdaftar</small>
                    </div>
                </div>

                @if($lessons->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center; width: 60px;">#</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Judul</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Tipe</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Modul</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Mata Pelajaran</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Durasi</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lessons as $lesson)
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
                            <tr style="transition: background 0.15s;" onmouseover="this.style.background='#f8f9fc';" onmouseout="this.style.background='white';">

                                {{-- Urutan --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                                    <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 3px 9px; font-size: 12px; font-weight: 700;">{{ $lesson->order }}</span>
                                </td>

                                {{-- Judul --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; max-width: 220px;">
                                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 13.5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $lesson->title }}</p>
                                    @if($lesson->description)
                                    <small class="text-muted">{{ Str::limit($lesson->description, 55) }}</small>
                                    @endif
                                </td>

                                {{-- Tipe --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <span style="background: {{ $tc['bg'] }}; color: {{ $tc['c'] }}; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap;">
                                        <i class="mdi {{ $tc['icon'] }}" style="font-size: 13px;"></i>{{ ucfirst($lesson->type) }}
                                    </span>
                                </td>

                                {{-- Modul --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px;">{{ $lesson->module->title }}</p>
                                    <small class="text-muted">Modul {{ $lesson->module->order }}</small>
                                </td>

                                {{-- Mata Pelajaran --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; max-width: 180px;">
                                    <a href="{{ route('courses.show', $lesson->module->course) }}"
                                       class="font-weight-bold"
                                       style="color: #4e73df; font-size: 13px; text-decoration: none; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $lesson->module->course->title }}
                                    </a>
                                    <small class="text-muted text-capitalize">{{ $lesson->module->course->level }}</small>
                                </td>

                                {{-- Durasi --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                                    @if($lesson->duration_minutes)
                                    <span style="font-size: 13px; color: #5a5c69;">
                                        <i class="mdi mdi-clock-outline mr-1" style="color: #adb5bd;"></i>{{ $lesson->duration_minutes }}m
                                    </span>
                                    @else
                                    <span class="text-muted">—</span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                                    <div class="d-flex align-items-center justify-content-center" style="gap: 5px;">
                                        <a href="{{ route('lessons.show', $lesson) }}" title="Lihat"
                                           style="background: #e8f0fe; color: #4e73df; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;"
                                           onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                           onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                            <i class="mdi mdi-eye" style="font-size: 15px;"></i>
                                        </a>
                                        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
                                        <a href="{{ route('lessons.edit', $lesson) }}" title="Edit"
                                           style="background: #e8f0fe; color: #4e73df; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;"
                                           onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                           onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                            <i class="mdi mdi-pencil" style="font-size: 15px;"></i>
                                        </a>
                                        <form action="{{ route('lessons.destroy', $lesson) }}" method="POST" class="d-inline m-0"
                                              onsubmit="confirmDelete(event, 'Materi ini akan dihapus permanen.');">
                                            @csrf @method('DELETE')
                                            <button type="submit" title="Hapus"
                                                    style="background: #fde8e8; color: #e74a3b; border: none; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;"
                                                    onmouseover="this.style.background='#e74a3b';this.style.color='#fff';"
                                                    onmouseout="this.style.background='#fde8e8';this.style.color='#e74a3b';">
                                                <i class="mdi mdi-delete" style="font-size: 15px;"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-4 py-3" style="border-top: 1px solid #f0f0f3; background: #fafbff; border-radius: 0 0 12px 12px;">
                    <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 8px;">
                        <p class="text-muted mb-0" style="font-size: 12px;">
                            Menampilkan {{ $lessons->firstItem() }}–{{ $lessons->lastItem() }} dari {{ $lessons->total() }} materi
                        </p>
                        {{ $lessons->withQueryString()->links() }}
                    </div>
                </div>

                @else
                <div class="text-center py-5">
                    <div style="background: #f0f0f3; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                        <i class="mdi mdi-book-open-outline" style="font-size: 40px; color: #c4c6d0;"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-1">Tidak Ada Materi Ditemukan</h5>
                    <p class="text-muted mb-4" style="font-size: 13.5px;">
                        @if(request()->hasAny(['search', 'module_id', 'type']))
                            Coba sesuaikan kriteria pencarian Anda.
                        @else
                            Belum ada materi yang dibuat.
                        @endif
                    </p>
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
                    <button type="button" data-bs-toggle="modal" data-bs-target="#selectModuleModal"
                            class="btn btn-primary" style="border-radius: 8px; font-weight: 600; padding: 10px 24px;">
                        <i class="mdi mdi-plus mr-1"></i> Buat Materi Pertama
                    </button>
                    @endif
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

{{-- ===== MODULE SELECTION MODAL ===== --}}
<div class="modal fade" id="selectModuleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 16px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">

            {{-- Modal Header --}}
            <div style="background: linear-gradient(135deg, #4e73df, #224abe); padding: 18px 24px; display: flex; align-items: center; justify-content: space-between;">
                <div class="d-flex align-items-center" style="gap: 10px;">
                    <div style="background: rgba(255,255,255,0.2); border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center;">
                        <i class="mdi mdi-folder-outline text-white" style="font-size: 18px;"></i>
                    </div>
                    <div>
                        <h5 class="text-white mb-0 font-weight-bold" style="font-size: 14px;">Pilih Modul</h5>
                        <p class="text-white-50 mb-0" style="font-size: 12px;">Pilih modul untuk menambahkan materi baru</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: brightness(0) invert(1); opacity: 0.8;"></button>
            </div>

            <div class="p-4">
                @if($modules->count() > 0)
                <div class="row" style="gap: 0; row-gap: 12px;">
                    @foreach($modules as $module)
                    <div class="col-md-6">
                        <div onclick="selectLessonModule({{ $module->id }})"
                             style="border: 2px solid #eaecf4; border-radius: 10px; padding: 14px 16px; cursor: pointer; transition: all 0.2s; background: #fff;"
                             onmouseover="this.style.borderColor='#4e73df'; this.style.background='#f0f4ff'; this.style.transform='translateY(-2px)';"
                             onmouseout="this.style.borderColor='#eaecf4'; this.style.background='#fff'; this.style.transform='';">
                            <div class="d-flex align-items-start justify-content-between mb-2">
                                <h6 class="font-weight-bold text-dark mb-0" style="font-size: 13.5px;">{{ $module->title }}</h6>
                                <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 2px 8px; font-size: 11px; font-weight: 700; flex-shrink: 0; margin-left: 8px;">Modul {{ $module->order }}</span>
                            </div>
                            @if($module->description)
                            <p class="text-muted mb-2" style="font-size: 12px;">{{ Str::limit($module->description, 70) }}</p>
                            @endif
                            <div class="d-flex align-items-center justify-content-between">
                                <small class="text-muted" style="font-size: 11.5px;">
                                    <i class="mdi mdi-library-outline mr-1"></i>{{ $module->course->title }}
                                </small>
                                <small style="color: #1cc88a; font-size: 11.5px; font-weight: 600;">
                                    <i class="mdi mdi-book-open-outline mr-1"></i>{{ $module->lessons->count() }} materi
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-4">
                    <div style="background: #f0f0f3; border-radius: 50%; width: 64px; height: 64px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                        <i class="mdi mdi-folder-outline" style="font-size: 32px; color: #c4c6d0;"></i>
                    </div>
                    <h6 class="font-weight-bold text-dark mb-1">Belum Ada Modul</h6>
                    <p class="text-muted mb-3" style="font-size: 13px;">Buat modul terlebih dahulu sebelum menambahkan materi.</p>
                    <a href="{{ route('courses.index') }}" class="btn btn-primary" style="border-radius: 8px; font-weight: 600;">
                        <i class="mdi mdi-plus mr-1"></i> Buat Modul
                    </a>
                </div>
                @endif
            </div>

            <div class="px-4 pb-4 d-flex justify-content-end">
                <button type="button" data-bs-dismiss="modal"
                        style="background: #f4f6fb; color: #6b7280; border-radius: 8px; font-weight: 600; font-size: 13px; padding: 9px 18px; border: 1px solid #e3e6f0; cursor: pointer;">
                    Batal
                </button>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
function selectLessonModule(moduleId) {
    window.location.href = "{{ route('modules.lessons.create', ':id') }}".replace(':id', moduleId);
}
</script>
@endpush

@endsection