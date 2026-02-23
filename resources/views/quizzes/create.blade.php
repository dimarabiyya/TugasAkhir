@extends('layouts.skydash')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Buat Kuis Baru</h3>
                <h6 class="font-weight-normal mb-0">Buat kuis baru untuk: {{ $lesson->title }}</h6>
            </div>
            <div class="col-12 col-xl-4">
                <div class="justify-content-end d-flex">
                    <a href="{{ route('quizzes.index') }}" class="btn btn-secondary">
                        <i class="icon-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form id="quizForm" action="{{ route('quizzes.store', $lesson) }}" method="POST" onsubmit="event.preventDefault(); handleFormSubmit(this);">
                    @csrf
                    
                    <!-- Basic Information Section -->
                    <h5 class="mb-3">
                        <i class="icon-info text-primary mr-2"></i> Informasi Dasar
                    </h5>
                    
                    <div class="form-group mb-3">
                        <label for="title" class="form-label font-weight-bold">Judul Kuis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" 
                               placeholder="Masukkan judul kuis" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="description" class="form-label font-weight-bold">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" 
                                  placeholder="Masukkan deskripsi kuis (opsional)">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Berikan deskripsi singkat tentang apa yang dicakup kuis ini</small>
                    </div>
                    
                    <hr class="my-3">
                    
                    <!-- Quiz Settings Section -->
                    <h5 class="mb-3">
                        <i class="icon-settings text-primary mr-2"></i> Pengaturan Kuis
                    </h5>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="passing_score" class="form-label font-weight-bold">Skor Kelulusan (%) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('passing_score') is-invalid @enderror" 
                                       id="passing_score" name="passing_score" value="{{ old('passing_score', 60) }}" 
                                       min="0" max="100" required>
                                @error('passing_score')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Skor minimum yang diperlukan untuk lulus (0-100)</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="time_limit_minutes" class="form-label font-weight-bold">Batas Waktu (Menit)</label>
                                <input type="number" class="form-control @error('time_limit_minutes') is-invalid @enderror" 
                                       id="time_limit_minutes" name="time_limit_minutes" value="{{ old('time_limit_minutes') }}" 
                                       min="1" placeholder="Biarkan kosong untuk tanpa batas">
                                @error('time_limit_minutes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Biarkan kosong jika tidak ada batas waktu</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status" class="form-label font-weight-bold">Status <span class="text-danger">*</span></label>
                                <select class="form-control @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                    <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draf</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Dipublikasikan</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Kuis draf tidak terlihat oleh siswa</small>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden default values -->
                    <input type="hidden" name="allow_multiple_attempts" value="1">
                    <input type="hidden" name="show_results_immediately" value="1">
                    <input type="hidden" name="allow_navigation" value="1">
                    <input type="hidden" name="shuffle_questions" value="0">
                    <input type="hidden" name="shuffle_answers" value="0">
                    <input type="hidden" name="show_correct_answers" value="0">
                    <input type="hidden" name="negative_marking" value="0">
                    
                    <hr class="my-3">
                    
                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-start align-items-center mt-3">
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="icon-check mr-2"></i> Buat Kuis
                        </button>
                        <a href="{{ route('quizzes.index') }}" class="btn btn-secondary">
                            <i class="icon-close mr-2"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-12 grid-margin stretch-card">
        <!-- Course Information Card -->
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i class="icon-book text-primary mr-2"></i> Informasi Kursus
                </h5>
                
                <div class="mb-3">
                    <label class="text-muted mb-1 d-block" style="font-size: 0.875rem;">Kursus</label>
                    <p class="mb-0 font-weight-bold" style="word-break: break-word;">{{ $lesson->module->course->title ?? 'N/A' }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="text-muted mb-1 d-block" style="font-size: 0.875rem;">Modul</label>
                    <p class="mb-0 font-weight-bold" style="word-break: break-word;">{{ $lesson->module->title ?? 'N/A' }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="text-muted mb-1 d-block" style="font-size: 0.875rem;">Materi</label>
                    <p class="mb-0 font-weight-bold" style="word-break: break-word;">{{ $lesson->title }}</p>
                </div>
                
                <div class="mb-0">
                    <label class="text-muted mb-1 d-block" style="font-size: 0.875rem;">Tipe Materi</label>
                    <span class="badge badge-info">{{ ucfirst($lesson->type ?? 'N/A') }}</span>
                </div>
            </div>
        </div>
        
        <!-- Quick Tips Card -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i class="icon-lightbulb text-warning mr-2"></i> Tip Cepat
                </h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="icon-check text-success mr-2"></i>
                        <small>Tambahkan pertanyaan setelah membuat kuis.</small>
                    </li>
                    <li class="mb-2">
                        <i class="icon-check text-success mr-2"></i>
                        <small>Tetapkan skor kelulusan yang sesuai.</small>
                    </li>
                    <li class="mb-2">
                        <i class="icon-check text-success mr-2"></i>
                        <small>Batas waktu memastikan penilaian yang adil.</small>
                    </li>
                    <li>
                        <i class="icon-check text-success mr-2"></i>
                        <small>Simpan sebagai draf sebelum menerbitkan.</small>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function handleFormSubmit(form) {
    Swal.fire({
        title: "Apakah Anda ingin menyimpan perubahan?",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Simpan",
        denyButtonText: `Jangan simpan`
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

