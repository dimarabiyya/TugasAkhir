@extends('layouts.skydash')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
            <div class="card-body py-4 px-4">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-8 mb-3 mb-xl-0">
                        <div class="d-flex align-items-center">
                            <div style="background: rgba(255,255,255,0.2); border-radius: 10px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; margin-right: 14px; flex-shrink: 0;">
                                <i class="mdi mdi-file-document-plus-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Buat Ujian Baru</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Isi detail ujian lalu lanjutkan menambah soal</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('exams.index') }}" class="btn btn-light font-weight-bold" style="border-radius: 8px; font-size: 13px;">
                            <i class="mdi mdi-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-8">

        <form action="{{ route('exams.store') }}" method="POST">
            @csrf

            {{-- ===== SECTION 1: Informasi Dasar ===== --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body border-bottom py-3 px-4" style="background: #f8f9fc; border-radius: 12px 12px 0 0;">
                    <div class="d-flex align-items-center">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-information-outline" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">Informasi Dasar</p>
                            <small class="text-muted">Mata pelajaran dan judul ujian</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">

                    {{-- Mata Pelajaran --}}
                    <div class="mb-4">
                        <label style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 6px; display: block;">
                            <i class="mdi mdi-library-outline mr-1"></i> Mata Pelajaran
                        </label>
                        <div style="position: relative;">
                            <select name="course_id" required
                                    style="width: 100%; padding: 10px 36px 10px 14px; border: 1px solid {{ $errors->has('course_id') ? '#e74a3b' : '#d1d3e2' }}; border-radius: 8px; font-size: 13px; color: #3d3d3d; background: #fff; appearance: none; -webkit-appearance: none; outline: none; transition: border-color 0.2s; cursor: pointer;"
                                    onfocus="this.style.borderColor='#4e73df';"
                                    onblur="this.style.borderColor='{{ $errors->has('course_id') ? '#e74a3b' : '#d1d3e2' }}';">
                                <option value="">-- Pilih Mata Pelajaran --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="mdi mdi-chevron-down" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); font-size: 18px; color: #adb5bd; pointer-events: none;"></i>
                        </div>
                        @error('course_id')
                            <p style="font-size: 11px; color: #e74a3b; margin-top: 5px; display: flex; align-items: center; gap: 4px;">
                                <i class="mdi mdi-alert-circle-outline"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Judul Ujian --}}
                    <div class="mb-0">
                        <label style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 6px; display: block;">
                            <i class="mdi mdi-format-title mr-1"></i> Judul Ujian
                        </label>
                        <input type="text" name="title" required
                               value="{{ old('title') }}"
                               placeholder="Contoh: UTS Matematika Semester Ganjil..."
                               style="width: 100%; padding: 10px 14px; border: 1px solid #d1d3e2; border-radius: 8px; font-size: 13px; color: #3d3d3d; outline: none; transition: border-color 0.2s;"
                               onfocus="this.style.borderColor='#4e73df';"
                               onblur="this.style.borderColor='#d1d3e2';">
                    </div>

                </div>
            </div>

            {{-- ===== SECTION 2: Pilih Kelas ===== --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body border-bottom py-3 px-4" style="background: #f8f9fc; border-radius: 12px 12px 0 0;">
                    <div class="d-flex align-items-center">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-google-classroom" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">Pilih Kelas</p>
                            <small class="text-muted">Kelas yang akan mengikuti ujian ini</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">

                    @error('classroom_ids')
                        <div style="background: #fde8e8; border: 1px solid #f5c6cb; border-radius: 8px; padding: 10px 14px; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                            <i class="mdi mdi-alert-circle-outline" style="color: #e74a3b; font-size: 16px;"></i>
                            <span style="font-size: 12px; color: #e74a3b;">{{ $message }}</span>
                        </div>
                    @enderror

                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px;">
                        @foreach($classrooms as $classroom)
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 10px 12px; border: 1px solid #eaecf4; border-radius: 10px; background: #f8f9fc; transition: all 0.2s;"
                               onmouseover="this.style.background='#e8f0fe';this.style.borderColor='#c5d5f8';"
                               onmouseout="this.style.background='#f8f9fc';this.style.borderColor='#eaecf4';">
                            <input type="checkbox" name="classroom_ids[]"
                                   value="{{ $classroom->id }}"
                                   id="class-{{ $classroom->id }}"
                                   {{ in_array($classroom->id, old('classroom_ids', [])) ? 'checked' : '' }}
                                   style="width: 16px; height: 16px; accent-color: #4e73df; cursor: pointer; flex-shrink: 0;">
                            <div class="d-flex align-items-center" style="gap: 8px;">
                                <div style="background: #e8f0fe; border-radius: 6px; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="mdi mdi-door-open" style="font-size: 15px; color: #4e73df;"></i>
                                </div>
                                <span style="font-size: 13px; color: #3d3d3d; font-weight: 500;">{{ $classroom->name }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-4">
             {{-- ===== SECTION 3: Jadwal & Durasi ===== --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body border-bottom py-3 px-4" style="background: #f8f9fc; border-radius: 12px 12px 0 0;">
                    <div class="d-flex align-items-center">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-calendar-clock-outline" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">Jadwal & Durasi</p>
                            <small class="text-muted">Atur waktu pelaksanaan ujian</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">

                    {{-- Waktu Mulai & Selesai --}}
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 6px; display: block;">
                                <i class="mdi mdi-calendar-arrow-right mr-1"></i> Waktu Mulai
                            </label>
                            <input type="datetime-local" name="start_time" required
                                   value="{{ old('start_time') }}"
                                   style="width: 100%; padding: 10px 14px; border: 1px solid #d1d3e2; border-radius: 8px; font-size: 13px; color: #3d3d3d; outline: none; transition: border-color 0.2s;"
                                   onfocus="this.style.borderColor='#4e73df';"
                                   onblur="this.style.borderColor='#d1d3e2';">
                        </div>
                        <div class="col-md-6">
                            <label style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 6px; display: block;">
                                <i class="mdi mdi-calendar-arrow-left mr-1"></i> Batas Akses (Selesai)
                            </label>
                            <input type="datetime-local" name="end_time" required
                                   value="{{ old('end_time') }}"
                                   style="width: 100%; padding: 10px 14px; border: 1px solid #d1d3e2; border-radius: 8px; font-size: 13px; color: #3d3d3d; outline: none; transition: border-color 0.2s;"
                                   onfocus="this.style.borderColor='#4e73df';"
                                   onblur="this.style.borderColor='#d1d3e2';">
                        </div>
                    </div>

                    {{-- Durasi --}}
                    <div class="mb-0">
                        <label style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 6px; display: block;">
                            <i class="mdi mdi-timer-outline mr-1"></i> Durasi Pengerjaan (Menit)
                        </label>
                        <div style="position: relative; max-width: 200px;">
                            <input type="number" name="duration" required min="1"
                                   value="{{ old('duration') }}"
                                   placeholder="Contoh: 90"
                                   style="width: 100%; padding: 10px 50px 10px 14px; border: 1px solid #d1d3e2; border-radius: 8px; font-size: 13px; color: #3d3d3d; outline: none; transition: border-color 0.2s;"
                                   onfocus="this.style.borderColor='#4e73df';"
                                   onblur="this.style.borderColor='#d1d3e2';">
                            <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); font-size: 11px; color: #adb5bd; font-weight: 600;">menit</span>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ===== SECTION 4: Instruksi ===== --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body border-bottom py-3 px-4" style="background: #f8f9fc; border-radius: 12px 12px 0 0;">
                    <div class="d-flex align-items-center">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-text-box-outline" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">Instruksi Ujian <span style="background: #f0f0f3; color: #858796; border-radius: 20px; padding: 2px 8px; font-size: 10px; font-weight: 600; margin-left: 4px;">Opsional</span></p>
                            <small class="text-muted">Petunjuk yang ditampilkan kepada siswa sebelum ujian dimulai</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <textarea name="instructions" rows="4"
                              placeholder="Contoh: Bacalah setiap soal dengan teliti. Jawab semua pertanyaan. Tidak diperbolehkan membuka buku..."
                              style="width: 100%; padding: 10px 14px; border: 1px solid #d1d3e2; border-radius: 8px; font-size: 13px; color: #3d3d3d; resize: vertical; outline: none; transition: border-color 0.2s; font-family: inherit;"
                              onfocus="this.style.borderColor='#4e73df';"
                              onblur="this.style.borderColor='#d1d3e2';">{{ old('instructions') }}</textarea>
                </div>
            </div>
        </div>

            {{-- ===== ACTION BAR ===== --}}
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body py-3 px-4 d-flex align-items-center justify-content-between" style="gap: 10px;">
                    <p class="mb-0 text-muted" style="font-size: 12px;">
                        <i class="mdi mdi-information-outline mr-1"></i>
                        Setelah disimpan, kamu akan diarahkan untuk menambah soal.
                    </p>
                    <div class="d-flex" style="gap: 8px;">
                        <a href="{{ route('exams.index') }}"
                           style="padding: 10px 18px; border-radius: 8px; border: 1px solid #d1d3e2; background: #fff; color: #858796; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; white-space: nowrap;"
                           onmouseover="this.style.background='#f0f0f3';"
                           onmouseout="this.style.background='#fff';">
                            <i class="mdi mdi-close" style="font-size: 15px;"></i> Batal
                        </a>
                        <button type="submit"
                                style="padding: 10px 20px; border-radius: 8px; border: none; background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: opacity 0.2s; white-space: nowrap; box-shadow: 0 4px 12px rgba(78,115,223,0.35);"
                                onmouseover="this.style.opacity='0.9';"
                                onmouseout="this.style.opacity='1';">
                            <i class="mdi mdi-content-save-outline" style="font-size: 16px;"></i> Simpan & Buat Soal
                        </button>
                    </div>
                </div>
            </div>

        </form>
</div>

@endsection