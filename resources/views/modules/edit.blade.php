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
                                <i class="mdi mdi-folder-edit-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Edit Modul</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">
                                    <strong class="text-white">{{ $module->title }}</strong> · {{ $module->course->title }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end flex-wrap" style="gap: 8px;">
                        <a href="{{ route('modules.show', $module) }}"
                           class="btn font-weight-bold"
                           style="background: rgba(255,255,255,0.15); color: #fff; border-radius: 8px; font-size: 13px; border: 1px solid rgba(255,255,255,0.3);">
                            <i class="mdi mdi-eye mr-1"></i> Lihat
                        </a>
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

{{-- Context banner --}}
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
                        <p class="mb-0 text-muted" style="font-size: 12.5px;">
                            Modul {{ $module->order }} · {{ $module->lessons->count() }} materi · {{ $module->course->title }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    {{-- ===== FORM ===== --}}
    <div class="col-md-8 mb-4">
        <form action="{{ route('modules.update', $module) }}" method="POST">
            @csrf @method('PUT')

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
                                   value="{{ old('title', $module->title) }}"
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
                                      onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">{{ old('description', $module->description) }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Urutan --}}
                        <div class="form-group mb-0">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-sort-numeric-ascending mr-1 text-muted"></i> Urutan <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="order"
                                   class="form-control @error('order') is-invalid @enderror"
                                   value="{{ old('order', $module->order) }}"
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
                            Perubahan akan diterapkan langsung setelah disimpan
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
                                <i class="mdi mdi-content-save-outline mr-1"></i> Perbarui Modul
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
                        ['label'=>'Materi',      'val'=> $module->lessons->count(),          'c'=>'#4e73df'],
                        ['label'=>'Dibuat',      'val'=> $module->created_at->format('d M Y'),'c'=>'#17a2b8'],
                        ['label'=>'Diperbarui',  'val'=> $module->updated_at->format('d M Y'),'c'=>'#1cc88a'],
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
                    <p class="text-muted mb-3" style="font-size: 12.5px; text-transform: capitalize;">{{ $module->course->level }} level</p>
                    @if($module->course->description)
                    <p class="text-muted mb-3" style="font-size: 13px;">{{ Str::limit($module->course->description, 90) }}</p>
                    @endif
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

        {{-- Zona Bahaya --}}
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border: 2px solid #fde8e8 !important;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #fde8e8;">
                    <div style="background: #fde8e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-alert-outline" style="font-size: 18px; color: #e74a3b;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold" style="color: #e74a3b;">Zona Bahaya</h5>
                </div>
                <div class="p-4">
                    <p class="text-muted mb-3" style="font-size: 12.5px;">
                        Menghapus modul ini bersifat permanen beserta semua materinya.
                    </p>
                    @if($module->lessons->count() > 0)
                    <div class="p-3 mb-3" style="background: #fff3e8; border-radius: 8px; border: 1px solid #fde68a;">
                        <p class="mb-0" style="font-size: 12.5px; color: #b8860b;">
                            <i class="mdi mdi-alert-circle-outline mr-1"></i>
                            <strong>Peringatan:</strong> Modul ini berisi {{ $module->lessons->count() }} materi. Hapus semua materi terlebih dahulu.
                        </p>
                    </div>
                    @endif
                    <form action="{{ route('modules.destroy', $module) }}" method="POST" class="m-0"
                          onsubmit="event.preventDefault(); confirmDelete(event, 'Modul ini akan dihapus permanen beserta semua materinya.');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-block"
                                {{ $module->lessons->count() > 0 ? 'disabled' : '' }}
                                style="background: {{ $module->lessons->count() > 0 ? '#f4f6fb' : '#fde8e8' }}; color: {{ $module->lessons->count() > 0 ? '#adb5bd' : '#e74a3b' }}; border-radius: 8px; font-weight: 600; font-size: 13px; border: none; padding: 10px; width: 100%; {{ $module->lessons->count() > 0 ? 'cursor:not-allowed;' : 'cursor:pointer;' }} transition: all 0.2s;"
                                onmouseover="if(!this.disabled){this.style.background='#e74a3b';this.style.color='#fff';}"
                                onmouseout="if(!this.disabled){this.style.background='#fde8e8';this.style.color='#e74a3b';}">
                            <i class="mdi mdi-delete mr-1"></i> Hapus Modul
                        </button>
                    </form>
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