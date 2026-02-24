@extends('layouts.skydash')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Edit Mata Pelajaran</h3>
                <h6 class="font-weight-normal mb-0">Kelola Mata Pelajaran ke platform pembelajaran Anda</h6>
            </div>
            <div class="col-12 col-xl-4">
                <div class="justify-content-end d-flex">
                    <a href="{{ route('courses.index') }}" class="btn btn-secondary">
                        <i class="icon-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form id="courseForm" action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data" onsubmit="event.preventDefault(); handleFormSubmit(this);">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="title" class="form-label">Judul Mata Pelajaran <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $course->title) }}" placeholder="Masukkan judul Mata Pelajaran" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="6" 
                                          placeholder="Masukkan deskripsi Mata Pelajaran" required>{{ old('description', $course->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="level" class="form-label">Tingkat Kesulitan <span class="text-danger">*</span></label>
                                <select class="form-control @error('level') is-invalid @enderror" 
                                        id="level" name="level" required>
                                    <option value="">Pilih Tingkat</option>
                                    <option value="beginner" {{ old('level', $course->level) == 'beginner' ? 'selected' : '' }}>Pemula (Beginner)</option>
                                    <option value="intermediate" {{ old('level', $course->level) == 'intermediate' ? 'selected' : '' }}>Menengah (Intermediate)</option>
                                    <option value="advanced" {{ old('level', $course->level) == 'advanced' ? 'selected' : '' }}>Mahir (Advanced)</option>
                                </select>
                                @error('level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Pilih Kelas</label>
                                <select name="classroom_id" class="form-control">
                                    @foreach($classrooms as $class)
                                        <option value="{{ $class->id }}" {{ old('classroom_id', $course->classroom_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="duration_hours" class="form-label">Durasi (Jam) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('duration_hours') is-invalid @enderror" 
                                       id="duration_hours" name="duration_hours" value="{{ old('duration_hours',$course->duration_hours) }}" 
                                       placeholder="Contoh: 10" min="0" required>
                                @error('duration_hours')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="instructor_id" class="form-label">Guru <span class="text-danger">*</span></label>
                                <select class="form-control @error('instructor_id') is-invalid @enderror" 
                                        id="instructor_id" name="instructor_id" required>
                                    <option value="">Pilih Guru</option>
                                    @foreach($instructors ?? [] as $instructor)
                                    <option value="{{ $instructor->id }}" 
                                            {{ old('instructor_id', $course->instructor_id) == $instructor->id ? 'selected' : '' }}>
                                        {{ $instructor->name }} ({{ $instructor->email }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('instructor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if(auth()->user()->hasRole('instructor') && !auth()->user()->hasRole('admin'))
                                    <small class="form-text text-muted">Anda akan ditetapkan sebagai instruktur untuk Mata Pelajaran ini.</small>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <div class="form-check form-check-primary">
                                    <input type="checkbox" class="form-check-input" id="is_published" name="is_published" value="1" {{ old('is_published', $course->is_published) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_published">
                                        Terbitkan segera
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                @if($course->thumbnail)
                                    <div class="mt-2 mb-2">
                                        <p class="text-muted mb-1">Thumbnail saat ini:</p>
                                        <img src="{{ asset('storage/' . $course->thumbnail) }}" width="150" class="img-thumbnail">
                                    </div>
                                @endif
                                <label for="thumbnail" class="form-label">Thumbnail Mata Pelajaran</label>
                                <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" 
                                       id="thumbnail" name="thumbnail" accept="image/*" onchange="previewImage(this)">
                                <small class="form-text text-muted">Maksimal 2MB. Rekomendasi: 400x300px</small>
                                @error('thumbnail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="preview" class="mt-3" style="display: none;">
                                    <img id="preview-img" src="" alt="Pratinjau" class="img-thumbnail" style="max-width: 300px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="icon-check"></i> Simpan Mata Pelajaran
                            </button>
                            <a href="{{ route('courses.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const previewImg = document.getElementById('preview-img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

function handleFormSubmit(form) {
    Swal.fire({
        title: "Apakah Anda ingin menyimpan perubahan?",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Simpan",
        denyButtonText: `Jangan Simpan`,
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        } else if (result.isDenied) {
            Swal.fire("Perubahan tidak disimpan", "", "info");
        }
    });
}
</script>
@endpush
@endsection