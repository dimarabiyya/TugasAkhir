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
                                <i class="mdi mdi-clipboard-plus-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Buat Tugas Baru</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Tambahkan tugas baru untuk siswa</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
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
    <div class="col-md-10 col-lg-9">
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            {{-- Section: Pilih Lokasi --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-map-marker-outline" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Lokasi Tugas</h5>
                            <small class="text-muted">Pilih kelas, mata pelajaran, modul, dan materi</small>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="row">

                            {{-- Kelas --}}
                            <div class="col-md-6 mb-3">
                                <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                    <i class="mdi mdi-google-classroom mr-1 text-muted"></i> Kelas <span class="text-danger">*</span>
                                </label>
                                <div style="position: relative;">
                                    <select id="classroom_id" class="form-control" required
                                            style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px; appearance: none; -webkit-appearance: none; padding-right: 36px; cursor: pointer;"
                                            onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                            onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                                        <option value="">— Pilih Kelas —</option>
                                        @foreach($classrooms as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                    <div style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                                        <i class="mdi mdi-chevron-down" style="font-size: 18px; color: #adb5bd;"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Course --}}
                            <div class="col-md-6 mb-3">
                                <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                    <i class="mdi mdi-library-outline mr-1 text-muted"></i> Mata Pelajaran <span class="text-danger">*</span>
                                </label>
                                <div style="position: relative;">
                                    <select id="course_id" class="form-control" disabled required
                                            style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px; appearance: none; -webkit-appearance: none; padding-right: 36px; cursor: not-allowed; background: #f8f9fc;"
                                            onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                            onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                                        <option value="">— Pilih Kelas Terlebih Dahulu —</option>
                                    </select>
                                    <div style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                                        <i class="mdi mdi-chevron-down" style="font-size: 18px; color: #adb5bd;"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Module --}}
                            <div class="col-md-6 mb-3">
                                <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                    <i class="mdi mdi-folder-outline mr-1 text-muted"></i> Modul <span class="text-danger">*</span>
                                </label>
                                <div style="position: relative;">
                                    <select id="module_id" class="form-control" disabled required
                                            style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px; appearance: none; -webkit-appearance: none; padding-right: 36px; cursor: not-allowed; background: #f8f9fc;"
                                            onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                            onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                                        <option value="">— Pilih Mata Pelajaran Terlebih Dahulu —</option>
                                    </select>
                                    <div style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                                        <i class="mdi mdi-chevron-down" style="font-size: 18px; color: #adb5bd;"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Lesson --}}
                            <div class="col-md-6 mb-0">
                                <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                    <i class="mdi mdi-book-open-page-variant-outline mr-1 text-muted"></i> Materi <span class="text-danger">*</span>
                                </label>
                                <div style="position: relative;">
                                    <select name="lesson_id" id="lesson_id" class="form-control" disabled required
                                            style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px; appearance: none; -webkit-appearance: none; padding-right: 36px; cursor: not-allowed; background: #f8f9fc;"
                                            onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                            onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                                        <option value="">— Pilih Modul Terlebih Dahulu —</option>
                                    </select>
                                    <div style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                                        <i class="mdi mdi-chevron-down" style="font-size: 18px; color: #adb5bd;"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Section: Detail Tugas --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                        <div style="background: #e3f9e5; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-text-box-outline" style="font-size: 18px; color: #1cc88a;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Detail Tugas</h5>
                            <small class="text-muted">Judul, instruksi, dan pengaturan tugas</small>
                        </div>
                    </div>
                    <div class="p-4">

                        {{-- Judul --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-format-title mr-1 text-muted"></i> Judul Tugas <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="title" class="form-control"
                                   placeholder="Contoh: Tugas Mandiri Pertemuan 1" required
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                   onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                   onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                        </div>

                        {{-- Instruksi --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-text mr-1 text-muted"></i> Instruksi
                            </label>
                            <textarea name="instructions" class="form-control" rows="5"
                                      placeholder="Tulis instruksi pengerjaan tugas di sini..."
                                      style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; resize: vertical;"
                                      onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                      onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';"></textarea>
                        </div>

                        <div class="row">
                            {{-- Nilai Maksimal --}}
                            <div class="col-md-6 mb-3">
                                <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                    <i class="mdi mdi-counter mr-1 text-muted"></i> Nilai Maksimal
                                </label>
                                <input type="number" name="max_score" class="form-control" value="100" min="0" max="100"
                                       style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                       onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                       onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                            </div>
                            {{-- Deadline --}}
                            <div class="col-md-6 mb-0">
                                <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                    <i class="mdi mdi-calendar-clock-outline mr-1 text-muted"></i> Deadline
                                </label>
                                <input type="datetime-local" name="due_date" class="form-control"
                                       style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                       onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                       onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
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
                            Tugas akan otomatis tersedia setelah disimpan
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
                                <i class="mdi mdi-content-save-outline mr-1"></i> Simpan Tugas
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    function enableSelect(el) {
        $(el).prop('disabled', false).css({ 'cursor': 'pointer', 'background': '#fff' });
    }
    function disableSelect(el, placeholder) {
        $(el).prop('disabled', true).css({ 'cursor': 'not-allowed', 'background': '#f8f9fc' })
            .empty().append('<option value="">' + placeholder + '</option>');
    }

    // KELAS → COURSE
    $('#classroom_id').on('change', function() {
        let id = $(this).val();
        disableSelect('#course_id',  '— Memuat... —');
        disableSelect('#module_id',  '— Pilih Mata Pelajaran Terlebih Dahulu —');
        disableSelect('#lesson_id',  '— Pilih Modul Terlebih Dahulu —');
        if (id) {
            $.get('/get-courses/' + id, function(data) {
                enableSelect('#course_id');
                $('#course_id').empty().append('<option value="">— Pilih Mata Pelajaran —</option>');
                $.each(data, function(k, v) { $('#course_id').append('<option value="'+v.id+'">'+v.title+'</option>'); });
            });
        }
    });

    // COURSE → MODULE
    $('#course_id').on('change', function() {
        let id = $(this).val();
        disableSelect('#module_id', '— Memuat... —');
        disableSelect('#lesson_id', '— Pilih Modul Terlebih Dahulu —');
        if (id) {
            $.get('/get-modules/' + id, function(data) {
                enableSelect('#module_id');
                $('#module_id').empty().append('<option value="">— Pilih Modul —</option>');
                $.each(data, function(k, v) { $('#module_id').append('<option value="'+v.id+'">'+v.title+'</option>'); });
            });
        }
    });

    // MODULE → LESSON
    $('#module_id').on('change', function() {
        let id = $(this).val();
        disableSelect('#lesson_id', '— Memuat... —');
        if (id) {
            $.get('/get-lessons/' + id, function(data) {
                enableSelect('#lesson_id');
                $('#lesson_id').empty().append('<option value="">— Pilih Materi —</option>');
                $.each(data, function(k, v) { $('#lesson_id').append('<option value="'+v.id+'">'+v.title+'</option>'); });
            });
        }
    });

});
</script>
@endpush

@endsection