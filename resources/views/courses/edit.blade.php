{{--
  Digunakan untuk BOTH create.blade.php dan edit.blade.php
  Create : action = route('courses.store'),  tanpa @method('PUT')
  Edit   : action = route('courses.update', $course->id), tambah @method('PUT')
--}}
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
                                <i class="mdi {{ isset($course) ? 'mdi-pencil-box-outline' : 'mdi-plus-box-outline' }} text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">
                                    @isset($course) Edit Mata Pelajaran @else Buat Mata Pelajaran Baru @endisset
                                </h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">
                                    @isset($course) Perbarui informasi mata pelajaran @else Tambahkan mata pelajaran baru ke platform Anda @endisset
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('courses.index') }}"
                           class="btn font-weight-bold"
                           style="background: #fff; color: #4e73df; border-radius: 8px; font-size: 13px; border: none;">
                            <i class="mdi mdi-arrow-left mr-1"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== FORM ===== --}}
<form id="courseForm"
      action="{{ isset($course) ? route('courses.update', $course->id) : route('courses.store') }}"
      method="POST"
      enctype="multipart/form-data"
      onsubmit="event.preventDefault(); handleFormSubmit(this);">
    @csrf
    @isset($course) @method('PUT') @endisset

    <div class="row">

        {{-- ── LEFT: Main info ── --}}
        <div class="col-lg-8 mb-4">

            {{-- Basic Info Card --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4" style="gap: 10px;">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="mdi mdi-information-outline" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <h6 class="font-weight-bold text-dark mb-0" style="font-size: 14px;">Informasi Dasar</h6>
                    </div>

                    {{-- Title --}}
                    <div class="form-group mb-4">
                        <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796;">
                            Judul Mata Pelajaran <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('title') is-invalid @enderror"
                               name="title"
                               value="{{ old('title', $course->title ?? '') }}"
                               placeholder="Masukkan judul mata pelajaran…"
                               required
                               style="border-radius: 8px; font-size: 14px; border: 1px solid #e3e6f0; padding: 10px 14px;">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group mb-0">
                        <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796;">
                            Deskripsi <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  name="description"
                                  rows="6"
                                  placeholder="Jelaskan isi dan tujuan mata pelajaran ini…"
                                  required
                                  style="border-radius: 8px; font-size: 14px; border: 1px solid #e3e6f0; padding: 10px 14px; resize: vertical;">{{ old('description', $course->description ?? '') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Thumbnail Card --}}
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4" style="gap: 10px;">
                        <div style="background: #e0f7fa; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="mdi mdi-image-outline" style="font-size: 18px; color: #17a2b8;"></i>
                        </div>
                        <h6 class="font-weight-bold text-dark mb-0" style="font-size: 14px;">Thumbnail Mata Pelajaran</h6>
                    </div>

                    @isset($course)
                        @if($course->thumbnail)
                        <div class="mb-3">
                            <p style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 8px;">Thumbnail Saat Ini</p>
                            <img src="{{ asset('storage/'.$course->thumbnail) }}"
                                 style="width: 180px; height: 120px; object-fit: cover; border-radius: 10px; border: 1px solid #e3e6f0;"
                                 alt="{{ $course->title }}">
                        </div>
                        @endif
                    @endisset

                    {{-- Upload zone --}}
                    <div id="uploadZone"
                         onclick="document.getElementById('thumbnailInput').click()"
                         style="border: 2px dashed #d1d3e2; border-radius: 10px; padding: 28px; text-align: center; cursor: pointer; transition: all 0.2s; background: #f8f9fc;"
                         onmouseover="this.style.borderColor='#4e73df';this.style.background='#f0f4ff';"
                         onmouseout="this.style.borderColor='#d1d3e2';this.style.background='#f8f9fc';"
                         ondragover="event.preventDefault();this.style.borderColor='#4e73df';this.style.background='#f0f4ff';"
                         ondragleave="this.style.borderColor='#d1d3e2';this.style.background='#f8f9fc';">
                        <input type="file" id="thumbnailInput" name="thumbnail" accept="image/*"
                               onchange="previewImage(this)" style="display: none;">
                        <div style="background: #e8f0fe; border-radius: 50%; width: 52px; height: 52px; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
                            <i class="mdi mdi-cloud-upload-outline" style="font-size: 26px; color: #4e73df;"></i>
                        </div>
                        <p class="font-weight-bold text-dark mb-1" style="font-size: 14px;">Klik atau seret gambar ke sini</p>
                        <p class="text-muted mb-0" style="font-size: 12px;">PNG, JPG — Maks 2 MB · Rekomendasi 400×300 px</p>
                    </div>

                    <div id="preview" class="mt-3" style="display: none;">
                        <div style="position: relative; display: inline-block;">
                            <img id="preview-img" src="" alt="Pratinjau"
                                 style="width: 100%; max-width: 300px; height: 180px; object-fit: cover; border-radius: 10px; border: 1px solid #e3e6f0;">
                            <span style="position: absolute; bottom: 8px; left: 8px; background: rgba(78,115,223,0.85); color: #fff; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 5px; letter-spacing: 0.3px;">Pratinjau Baru</span>
                        </div>
                    </div>

                    @error('thumbnail')<div class="text-danger mt-2" style="font-size: 12px;">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- ── RIGHT: Settings ── --}}
        <div class="col-lg-4">

            {{-- Settings Card --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4" style="gap: 10px;">
                        <div style="background: #e3f9e5; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="mdi mdi-tune-vertical" style="font-size: 18px; color: #1cc88a;"></i>
                        </div>
                        <h6 class="font-weight-bold text-dark mb-0" style="font-size: 14px;">Pengaturan</h6>
                    </div>

                    {{-- Level --}}
                    <div class="form-group mb-3">
                        <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796;">
                            Tingkat Kesulitan <span class="text-danger">*</span>
                        </label>
                        <select class="form-control @error('level') is-invalid @enderror"
                                name="level" required
                                style="border-radius: 8px; font-size: 13px; border: 1px solid #e3e6f0; padding: 9px 12px;">
                            <option value="">Pilih tingkat…</option>
                            <option value="beginner"     {{ old('level', $course->level ?? '') == 'beginner'     ? 'selected' : '' }}>🌱 Pemula (Beginner)</option>
                            <option value="intermediate" {{ old('level', $course->level ?? '') == 'intermediate' ? 'selected' : '' }}>🌿 Menengah (Intermediate)</option>
                            <option value="advanced"     {{ old('level', $course->level ?? '') == 'advanced'     ? 'selected' : '' }}>🌳 Mahir (Advanced)</option>
                        </select>
                        @error('level')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Classroom --}}
                    <div class="form-group mb-3">
                        <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796;">Kelas</label>
                        <select name="classroom_id" class="form-control"
                                style="border-radius: 8px; font-size: 13px; border: 1px solid #e3e6f0; padding: 9px 12px;">
                            @foreach($classrooms as $class)
                                <option value="{{ $class->id }}"
                                    {{ old('classroom_id', $course->classroom_id ?? '') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Duration --}}
                    <div class="form-group mb-3">
                        <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796;">
                            Durasi <span class="text-danger">*</span>
                        </label>
                        <div style="position: relative;">
                            <input type="number"
                                   class="form-control @error('duration_hours') is-invalid @enderror"
                                   name="duration_hours"
                                   value="{{ old('duration_hours', $course->duration_hours ?? '') }}"
                                   placeholder="0"
                                   min="0" required
                                   style="border-radius: 8px; font-size: 13px; border: 1px solid #e3e6f0; padding: 9px 50px 9px 12px;">
                            <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); font-size: 12px; font-weight: 600; color: #858796; pointer-events: none;">jam</span>
                        </div>
                        @error('duration_hours')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Instructor --}}
                    <div class="form-group mb-0">
                        <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796;">
                            Guru / Instruktur <span class="text-danger">*</span>
                        </label>
                        <select class="form-control @error('instructor_id') is-invalid @enderror"
                                name="instructor_id" required
                                style="border-radius: 8px; font-size: 13px; border: 1px solid #e3e6f0; padding: 9px 12px;">
                            <option value="">Pilih guru…</option>
                            @foreach($instructors ?? [] as $instructor)
                            <option value="{{ $instructor->id }}"
                                    {{ old('instructor_id', isset($course) ? $course->instructor_id : (auth()->user()->hasRole('instructor') && !auth()->user()->hasRole('admin') ? auth()->id() : '')) == $instructor->id ? 'selected' : '' }}>
                                {{ $instructor->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('instructor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        @if(auth()->user()->hasRole('instructor') && !auth()->user()->hasRole('admin'))
                            <small class="text-muted mt-1 d-block">Anda akan ditetapkan sebagai instruktur.</small>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Publish Card --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3" style="gap: 10px;">
                        <div style="background: #fff3e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="mdi mdi-eye-outline" style="font-size: 18px; color: #f6c23e;"></i>
                        </div>
                        <h6 class="font-weight-bold text-dark mb-0" style="font-size: 14px;">Visibilitas</h6>
                    </div>

                    <label style="display: flex; align-items: center; justify-content: space-between; cursor: pointer; background: #f8f9fc; border-radius: 10px; padding: 12px 14px; border: 1px solid #e3e6f0;">
                        <div>
                            <div style="font-size: 13px; font-weight: 600; color: #2d3748;">Terbitkan Mata Pelajaran</div>
                            <div style="font-size: 12px; color: #858796; margin-top: 2px;">Siswa dapat melihat dan bergabung</div>
                        </div>
                        <div style="position: relative; flex-shrink: 0; margin-left: 12px;">
                            <input type="checkbox" id="is_published" name="is_published" value="1"
                                   {{ old('is_published', $course->is_published ?? false) ? 'checked' : '' }}
                                   onchange="syncToggle(this)"
                                   style="position: absolute; opacity: 0; width: 0; height: 0;">
                            <div id="toggleTrack"
                                 style="width: 42px; height: 24px; border-radius: 12px; background: #d1d3e2; position: relative; transition: background 0.25s; cursor: pointer;"
                                 onclick="document.getElementById('is_published').click()">
                                <div id="toggleThumb"
                                     style="width: 18px; height: 18px; border-radius: 50%; background: #fff; position: absolute; top: 3px; left: 3px; transition: transform 0.25s; box-shadow: 0 1px 3px rgba(0,0,0,0.15);"></div>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="d-flex flex-column" style="gap: 8px;">
                <button type="submit"
                        style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border: none; border-radius: 10px; padding: 13px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%;"
                        onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                    <i class="mdi mdi-check-circle-outline" style="font-size: 18px;"></i>
                    @isset($course) Simpan Perubahan @else Buat Mata Pelajaran @endisset
                </button>
                <a href="{{ route('courses.index') }}"
                   style="background: #f0f0f3; color: #858796; border-radius: 10px; padding: 11px; font-size: 13px; font-weight: 600; text-decoration: none; text-align: center; transition: all 0.2s;"
                   onmouseover="this.style.background='#e3e6f0';this.style.color='#2d3748';"
                   onmouseout="this.style.background='#f0f0f3';this.style.color='#858796';">
                    Batal
                </a>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const cb = document.getElementById('is_published');
    if (cb && cb.checked) applyToggle(true);
});

function syncToggle(cb) { applyToggle(cb.checked); }

function applyToggle(on) {
    const track = document.getElementById('toggleTrack');
    const thumb = document.getElementById('toggleThumb');
    if (!track || !thumb) return;
    track.style.background = on ? '#1cc88a' : '#d1d3e2';
    thumb.style.transform   = on ? 'translateX(18px)' : 'translateX(0)';
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('preview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        document.getElementById('preview').style.display = 'none';
    }
}

function handleFormSubmit(form) {
    Swal.fire({
        title: 'Simpan perubahan?',
        text: 'Pastikan semua informasi sudah benar.',
        icon: 'question',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya, Simpan',
        denyButtonText: 'Jangan Simpan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#4e73df',
    }).then(result => {
        if (result.isConfirmed) form.submit();
        else if (result.isDenied) Swal.fire({ text: 'Perubahan tidak disimpan.', icon: 'info', confirmButtonColor: '#4e73df' });
    });
}
</script>
@endpush

@endsection