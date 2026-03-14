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
                                <i class="mdi mdi-book-plus-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Buat Materi Baru</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">
                                    Tambahkan ke <strong class="text-white">{{ $module->title }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('modules.show', $module) }}"
                           class="btn font-weight-bold"
                           style="background: #fff; color: #4e73df; border-radius: 8px; font-size: 13px; border: none;">
                            <i class="mdi mdi-arrow-left mr-1"></i> Kembali ke Modul
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Module context banner --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #4e73df !important;">
            <div class="card-body py-3 px-4">
                <div class="d-flex align-items-center" style="gap: 12px;">
                    <div style="background: linear-gradient(135deg, #4e73df, #224abe); border-radius: 10px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="mdi mdi-folder-outline text-white" style="font-size: 20px;"></i>
                    </div>
                    <div>
                        <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">{{ $module->title }}</p>
                        <p class="mb-0 text-muted" style="font-size: 12.5px;">{{ $module->course->title }} · {{ $module->lessons->count() }} materi sudah ada</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    {{-- ===== FORM ===== --}}
    <div class="col-md-8 mb-4">
        <form action="{{ route('modules.lessons.store', $module) }}" method="POST">
            @csrf

            {{-- Section: Informasi Materi --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-text-box-outline" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Informasi Materi</h5>
                            <small class="text-muted">Judul, deskripsi, dan tipe materi</small>
                        </div>
                    </div>
                    <div class="p-4">

                        {{-- Judul --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-format-title mr-1 text-muted"></i> Judul Materi <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}"
                                   placeholder="Masukkan judul materi" required
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
                            <textarea name="description" rows="3"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Masukkan deskripsi materi (opsional)"
                                      style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; resize: vertical;"
                                      onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                      onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Tipe --}}
                        <div class="form-group mb-0">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-tag-outline mr-1 text-muted"></i> Tipe Materi <span class="text-danger">*</span>
                            </label>
                            <div style="position: relative;">
                                <select name="type" required
                                        class="form-control @error('type') is-invalid @enderror"
                                        style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px; appearance: none; -webkit-appearance: none; padding-right: 36px; cursor: pointer;"
                                        onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                        onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                                    <option value="">— Pilih Tipe Materi —</option>
                                    @foreach(['reading', 'video', 'audio', 'quiz'] as $type)
                                    <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                                    @endforeach
                                </select>
                                <i class="mdi mdi-chevron-down" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #adb5bd; font-size: 18px; pointer-events: none;"></i>
                            </div>
                            @error('type') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                    </div>
                </div>
            </div>

            {{-- Section: Konten --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                        <div style="background: #fff3e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-play-circle-outline" style="font-size: 18px; color: #f6c23e;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Konten Materi</h5>
                            <small class="text-muted">URL eksternal dan teks konten</small>
                        </div>
                    </div>
                    <div class="p-4">

                        {{-- URL Konten --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-link-variant mr-1 text-muted"></i> URL Konten
                            </label>
                            <input type="url" name="content_url"
                                   class="form-control @error('content_url') is-invalid @enderror"
                                   value="{{ old('content_url') }}"
                                   placeholder="https://example.com/video"
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                   onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                   onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                            @error('content_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted" style="font-size: 11px;">URL untuk video, audio, atau konten eksternal</small>
                        </div>

                        {{-- Teks Konten --}}
                        <div class="form-group mb-0">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-text mr-1 text-muted"></i> Teks Konten
                            </label>
                            <textarea name="content_text" rows="6"
                                      class="form-control @error('content_text') is-invalid @enderror"
                                      placeholder="Masukkan teks konten materi (opsional)"
                                      style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; resize: vertical;"
                                      onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                      onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">{{ old('content_text') }}</textarea>
                            @error('content_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted" style="font-size: 11px;">Konten teks untuk materi membaca atau informasi tambahan</small>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Section: Pengaturan --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                        <div style="background: #e3f9e5; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-cog-outline" style="font-size: 18px; color: #1cc88a;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Pengaturan</h5>
                            <small class="text-muted">Durasi dan urutan materi</small>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="row">
                            {{-- Durasi --}}
                            <div class="col-md-6 mb-3">
                                <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                    <i class="mdi mdi-clock-outline mr-1 text-muted"></i> Durasi (menit) <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="duration_minutes"
                                       class="form-control @error('duration_minutes') is-invalid @enderror"
                                       value="{{ old('duration_minutes', 30) }}"
                                       min="1" max="999" placeholder="30" required
                                       style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                       onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                       onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                                @error('duration_minutes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            {{-- Urutan --}}
                            <div class="col-md-6 mb-0">
                                <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                    <i class="mdi mdi-sort-numeric-ascending mr-1 text-muted"></i> Urutan <span class="text-danger">*</span>
                                </label>
                                @php $nextOrder = $nextOrder ?? 1; @endphp
                                <input type="number" name="order"
                                       class="form-control @error('order') is-invalid @enderror"
                                       value="{{ old('order', $nextOrder) }}"
                                       min="1" max="999" required
                                       style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                       onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                       onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                                @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
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
                            Materi akan tersedia setelah disimpan
                        </p>
                        <div class="d-flex" style="gap: 8px;">
                            <a href="{{ route('modules.show', $module) }}"
                               class="btn"
                               style="background: #f4f6fb; color: #6b7280; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 20px; border: 1px solid #e3e6f0; transition: all 0.2s;"
                               onmouseover="this.style.background='#e3e6f0';" onmouseout="this.style.background='#f4f6fb';">
                                <i class="mdi mdi-close mr-1"></i> Batal
                            </a>
                            <button type="submit"
                                    style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 22px; border: none; box-shadow: 0 4px 12px rgba(78,115,223,0.3); cursor: pointer;"
                                    onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                                <i class="mdi mdi-content-save-outline mr-1"></i> Buat Materi
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

    {{-- ===== SIDEBAR ===== --}}
    <div class="col-md-4 mb-4">

        {{-- Statistik Modul --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e0f7fa; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-chart-bar" style="font-size: 18px; color: #17a2b8;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Statistik Modul</h5>
                </div>
                <div class="p-4">
                    @foreach([
                        ['label'=>'Materi',   'val'=> $module->lessons->count(), 'c'=>'#4e73df'],
                        ['label'=>'Urutan',   'val'=> $module->order,            'c'=>'#17a2b8'],
                        ['label'=>'Dibuat',   'val'=> $module->created_at->format('d M Y'), 'c'=>'#1cc88a'],
                    ] as $s)
                    <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #f0f0f3;">
                        <span class="text-muted" style="font-size: 13px;">{{ $s['label'] }}</span>
                        <span style="font-size: 13.5px; font-weight: 700; color: {{ $s['c'] }};">{{ $s['val'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Informasi Mata Pelajaran --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #fff3e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-library-outline" style="font-size: 18px; color: #f6c23e;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Informasi Mata Pelajaran</h5>
                </div>
                <div class="p-4">
                    <h6 class="font-weight-bold text-dark mb-1">{{ $module->course->title }}</h6>
                    <p class="text-muted mb-3" style="font-size: 12.5px;">{{ ucfirst($module->course->level) }} level</p>
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
                            ['label'=>'Modul',        'val'=> $module->course->modules->count()],
                            ['label'=>'Total Materi', 'val'=> $module->course->lessons_count],
                            ['label'=>'Durasi',       'val'=> $module->course->duration_hours],
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

        {{-- Materi yang Ada --}}
        @if($module->lessons->count() > 0)
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e3f9e5; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-format-list-bulleted" style="font-size: 18px; color: #1cc88a;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Materi yang Ada</h5>
                </div>
                <div class="p-4" style="display: flex; flex-direction: column; gap: 8px;">
                    @foreach($module->lessons->take(5) as $lesson)
                    <div style="background: #f8f9fc; border-radius: 8px; padding: 10px 12px; border: 1px solid #eaecf4; display: flex; align-items: center; gap: 10px;">
                        <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 2px 8px; font-size: 11px; font-weight: 700; flex-shrink: 0;">{{ $lesson->order }}</span>
                        <div style="flex: 1; min-width: 0;">
                            <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $lesson->title }}</p>
                            <small class="text-muted">{{ ucfirst($lesson->type) }}</small>
                        </div>
                    </div>
                    @endforeach
                    @if($module->lessons->count() > 5)
                    <p class="text-muted mb-0 text-center" style="font-size: 12px;">
                        + {{ $module->lessons->count() - 5 }} materi lainnya
                    </p>
                    @endif
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

@endsection