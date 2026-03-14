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
                                <i class="mdi mdi-clipboard-edit-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Edit Tugas</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Perbarui <strong class="text-white">{{ $task->title }}</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end" style="gap: 8px;">
                        <a href="{{ route('tasks.show', $task->id) }}"
                           class="btn font-weight-bold"
                           style="background: rgba(255,255,255,0.15); color: #fff; border-radius: 8px; font-size: 13px; border: 1px solid rgba(255,255,255,0.3);">
                            <i class="mdi mdi-eye mr-1"></i> Lihat
                        </a>
                        <a href="{{ route('tasks.index') }}"
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

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">
        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Section: Detail Tugas --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-text-box-outline" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Detail Tugas</h5>
                            <small class="text-muted">Judul, instruksi, dan status tugas</small>
                        </div>
                    </div>
                    <div class="p-4">

                        {{-- Judul --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-format-title mr-1 text-muted"></i> Judul Tugas <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $task->title) }}" required
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                   onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                   onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Instruksi --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-text mr-1 text-muted"></i> Instruksi
                            </label>
                            <textarea name="instructions" class="form-control @error('instructions') is-invalid @enderror"
                                      rows="6"
                                      placeholder="Tulis instruksi pengerjaan tugas di sini..."
                                      style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; resize: vertical;"
                                      onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                      onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">{{ old('instructions', $task->instructions) }}</textarea>
                            @error('instructions') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Status --}}
                        <div class="form-group mb-0">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-toggle-switch-outline mr-1 text-muted"></i> Status Publikasi
                            </label>
                            <div class="d-flex" style="gap: 10px;">
                                @foreach(['draft' => ['Draf', '#fff3e8', '#f6c23e', 'mdi-pencil'], 'published' => ['Dipublikasikan', '#e3f9e5', '#1cc88a', 'mdi-check-circle']] as $val => $cfg)
                                <label style="flex: 1; cursor: pointer; margin: 0;">
                                    <input type="radio" name="status" value="{{ $val }}"
                                           {{ old('status', $task->status) == $val ? 'checked' : '' }}
                                           class="d-none status-radio" onchange="updateStatusStyle()">
                                    <div class="status-option-{{ $val }} d-flex align-items-center p-3"
                                         style="border-radius: 10px; border: 2px solid {{ old('status', $task->status) == $val ? $cfg[2] : '#e3e6f0' }}; background: {{ old('status', $task->status) == $val ? $cfg[1] : '#f8f9fc' }}; transition: all 0.2s;">
                                        <i class="mdi {{ $cfg[3] }}" style="font-size: 18px; color: {{ $cfg[2] }}; margin-right: 8px;"></i>
                                        <span style="font-size: 13px; font-weight: 600; color: {{ old('status', $task->status) == $val ? $cfg[2] : '#858796' }};">{{ $cfg[0] }}</span>
                                    </div>
                                </label>
                                @endforeach
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
                            Perubahan akan diterapkan langsung setelah disimpan
                        </p>
                        <div class="d-flex" style="gap: 8px;">
                            <a href="{{ route('tasks.index') }}"
                               class="btn"
                               style="background: #f4f6fb; color: #6b7280; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 20px; border: 1px solid #e3e6f0; transition: all 0.2s;"
                               onmouseover="this.style.background='#e3e6f0';" onmouseout="this.style.background='#f4f6fb';">
                                <i class="mdi mdi-close mr-1"></i> Batal
                            </a>
                            <button type="submit"
                                    style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 22px; border: none; box-shadow: 0 4px 12px rgba(78,115,223,0.3); cursor: pointer;"
                                    onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                                <i class="mdi mdi-content-save-outline mr-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>
    function updateStatusStyle() {
        const radios = document.querySelectorAll('.status-radio');
        const config = {
            draft:     { bg: '#fff3e8', border: '#f6c23e', text: '#f6c23e' },
            published: { bg: '#e3f9e5', border: '#1cc88a', text: '#1cc88a' }
        };
        const neutral = { bg: '#f8f9fc', border: '#e3e6f0', text: '#858796' };

        radios.forEach(radio => {
            const div = document.querySelector('.status-option-' + radio.value);
            if (!div) return;
            const c = radio.checked ? config[radio.value] : neutral;
            div.style.background  = c.bg;
            div.style.borderColor = c.border;
            div.querySelector('span').style.color = c.text;
        });
    }
</script>
@endpush

@endsection