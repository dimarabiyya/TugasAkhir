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
                                <i class="mdi mdi-folder-plus-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Buat Modul Baru</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">
                                    Tambahkan ke <strong class="text-white">{{ $course->title }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('courses.show', $course) }}"
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

{{-- Context banner --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #4e73df !important;">
            <div class="card-body py-3 px-4">
                <div class="d-flex align-items-center" style="gap: 12px;">
                    <div style="background: linear-gradient(135deg, #4e73df, #224abe); border-radius: 10px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="mdi mdi-library-outline text-white" style="font-size: 20px;"></i>
                    </div>
                    <div>
                        <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">{{ $course->title }}</p>
                        <p class="mb-0 text-muted" style="font-size: 12.5px;">{{ ucfirst($course->level) }} · {{ $course->modules->count() }} modul sudah ada</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    {{-- ===== FORM ===== --}}
    <div class="col-md-8 mb-4">
        <form action="{{ route('modules.store', $course) }}" method="POST">
            @csrf

            {{-- Section: Informasi Modul --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-text-box-outline" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Informasi Modul</h5>
                            <small class="text-muted">Judul, deskripsi, dan urutan modul</small>
                        </div>
                    </div>
                    <div class="p-4">

                        {{-- Judul --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-format-title mr-1 text-muted"></i> Judul Modul <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}"
                                   placeholder="Masukkan judul modul" required
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                   onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                   onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-text mr-1 text-muted"></i> Deskripsi
                            </label>
                            <textarea name="description" rows="4"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Masukkan deskripsi modul (opsional)"
                                      style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; resize: vertical;"
                                      onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                      onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Urutan --}}
                        <div class="form-group mb-0">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-sort-numeric-ascending mr-1 text-muted"></i> Urutan <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="order"
                                   class="form-control @error('order') is-invalid @enderror"
                                   value="{{ old('order', $nextOrder) }}"
                                   min="1" required
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px; max-width: 180px;"
                                   onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                   onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                            @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted d-block mt-1" style="font-size: 11px;">Urutan menentukan posisi modul dalam mata pelajaran</small>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Action Bar --}}
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body px-4 py-3">
                    <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 10px;">
                        <p class="text-muted mb-0" style="font-size: 12px;">
                            <i class="mdi mdi-information-outline mr-1 text-primary"></i>
                            Modul akan tersedia setelah disimpan
                        </p>
                        <div class="d-flex" style="gap: 8px;">
                            <a href="{{ route('courses.show', $course) }}"
                               class="btn"
                               style="background: #f4f6fb; color: #6b7280; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 20px; border: 1px solid #e3e6f0; transition: all 0.2s;"
                               onmouseover="this.style.background='#e3e6f0';" onmouseout="this.style.background='#f4f6fb';">
                                <i class="mdi mdi-close mr-1"></i> Batal
                            </a>
                            <button type="submit"
                                    style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 22px; border: none; box-shadow: 0 4px 12px rgba(78,115,223,0.3); cursor: pointer;"
                                    onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                                <i class="mdi mdi-content-save-outline mr-1"></i> Buat Modul
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

    {{-- ===== SIDEBAR ===== --}}
    <div class="col-md-4 mb-4">

        {{-- Statistik Mata Pelajaran --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e0f7fa; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-chart-bar" style="font-size: 18px; color: #17a2b8;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Statistik Mata Pelajaran</h5>
                </div>
                <div class="p-4">
                    @foreach([
                        ['label'=>'Modul',         'val'=> $course->modules->count(),  'c'=>'#4e73df'],
                        ['label'=>'Total Materi',  'val'=> $course->lessons_count,     'c'=>'#17a2b8'],
                        ['label'=>'Durasi',        'val'=> $course->duration_hours.'h','c'=>'#1cc88a'],
                    ] as $s)
                    <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #f0f0f3;">
                        <span class="text-muted" style="font-size: 13px;">{{ $s['label'] }}</span>
                        <span style="font-size: 13.5px; font-weight: 700; color: {{ $s['c'] }};">{{ $s['val'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Modul yang Ada --}}
        @if($course->modules->count() > 0)
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e3f9e5; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-format-list-bulleted" style="font-size: 18px; color: #1cc88a;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Modul yang Ada</h5>
                </div>
                <div class="p-4" style="display: flex; flex-direction: column; gap: 8px;">
                    @foreach($course->modules->sortBy('order')->take(5) as $module)
                    <div style="background: #f8f9fc; border-radius: 8px; padding: 10px 12px; border: 1px solid #eaecf4; display: flex; align-items: center; gap: 10px;">
                        <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 2px 8px; font-size: 11px; font-weight: 700; flex-shrink: 0;">{{ $module->order }}</span>
                        <div style="flex: 1; min-width: 0;">
                            <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $module->title }}</p>
                            <small class="text-muted">{{ $module->lessons->count() }} materi</small>
                        </div>
                    </div>
                    @endforeach
                    @if($course->modules->count() > 5)
                    <p class="text-muted mb-0 text-center" style="font-size: 12px;">
                        + {{ $course->modules->count() - 5 }} modul lainnya
                    </p>
                    @endif
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

@endsection