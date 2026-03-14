@extends('layouts.skydash')

@php use Illuminate\Support\Facades\Storage; @endphp

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
                                <i class="mdi mdi-google-classroom text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Edit Kelas</h4>
                                <p class="text-white-50 mb-0" style="font-size: 14px;">
                                    Perbarui informasi, instruktur, dan daftar siswa kelas
                                    <strong class="text-white">{{ $classroom->name }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('classrooms.index') }}" class="btn btn-light font-weight-bold" style="border-radius: 8px; font-size: 13px;">
                            <i class="mdi mdi-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== FORM ===== --}}
<form action="{{ route('classrooms.update', $classroom->id) }}" method="POST">
@csrf
@method('PUT')

<div class="row">
    <div class="col-md-12">

        {{-- ===== SECTION 1: Informasi Kelas ===== --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-information-outline" style="font-size: 20px; color: #4e73df;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Informasi Kelas</h5>
                        <small class="text-muted">Nama dan deskripsi kelas</small>
                    </div>
                </div>

                {{-- Nama Kelas --}}
                <div class="form-group mb-4">
                    <label for="name" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                        <i class="mdi mdi-tag-outline mr-1 text-muted"></i> Nama Kelas <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $classroom->name) }}"
                           placeholder="Contoh: XI RPL 1"
                           required
                           style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2;">
                    @error('name')
                        <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="form-group mb-0">
                    <label for="description" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                        <i class="mdi mdi-text-box-outline mr-1 text-muted"></i> Deskripsi
                    </label>
                    <textarea name="description"
                              id="description"
                              class="form-control @error('description') is-invalid @enderror"
                              rows="3"
                              placeholder="Deskripsi singkat tentang kelas ini (opsional)"
                              style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2; resize: vertical;">{{ old('description', $classroom->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- ===== SECTION 2: Instruktur ===== --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div style="background: #e3f9e5; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-account-tie-outline" style="font-size: 20px; color: #1cc88a;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Instruktur (Guru Pengampu)</h5>
                        <small class="text-muted">Pilih guru yang bertanggung jawab atas kelas ini</small>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <label for="instructor_id" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                        <i class="mdi mdi-account-outline mr-1 text-muted"></i> Pilih Guru <span class="text-danger">*</span>
                    </label>
                    <select name="instructor_id"
                            id="instructor_id"
                            class="form-control select2 @error('instructor_id') is-invalid @enderror"
                            style="width: 100%;">
                        <option value="">-- Pilih Guru --</option>
                        @foreach($instructors as $instructor)
                            <option value="{{ $instructor->id }}"
                                {{ old('instructor_id', $classroom->instructor_id) == $instructor->id ? 'selected' : '' }}>
                                {{ $instructor->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('instructor_id')
                        <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- ===== SECTION 3: Daftar Siswa ===== --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div style="background: #fff3cd; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-account-group-outline" style="font-size: 20px; color: #f6c23e;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Daftar Siswa</h5>
                        <small class="text-muted">Kelola siswa yang terdaftar di kelas ini</small>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <label for="student_ids" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                        <i class="mdi mdi-account-multiple-outline mr-1 text-muted"></i> Pilih Siswa
                    </label>
                    <select name="student_ids[]"
                            id="student_ids"
                            class="form-control select2 @error('student_ids') is-invalid @enderror"
                            multiple="multiple"
                            style="width: 100%;">
                        @foreach($students as $student)
                            <option value="{{ $student->id }}"
                                {{ in_array($student->id, old('student_ids', $currentStudents)) ? 'selected' : '' }}>
                                {{ $student->name }} ({{ $student->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('student_ids')
                        <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted mt-2 d-block">
                        <i class="mdi mdi-information-outline mr-1"></i>Cari dan pilih siswa untuk ditambahkan ke kelas. Bisa memilih lebih dari satu.
                    </small>
                </div>
            </div>
        </div>

        {{-- ===== ACTION BUTTONS ===== --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 10px;">
                    <p class="mb-0 text-muted" style="font-size: 13px;">
                        <i class="mdi mdi-information-outline mr-1"></i> Pastikan nama kelas dan instruktur telah diisi dengan benar.
                    </p>
                    <div class="d-flex" style="gap: 10px;">
                        <a href="{{ route('classrooms.index') }}"
                           class="btn btn-outline-secondary"
                           style="border-radius: 8px; padding: 10px 20px; font-size: 14px; font-weight: 600;">
                            <i class="mdi mdi-close mr-1"></i> Batal
                        </a>
                        <button type="submit"
                                class="btn btn-primary"
                                style="border-radius: 8px; padding: 10px 24px; font-size: 14px; font-weight: 600;">
                            <i class="mdi mdi-content-save-outline mr-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</form>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<style>
    .form-control:focus {
        border-color: #4e73df !important;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15) !important;
    }

    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #d1d3e2 !important;
        border-radius: 8px !important;
        min-height: 42px !important;
        padding: 4px 8px !important;
        font-size: 14px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 32px !important;
        color: #3d3d3d;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #4e73df !important;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15) !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #4e73df !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #4e73df !important;
        border: none !important;
        border-radius: 6px !important;
        color: #fff !important;
        padding: 2px 8px !important;
        font-size: 12px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: rgba(255,255,255,0.7) !important;
        margin-right: 4px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #fff !important;
    }

    .select2-dropdown {
        border: 1px solid #d1d3e2 !important;
        border-radius: 8px !important;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08) !important;
        overflow: hidden;
    }

    .select2-search--dropdown .select2-search__field {
        border-radius: 6px !important;
        border: 1px solid #d1d3e2 !important;
        padding: 6px 10px !important;
        font-size: 13px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#instructor_id').select2({
            placeholder: '-- Pilih Guru --',
            allowClear: true
        });

        $('#student_ids').select2({
            placeholder: 'Cari dan pilih siswa...',
            allowClear: true
        });
    });
</script>
@endpush

@endsection