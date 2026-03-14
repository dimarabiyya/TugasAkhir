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
                                <i class="mdi mdi-folder-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Manajemen Modul</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Kelola modul mata pelajaran dan kontennya</p>
                            </div>
                        </div>
                    </div>
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <button type="button"
                                data-bs-toggle="modal" data-bs-target="#selectCourseModal"
                                class="btn font-weight-bold"
                                style="background: #fff; color: #4e73df; border-radius: 8px; font-size: 13px; border: none;">
                            <i class="mdi mdi-plus mr-1"></i> Buat Modul
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
                <form method="GET" action="{{ route('modules.index') }}">
                    <div class="row align-items-end" style="row-gap: 12px;">

                        {{-- Search --}}
                        <div class="col-md-6">
                            <label class="mb-1" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796;">Cari Modul</label>
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

                        {{-- Filter Mata Pelajaran --}}
                        <div class="col-md-4">
                            <label class="mb-1" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796;">Mata Pelajaran</label>
                            <div style="position: relative;">
                                <select class="form-control" name="course_id"
                                        style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 42px; appearance: none; -webkit-appearance: none; padding-right: 36px; cursor: pointer;"
                                        onfocus="this.style.borderColor='#4e73df';" onblur="this.style.borderColor='#d1d3e2';">
                                    <option value="">Semua Mata Pelajaran</option>
                                    @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
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
                            <a href="{{ route('modules.index') }}"
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

                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-folder-outline" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Semua Modul</h5>
                        <small class="text-muted">{{ $modules->total() }} modul terdaftar</small>
                    </div>
                </div>

                @if($modules->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center; width: 60px;">#</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Judul</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Mata Pelajaran</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Materi</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Deskripsi</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($modules as $module)
                            <tr style="transition: background 0.15s;" onmouseover="this.style.background='#f8f9fc';" onmouseout="this.style.background='white';">

                                {{-- Urutan --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                                    <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 3px 9px; font-size: 12px; font-weight: 700;">{{ $module->order }}</span>
                                </td>

                                {{-- Judul --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; max-width: 200px;">
                                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 13.5px;">{{ $module->title }}</p>
                                    <small class="text-muted">ID: #{{ $module->id }}</small>
                                </td>

                                {{-- Mata Pelajaran --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <a href="{{ route('courses.show', $module->course) }}"
                                       class="font-weight-bold"
                                       style="color: #4e73df; font-size: 13px; text-decoration: none; display: block;">
                                        {{ $module->course->title }}
                                    </a>
                                    <small class="text-muted text-capitalize">{{ $module->course->level }}</small>
                                </td>

                                {{-- Materi --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                                    <span style="background: #e0f7fa; color: #17a2b8; border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 700;">
                                        {{ $module->lessons->count() }}
                                    </span>
                                </td>

                                {{-- Deskripsi --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; max-width: 220px;">
                                    @if($module->description)
                                    <p class="text-muted mb-0" style="font-size: 12.5px;">{{ Str::limit($module->description, 70) }}</p>
                                    @else
                                    <span class="text-muted" style="font-size: 12px; font-style: italic;">Tidak ada deskripsi</span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                                    <div class="d-flex align-items-center justify-content-center" style="gap: 5px;">
                                        <a href="{{ route('modules.show', $module) }}" title="Lihat"
                                           style="background: #e8f0fe; color: #4e73df; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;"
                                           onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                           onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                            <i class="mdi mdi-eye" style="font-size: 15px;"></i>
                                        </a>
                                        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
                                        <a href="{{ route('modules.edit', $module) }}" title="Edit"
                                           style="background: #e8f0fe; color: #4e73df; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;"
                                           onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                           onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                            <i class="mdi mdi-pencil" style="font-size: 15px;"></i>
                                        </a>
                                        <form action="{{ route('modules.destroy', $module) }}" method="POST" class="d-inline m-0"
                                              onsubmit="confirmDelete(event, 'Modul ini akan dihapus permanen.');">
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
                            Menampilkan {{ $modules->firstItem() }}–{{ $modules->lastItem() }} dari {{ $modules->total() }} modul
                        </p>
                        {{ $modules->withQueryString()->links() }}
                    </div>
                </div>

                @else
                <div class="text-center py-5">
                    <div style="background: #f0f0f3; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                        <i class="mdi mdi-folder-outline" style="font-size: 40px; color: #c4c6d0;"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-1">Tidak Ada Modul Ditemukan</h5>
                    <p class="text-muted mb-4" style="font-size: 13.5px;">
                        @if(request()->hasAny(['search', 'course_id']))
                            Coba sesuaikan kriteria pencarian Anda.
                        @else
                            Belum ada modul yang dibuat.
                        @endif
                    </p>
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
                    <button type="button" data-bs-toggle="modal" data-bs-target="#selectCourseModal"
                            class="btn btn-primary" style="border-radius: 8px; font-weight: 600; padding: 10px 24px;">
                        <i class="mdi mdi-plus mr-1"></i> Buat Modul Pertama
                    </button>
                    @endif
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

{{-- ===== COURSE SELECTION MODAL ===== --}}
<div class="modal fade" id="selectCourseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 16px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">

            <div style="background: linear-gradient(135deg, #4e73df, #224abe); padding: 18px 24px; display: flex; align-items: center; justify-content: space-between;">
                <div class="d-flex align-items-center" style="gap: 10px;">
                    <div style="background: rgba(255,255,255,0.2); border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center;">
                        <i class="mdi mdi-library-outline text-white" style="font-size: 18px;"></i>
                    </div>
                    <div>
                        <h5 class="text-white mb-0 font-weight-bold" style="font-size: 14px;">Pilih Mata Pelajaran</h5>
                        <p class="text-white-50 mb-0" style="font-size: 12px;">Pilih mata pelajaran untuk modul baru</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: brightness(0) invert(1); opacity: 0.8;"></button>
            </div>

            <div class="p-4">
                @if($courses->count() > 0)
                <div class="row" style="row-gap: 12px;">
                    @foreach($courses as $course)
                    @php
                        $levelCfg = ['beginner'=>['#e3f9e5','#1cc88a'],'intermediate'=>['#fff3e8','#f6c23e'],'advanced'=>['#fde8e8','#e74a3b']];
                        $lc = $levelCfg[$course->level] ?? ['#f4f6fb','#858796'];
                    @endphp
                    <div class="col-md-6">
                        <div onclick="selectCourse({{ $course->id }})"
                             style="border: 2px solid #eaecf4; border-radius: 10px; padding: 14px 16px; cursor: pointer; transition: all 0.2s; background: #fff;"
                             onmouseover="this.style.borderColor='#4e73df'; this.style.background='#f0f4ff'; this.style.transform='translateY(-2px)';"
                             onmouseout="this.style.borderColor='#eaecf4'; this.style.background='#fff'; this.style.transform='';">
                            <div class="d-flex align-items-start justify-content-between mb-2">
                                <h6 class="font-weight-bold text-dark mb-0" style="font-size: 13.5px; flex: 1; margin-right: 8px;">{{ $course->title }}</h6>
                                <span style="background: {{ $lc[0] }}; color: {{ $lc[1] }}; border-radius: 6px; padding: 2px 8px; font-size: 11px; font-weight: 700; flex-shrink: 0; text-transform: capitalize;">
                                    {{ ucfirst($course->level) }}
                                </span>
                            </div>
                            @if($course->description)
                            <p class="text-muted mb-2" style="font-size: 12px;">{{ Str::limit($course->description, 70) }}</p>
                            @endif
                            <small style="color: #1cc88a; font-size: 11.5px; font-weight: 600;">
                                <i class="mdi mdi-folder-outline mr-1"></i>{{ $course->modules->count() }} modul
                            </small>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-4">
                    <div style="background: #f0f0f3; border-radius: 50%; width: 64px; height: 64px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                        <i class="mdi mdi-library-outline" style="font-size: 32px; color: #c4c6d0;"></i>
                    </div>
                    <h6 class="font-weight-bold text-dark mb-1">Belum Ada Mata Pelajaran</h6>
                    <p class="text-muted mb-3" style="font-size: 13px;">Buat mata pelajaran terlebih dahulu sebelum menambahkan modul.</p>
                    <a href="{{ route('courses.create') }}" class="btn btn-primary" style="border-radius: 8px; font-weight: 600;">
                        <i class="mdi mdi-plus mr-1"></i> Buat Mata Pelajaran
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
function selectCourse(courseId) {
    window.location.href = `/courses/${courseId}/modules/create`;
}
</script>
@endpush

@endsection