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
                                <i class="mdi mdi-file-plus-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Buat Kuis Baru</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">
                                    Untuk: <strong class="text-white">{{ $lesson->title }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('quizzes.index') }}"
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

    {{-- ===== FORM ===== --}}
    <div class="col-lg-8 col-md-12 mb-4">
        <form id="quizForm" action="{{ route('quizzes.store', $lesson) }}" method="POST"
              onsubmit="event.preventDefault(); handleFormSubmit(this);">
            @csrf

            {{-- Hidden defaults --}}
            <input type="hidden" name="allow_multiple_attempts"   value="1">
            <input type="hidden" name="show_results_immediately"  value="1">
            <input type="hidden" name="allow_navigation"          value="1">
            <input type="hidden" name="shuffle_questions"         value="0">
            <input type="hidden" name="shuffle_answers"           value="0">
            <input type="hidden" name="show_correct_answers"      value="0">
            <input type="hidden" name="negative_marking"          value="0">

            {{-- Section: Informasi Dasar --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-information-outline" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Informasi Dasar</h5>
                            <small class="text-muted">Judul dan deskripsi kuis</small>
                        </div>
                    </div>
                    <div class="p-4">

                        {{-- Judul --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-format-title mr-1 text-muted"></i> Judul Kuis <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="title" id="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}"
                                   placeholder="Masukkan judul kuis"
                                   required
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                   onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                   onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="form-group mb-0">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-text mr-1 text-muted"></i> Deskripsi
                                <span class="text-muted" style="font-weight: 400;">(opsional)</span>
                            </label>
                            <textarea name="description" id="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      rows="4"
                                      placeholder="Berikan deskripsi singkat tentang apa yang dicakup kuis ini..."
                                      style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; resize: vertical;"
                                      onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                      onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                    </div>
                </div>
            </div>

            {{-- Section: Pengaturan Penilaian --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                        <div style="background: #e3f9e5; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-cog-outline" style="font-size: 18px; color: #1cc88a;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Pengaturan Kuis</h5>
                            <small class="text-muted">Skor kelulusan, batas waktu, dan status</small>
                        </div>
                    </div>
                    <div class="p-4">

                        <div class="row">
                            {{-- Skor Kelulusan --}}
                            <div class="col-md-4 mb-3">
                                <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                    <i class="mdi mdi-check-circle-outline mr-1 text-muted"></i> Skor Kelulusan (%) <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="passing_score" id="passing_score"
                                       class="form-control @error('passing_score') is-invalid @enderror"
                                       value="{{ old('passing_score', 60) }}"
                                       min="0" max="100" required
                                       style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                       onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                       onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                                @error('passing_score') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted" style="font-size: 11px;">Minimal 0–100%</small>
                            </div>

                            {{-- Batas Waktu --}}
                            <div class="col-md-4 mb-3">
                                <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                    <i class="mdi mdi-clock-outline mr-1 text-muted"></i> Batas Waktu (Menit)
                                </label>
                                <input type="number" name="time_limit_minutes" id="time_limit_minutes"
                                       class="form-control @error('time_limit_minutes') is-invalid @enderror"
                                       value="{{ old('time_limit_minutes') }}"
                                       min="1"
                                       placeholder="Kosongkan = ∞"
                                       style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                       onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                       onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                                @error('time_limit_minutes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted" style="font-size: 11px;">Kosongkan jika tanpa batas</small>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-4 mb-3">
                                <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                    <i class="mdi mdi-toggle-switch-outline mr-1 text-muted"></i> Status <span class="text-danger">*</span>
                                </label>
                                <div style="position: relative;">
                                    <select name="status" id="status"
                                            class="form-control @error('status') is-invalid @enderror"
                                            required
                                            style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px; appearance: none; -webkit-appearance: none; padding-right: 36px; cursor: pointer;"
                                            onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                            onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                                        <option value="draft"     {{ old('status', 'draft') == 'draft'     ? 'selected' : '' }}>Draf</option>
                                        <option value="published" {{ old('status') == 'published'          ? 'selected' : '' }}>Dipublikasikan</option>
                                    </select>
                                    <div style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                                        <i class="mdi mdi-chevron-down" style="font-size: 18px; color: #adb5bd;"></i>
                                    </div>
                                </div>
                                @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                <small class="text-muted" style="font-size: 11px;">Draf tidak terlihat siswa</small>
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
                            Setelah membuat kuis, tambahkan pertanyaan dari halaman kuis
                        </p>
                        <div class="d-flex" style="gap: 8px;">
                            <a href="{{ route('quizzes.index') }}"
                               class="btn"
                               style="background: #f4f6fb; color: #6b7280; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 20px; border: 1px solid #e3e6f0; transition: all 0.2s;"
                               onmouseover="this.style.background='#e3e6f0';" onmouseout="this.style.background='#f4f6fb';">
                                <i class="mdi mdi-close mr-1"></i> Batal
                            </a>
                            <button type="submit"
                                    style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 22px; border: none; box-shadow: 0 4px 12px rgba(78,115,223,0.3); cursor: pointer;"
                                    onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                                <i class="mdi mdi-content-save-outline mr-1"></i> Buat Kuis
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

    {{-- ===== SIDEBAR ===== --}}
    <div class="col-lg-4 col-md-12 mb-4">

        {{-- Info Kursus --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-book-outline" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Informasi Kursus</h5>
                </div>
                <div class="p-4">
                    @foreach([
                        ['label' => 'Mata Pelajaran', 'icon' => 'mdi-library-outline',                    'value' => $lesson->module->course->title ?? 'N/A'],
                        ['label' => 'Modul',           'icon' => 'mdi-folder-outline',                    'value' => $lesson->module->title ?? 'N/A'],
                        ['label' => 'Materi',          'icon' => 'mdi-book-open-page-variant-outline',    'value' => $lesson->title],
                    ] as $info)
                    <div class="py-2" style="border-bottom: 1px solid #f0f0f3;">
                        <p class="text-muted mb-1" style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px;">
                            <i class="mdi {{ $info['icon'] }} mr-1"></i>{{ $info['label'] }}
                        </p>
                        <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px;">{{ $info['value'] }}</p>
                    </div>
                    @endforeach
                    <div class="pt-2">
                        <p class="text-muted mb-1" style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px;">
                            <i class="mdi mdi-tag-outline mr-1"></i>Tipe Materi
                        </p>
                        <span style="background: #e0f7fa; color: #17a2b8; border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 600;">
                            {{ ucfirst($lesson->type ?? 'N/A') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tips --}}
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #fff3e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-lightbulb-outline" style="font-size: 18px; color: #f6c23e;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Tips Cepat</h5>
                </div>
                <div class="p-4">
                    @foreach([
                        'Tambahkan pertanyaan setelah membuat kuis.',
                        'Tetapkan skor kelulusan yang sesuai dengan tingkat kesulitan.',
                        'Batas waktu membantu penilaian yang lebih adil.',
                        'Simpan sebagai draf sebelum menerbitkan untuk siswa.',
                    ] as $tip)
                    <div class="d-flex align-items-start mb-3" style="gap: 8px;">
                        <div style="background: #e3f9e5; border-radius: 50%; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px;">
                            <i class="mdi mdi-check" style="font-size: 12px; color: #1cc88a;"></i>
                        </div>
                        <small class="text-muted" style="font-size: 12.5px; line-height: 1.5;">{{ $tip }}</small>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function handleFormSubmit(form) {
        Swal.fire({
            title: 'Simpan Kuis Ini?',
            text: 'Pastikan semua informasi sudah benar.',
            icon: 'question',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonColor: '#4e73df',
            denyButtonColor: '#858796',
            confirmButtonText: '<i class="mdi mdi-content-save-outline mr-1"></i> Simpan',
            denyButtonText: 'Jangan Simpan',
            customClass: { popup: 'rounded' }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            } else if (result.isDenied) {
                Swal.fire({ icon: 'info', title: 'Perubahan tidak disimpan', showConfirmButton: false, timer: 1400 });
            }
        });
    }
</script>
@endpush

@endsection