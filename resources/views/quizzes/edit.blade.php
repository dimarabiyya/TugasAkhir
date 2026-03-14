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
                                <i class="mdi mdi-pencil-box-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Edit Kuis</h4>
                                <p class="text-white-50 mb-0" style="font-size: 14px;">Perbarui informasi dan pengaturan kuis</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ $quiz->url }}" class="btn btn-light font-weight-bold" style="border-radius: 8px; font-size: 13px;">
                            <i class="mdi mdi-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== FORM ===== --}}
<form action="{{ route('quizzes.update', $quiz) }}" method="POST">
@csrf
@method('PUT')

<div class="row">
    <div class="col-md-12">

        {{-- ===== SECTION 1: Informasi Dasar ===== --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-information-outline" style="font-size: 20px; color: #4e73df;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Informasi Dasar</h5>
                        <small class="text-muted">Judul, deskripsi, dan instruksi kuis</small>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="title" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                        <i class="mdi mdi-format-title mr-1 text-muted"></i> Judul Kuis <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           class="form-control @error('title') is-invalid @enderror"
                           id="title" name="title"
                           value="{{ old('title', $quiz->title) }}"
                           placeholder="Masukkan judul kuis"
                           required
                           style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2;">
                    @error('title')
                        <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="description" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                        <i class="mdi mdi-text-box-outline mr-1 text-muted"></i> Deskripsi
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="description" name="description" rows="3"
                              placeholder="Masukkan deskripsi kuis (opsional)"
                              style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2; resize: vertical;">{{ old('description', $quiz->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <label for="instructions" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                        <i class="mdi mdi-clipboard-text-outline mr-1 text-muted"></i> Instruksi
                    </label>
                    <textarea class="form-control @error('instructions') is-invalid @enderror"
                              id="instructions" name="instructions" rows="3"
                              placeholder="Instruksi untuk siswa yang mengikuti kuis ini"
                              style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2; resize: vertical;">{{ old('instructions', $quiz->instructions) }}</textarea>
                    @error('instructions')
                        <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- ===== SECTION 2: Pengaturan Penilaian ===== --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div style="background: #e3f9e5; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-target" style="font-size: 20px; color: #1cc88a;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Pengaturan Penilaian</h5>
                        <small class="text-muted">Skor, waktu, status, dan jadwal kuis</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-4">
                            <label for="passing_score" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                                <i class="mdi mdi-percent mr-1 text-muted"></i> Skor Kelulusan (%) <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                   class="form-control @error('passing_score') is-invalid @enderror"
                                   id="passing_score" name="passing_score"
                                   value="{{ old('passing_score', $quiz->passing_score) }}"
                                   min="0" max="100" required
                                   style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2;">
                            @error('passing_score')
                                <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-4">
                            <label for="time_limit_minutes" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                                <i class="mdi mdi-clock-outline mr-1 text-muted"></i> Batas Waktu (Menit)
                            </label>
                            <input type="number"
                                   class="form-control @error('time_limit_minutes') is-invalid @enderror"
                                   id="time_limit_minutes" name="time_limit_minutes"
                                   value="{{ old('time_limit_minutes', $quiz->time_limit_minutes) }}"
                                   min="1" placeholder="Tanpa batas"
                                   style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2;">
                            @error('time_limit_minutes')
                                <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-4">
                            <label for="status" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                                <i class="mdi mdi-toggle-switch-outline mr-1 text-muted"></i> Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-control @error('status') is-invalid @enderror"
                                    id="status" name="status" required
                                    style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2;">
                                <option value="draft"     {{ old('status', $quiz->status) == 'draft'     ? 'selected' : '' }}>📝 Draf</option>
                                <option value="published" {{ old('status', $quiz->status) == 'published' ? 'selected' : '' }}>✅ Dipublikasikan</option>
                                <option value="archived"  {{ old('status', $quiz->status) == 'archived'  ? 'selected' : '' }}>📦 Diarsipkan</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label for="start_date" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                                <i class="mdi mdi-calendar-start mr-1 text-muted"></i> Tanggal Mulai
                            </label>
                            <input type="datetime-local"
                                   class="form-control @error('start_date') is-invalid @enderror"
                                   id="start_date" name="start_date"
                                   value="{{ old('start_date', $quiz->start_date ? $quiz->start_date->format('Y-m-d\TH:i') : '') }}"
                                   style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2;">
                            @error('start_date')
                                <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label for="end_date" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                                <i class="mdi mdi-calendar-end mr-1 text-muted"></i> Tanggal Selesai
                            </label>
                            <input type="datetime-local"
                                   class="form-control @error('end_date') is-invalid @enderror"
                                   id="end_date" name="end_date"
                                   value="{{ old('end_date', $quiz->end_date ? $quiz->end_date->format('Y-m-d\TH:i') : '') }}"
                                   style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2;">
                            @error('end_date')
                                <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== SECTION 3: Pengaturan Upaya ===== --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div style="background: #e0f7fa; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-refresh" style="font-size: 20px; color: #17a2b8;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Pengaturan Upaya</h5>
                        <small class="text-muted">Izinkan pengulangan dan batas percobaan</small>
                    </div>
                </div>

                {{-- Toggle: Allow Multiple Attempts --}}
                <div class="toggle-card mb-3 p-3" style="background: #f8f9fc; border-radius: 10px; border: 1px solid #e3e6f0;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-repeat mr-3" style="font-size: 22px; color: #17a2b8;"></i>
                            <div>
                                <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">Izinkan Beberapa Upaya</p>
                                <small class="text-muted">Siswa dapat mengerjakan kuis lebih dari satu kali</small>
                            </div>
                        </div>
                        <div class="custom-control custom-switch">
                            <input class="custom-control-input" type="checkbox"
                                   name="allow_multiple_attempts" id="allow_multiple_attempts" value="1"
                                   {{ old('allow_multiple_attempts', $quiz->allow_multiple_attempts ?? true) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="allow_multiple_attempts"></label>
                        </div>
                    </div>
                </div>

                <div id="max_attempts_container" style="{{ old('allow_multiple_attempts', $quiz->allow_multiple_attempts ?? true) ? '' : 'display:none;' }}">
                    <div class="form-group mb-0 mt-3">
                        <label for="max_attempts" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                            <i class="mdi mdi-counter mr-1 text-muted"></i> Maksimum Upaya
                        </label>
                        <input type="number"
                               class="form-control @error('max_attempts') is-invalid @enderror"
                               id="max_attempts" name="max_attempts"
                               value="{{ old('max_attempts', $quiz->max_attempts) }}"
                               min="1" placeholder="Tidak terbatas"
                               style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2; max-width: 280px;">
                        @error('max_attempts')
                            <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                        @enderror
                        <small class="text-muted mt-1 d-block"><i class="mdi mdi-information-outline mr-1"></i>Kosongkan untuk upaya tidak terbatas</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== SECTION 4: Pengaturan Tampilan ===== --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div style="background: #fff3cd; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-monitor-dashboard" style="font-size: 20px; color: #f6c23e;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Pengaturan Tampilan</h5>
                        <small class="text-muted">Jumlah soal, urutan, dan navigasi</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label for="questions_per_page" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                                <i class="mdi mdi-file-multiple-outline mr-1 text-muted"></i> Pertanyaan per Halaman
                            </label>
                            <input type="number"
                                   class="form-control @error('questions_per_page') is-invalid @enderror"
                                   id="questions_per_page" name="questions_per_page"
                                   value="{{ old('questions_per_page', $quiz->questions_per_page ?? 10) }}"
                                   min="1"
                                   style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2;">
                            @error('questions_per_page')
                                <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label for="random_question_count" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                                <i class="mdi mdi-dice-multiple-outline mr-1 text-muted"></i> Jumlah Soal Acak
                            </label>
                            <input type="number"
                                   class="form-control @error('random_question_count') is-invalid @enderror"
                                   id="random_question_count" name="random_question_count"
                                   value="{{ old('random_question_count', $quiz->random_question_count) }}"
                                   min="1" placeholder="Gunakan semua soal"
                                   style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2;">
                            @error('random_question_count')
                                <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                            @enderror
                            <small class="text-muted mt-1 d-block"><i class="mdi mdi-information-outline mr-1"></i>Pilih sejumlah soal acak per percobaan</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        {{-- Toggle: Acak Soal --}}
                        <div class="toggle-card mb-3 p-3" style="background: #f8f9fc; border-radius: 10px; border: 1px solid #e3e6f0;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-shuffle-variant mr-3" style="font-size: 22px; color: #f6c23e;"></i>
                                    <div>
                                        <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">Acak Urutan Soal</p>
                                        <small class="text-muted">Soal ditampilkan secara acak setiap percobaan</small>
                                    </div>
                                </div>
                                <div class="custom-control custom-switch">
                                    <input class="custom-control-input" type="checkbox"
                                           name="shuffle_questions" id="shuffle_questions" value="1"
                                           {{ old('shuffle_questions', $quiz->shuffle_questions ?? false) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="shuffle_questions"></label>
                                </div>
                            </div>
                        </div>

                        {{-- Toggle: Acak Jawaban --}}
                        <div class="toggle-card mb-3 p-3" style="background: #f8f9fc; border-radius: 10px; border: 1px solid #e3e6f0;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-format-list-bulleted-type mr-3" style="font-size: 22px; color: #f6c23e;"></i>
                                    <div>
                                        <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">Acak Pilihan Jawaban</p>
                                        <small class="text-muted">Opsi jawaban ditampilkan secara acak</small>
                                    </div>
                                </div>
                                <div class="custom-control custom-switch">
                                    <input class="custom-control-input" type="checkbox"
                                           name="shuffle_answers" id="shuffle_answers" value="1"
                                           {{ old('shuffle_answers', $quiz->shuffle_answers ?? false) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="shuffle_answers"></label>
                                </div>
                            </div>
                        </div>

                        {{-- Toggle: Navigasi --}}
                        <div class="toggle-card mb-0 p-3" style="background: #f8f9fc; border-radius: 10px; border: 1px solid #e3e6f0;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-swap-horizontal mr-3" style="font-size: 22px; color: #f6c23e;"></i>
                                    <div>
                                        <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">Izinkan Navigasi Antar Soal</p>
                                        <small class="text-muted">Siswa dapat berpindah soal secara bebas</small>
                                    </div>
                                </div>
                                <div class="custom-control custom-switch">
                                    <input class="custom-control-input" type="checkbox"
                                           name="allow_navigation" id="allow_navigation" value="1"
                                           {{ old('allow_navigation', $quiz->allow_navigation ?? true) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="allow_navigation"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== SECTION 5: Pengaturan Hasil ===== --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div style="background: #fde8e8; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-chart-bar" style="font-size: 20px; color: #e74a3b;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Pengaturan Hasil</h5>
                        <small class="text-muted">Tampilkan skor dan jawaban benar setelah kuis</small>
                    </div>
                </div>

                {{-- Toggle: Show Results Immediately --}}
                <div class="toggle-card mb-3 p-3" style="background: #f8f9fc; border-radius: 10px; border: 1px solid #e3e6f0;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-eye-outline mr-3" style="font-size: 22px; color: #e74a3b;"></i>
                            <div>
                                <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">Tampilkan Hasil Langsung</p>
                                <small class="text-muted">Skor ditampilkan segera setelah kuis selesai</small>
                            </div>
                        </div>
                        <div class="custom-control custom-switch">
                            <input class="custom-control-input" type="checkbox"
                                   name="show_results_immediately" id="show_results_immediately" value="1"
                                   {{ old('show_results_immediately', $quiz->show_results_immediately ?? true) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="show_results_immediately"></label>
                        </div>
                    </div>
                </div>

                {{-- Toggle: Show Correct Answers --}}
                <div class="toggle-card mb-0 p-3" style="background: #f8f9fc; border-radius: 10px; border: 1px solid #e3e6f0;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-check-circle-outline mr-3" style="font-size: 22px; color: #e74a3b;"></i>
                            <div>
                                <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">Tampilkan Jawaban Benar</p>
                                <small class="text-muted">Siswa dapat melihat kunci jawaban setelah selesai</small>
                            </div>
                        </div>
                        <div class="custom-control custom-switch">
                            <input class="custom-control-input" type="checkbox"
                                   name="show_correct_answers" id="show_correct_answers" value="1"
                                   {{ old('show_correct_answers', $quiz->show_correct_answers ?? false) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="show_correct_answers"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== SECTION 6: Penilaian Negatif ===== --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div style="background: #f0f0f3; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-minus-circle-outline" style="font-size: 20px; color: #858796;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Penilaian Negatif</h5>
                        <small class="text-muted">Kurangi poin untuk jawaban yang salah</small>
                    </div>
                </div>

                {{-- Toggle: Enable Negative Marking --}}
                <div class="toggle-card mb-3 p-3" style="background: #f8f9fc; border-radius: 10px; border: 1px solid #e3e6f0;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-alpha-x-circle-outline mr-3" style="font-size: 22px; color: #858796;"></i>
                            <div>
                                <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">Aktifkan Penilaian Negatif</p>
                                <small class="text-muted">Poin dikurangi untuk setiap jawaban salah</small>
                            </div>
                        </div>
                        <div class="custom-control custom-switch">
                            <input class="custom-control-input" type="checkbox"
                                   name="negative_marking" id="negative_marking" value="1"
                                   {{ old('negative_marking', $quiz->negative_marking ?? false) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="negative_marking"></label>
                        </div>
                    </div>
                </div>

                <div id="negative_mark_container" style="{{ old('negative_marking', $quiz->negative_marking ?? false) ? '' : 'display:none;' }}">
                    <div class="form-group mb-0 mt-3">
                        <label for="negative_mark_value" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                            <i class="mdi mdi-numeric mr-1 text-muted"></i> Nilai Pengurangan
                        </label>
                        <input type="number"
                               class="form-control @error('negative_mark_value') is-invalid @enderror"
                               id="negative_mark_value" name="negative_mark_value"
                               value="{{ old('negative_mark_value', $quiz->negative_mark_value ?? 0.25) }}"
                               step="0.01" min="0" max="1"
                               style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2; max-width: 280px;">
                        @error('negative_mark_value')
                            <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                        @enderror
                        <small class="text-muted mt-1 d-block"><i class="mdi mdi-information-outline mr-1"></i>Proporsi poin yang dikurangi (cth: 0.25 = 25%)</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== SECTION 7: Pesan Kustom ===== --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div style="background: #e0f7fa; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-message-text-outline" style="font-size: 20px; color: #17a2b8;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Pesan Kustom</h5>
                        <small class="text-muted">Pesan yang ditampilkan ke siswa setelah kuis</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label for="pass_message" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                                <i class="mdi mdi-emoticon-happy-outline mr-1" style="color: #1cc88a;"></i> Pesan Lulus
                            </label>
                            <textarea class="form-control"
                                      id="pass_message" name="pass_message" rows="3"
                                      placeholder="Selamat! Kamu lulus kuis ini."
                                      style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2; resize: vertical;">{{ old('pass_message', $quiz->pass_message) }}</textarea>
                            <small class="text-muted mt-1 d-block"><i class="mdi mdi-information-outline mr-1"></i>Ditampilkan saat siswa lulus</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label for="fail_message" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                                <i class="mdi mdi-emoticon-sad-outline mr-1" style="color: #e74a3b;"></i> Pesan Tidak Lulus
                            </label>
                            <textarea class="form-control"
                                      id="fail_message" name="fail_message" rows="3"
                                      placeholder="Sayang sekali, kamu belum lulus. Coba lagi!"
                                      style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2; resize: vertical;">{{ old('fail_message', $quiz->fail_message) }}</textarea>
                            <small class="text-muted mt-1 d-block"><i class="mdi mdi-information-outline mr-1"></i>Ditampilkan saat siswa tidak lulus</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== ACTION BUTTONS ===== --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 10px;">
                    <p class="mb-0 text-muted" style="font-size: 13px;">
                        <i class="mdi mdi-information-outline mr-1"></i> Pastikan semua informasi sudah benar sebelum menyimpan.
                    </p>
                    <div class="d-flex" style="gap: 10px;">
                        <a href="{{ route('quizzes.show', $quiz) }}"
                           class="btn btn-outline-secondary"
                           style="border-radius: 8px; padding: 10px 20px; font-size: 14px; font-weight: 600;">
                            <i class="mdi mdi-close mr-1"></i> Batal
                        </a>
                        <button type="submit"
                                class="btn btn-primary"
                                style="border-radius: 8px; padding: 10px 24px; font-size: 14px; font-weight: 600;">
                            <i class="mdi mdi-content-save-outline mr-1"></i> Perbarui Kuis
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</form>

@push('styles')
<style>
    .form-control:focus {
        border-color: #4e73df !important;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15) !important;
    }

    .toggle-card {
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .toggle-card:hover {
        border-color: #b7c2e8 !important;
        box-shadow: 0 2px 8px rgba(78, 115, 223, 0.08);
    }

    .custom-switch .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #4e73df;
        border-color: #4e73df;
    }

    .card {
        transition: box-shadow 0.2s ease;
    }

    .form-label {
        margin-bottom: 6px;
    }

    select.form-control {
        appearance: auto;
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('allow_multiple_attempts').addEventListener('change', function () {
        document.getElementById('max_attempts_container').style.display = this.checked ? '' : 'none';
    });

    document.getElementById('negative_marking').addEventListener('change', function () {
        document.getElementById('negative_mark_container').style.display = this.checked ? '' : 'none';
    });
</script>
@endpush

@endsection