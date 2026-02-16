@extends('layouts.skydash')

@section('content')
<!-- Header Section -->
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <div class="d-flex align-items-center">
                    <div>
                        <h3 class="font-weight-bold mb-2">Tambah Siswa Baru</h3>
                        <p class="text-muted mb-0">Buat akun siswa baru</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-4">
                <div class="justify-content-end d-flex">
                    <a href="{{ route('students.index') }}" class="btn btn-light">
                        <i class="mdi mdi-arrow-left"></i> Kembali ke Siswa
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Student Form -->
<div class="row">
    <div class="col-md-8 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">
                    <i class="mdi mdi-account-plus text-primary"></i> Informasi Siswa
                </h4>

                <form action="{{ route('students.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group mb-4">
                        <label for="name" class="form-label">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="Masukkan nama lengkap siswa"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="email" class="form-label">
                            Alamat Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="Masukkan alamat email siswa"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Ini akan digunakan untuk login dan notifikasi
                        </small>
                    </div>

                    <div class="form-group mb-4">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input type="text" 
                               class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}" 
                               placeholder="Masukkan nomor telepon siswa">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="level" class="form-label">Tingkat Siswa</label>
                        <select class="form-control @error('level') is-invalid @enderror" 
                                id="level" 
                                name="level">
                            <option value="">Pilih tingkat siswa (opsional)</option>
                            <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>Pemula</option>
                            <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>Menengah</option>
                            <option value="advanced" {{ old('level') == 'advanced' ? 'selected' : '' }}>Lanjutan</option>
                        </select>
                        @error('level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Ini membantu mengkategorikan siswa berdasarkan tingkat keterampilan mereka
                        </small>
                    </div>

                    <div class="form-group mb-4">
                        <label for="password" class="form-label">
                            Kata Sandi <span class="text-danger">*</span>
                        </label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Masukkan kata sandi (minimal 8 karakter)"
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="password_confirmation" class="form-label">
                            Konfirmasi Kata Sandi <span class="text-danger">*</span>
                        </label>
                        <input type="password" 
                               class="form-control @error('password_confirmation') is-invalid @enderror" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               placeholder="Konfirmasi kata sandi"
                               required>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary mr-3">
                            <i class="mdi mdi-check"></i> Buat Siswa
                        </button>
                        <a href="{{ route('students.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-close"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4 grid-margin">
        <!-- Student Info -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="mdi mdi-information text-info"></i> Info Akun Siswa
                </h5>
                
                <div class="info-list">
                    <div class="info-item d-flex align-items-center mb-3">
                        <i class="mdi mdi-account text-primary mr-3"></i>
                        <div>
                            <h6 class="mb-1">Peran Siswa</h6>
                            <small class="text-muted">Otomatis ditugaskan peran 'siswa'</small>
                        </div>
                    </div>
                    
                    <div class="info-item d-flex align-items-center mb-3">
                        <i class="mdi mdi-email text-primary mr-3"></i>
                        <div>
                            <h6 class="mb-1">Verifikasi Email</h6>
                            <small class="text-muted">Siswa perlu memverifikasi email</small>
                        </div>
                    </div>
                    
                    <div class="info-item d-flex align-items-center mb-3">
                        <i class="mdi mdi-book text-primary mr-3"></i>
                        <div>
                            <h6 class="mb-1">Akses Kursus</h6>
                            <small class="text-muted">Dapat mendaftar kursus yang tersedia</small>
                        </div>
                    </div>
                    
                    <div class="info-item d-flex align-items-center">
                        <i class="mdi mdi-chart-line text-primary mr-3"></i>
                        <div>
                            <h6 class="mb-1">Pelacakan Kemajuan</h6>
                            <small class="text-muted">Kemajuan pembelajaran akan dilacak</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Level Guide -->
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="mdi mdi-school text-warning"></i> Tingkat Siswa
                </h5>
                
                <div class="level-guide">
                    <div class="level-item mb-3 p-3 border rounded">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-success mr-2">Pemula</span>
                            <span class="text-muted small">Baru dalam materi pelajaran</span>
                        </div>
                    </div>
                    
                    <div class="level-item mb-3 p-3 border rounded">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-warning mr-2">Menengah</span>
                            <span class="text-muted small">Beberapa pengetahuan dan pengalaman</span>
                        </div>
                    </div>
                    
                    <div class="level-item p-3 border rounded">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-danger mr-2">Lanjutan</span>
                            <span class="text-muted small">Berpengalaman dan berpengetahuan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="mdi mdi-chart text-success"></i> Statistik Cepat
                </h5>
                
                <div class="stats-grid">
                    <div class="stat-item text-center mb-3">
                        <h4 class="text-primary mb-1">{{ \App\Models\User::role('student')->count() }}</h4>
                        <small class="text-muted">Total Siswa</small>
                    </div>
                    
                    <div class="stat-item text-center mb-3">
                        <h4 class="text-success mb-1">{{ \App\Models\User::role('student')->whereHas('enrollments')->count() }}</h4>
                        <small class="text-muted">Siswa Aktif</small>
                    </div>
                    
                    <div class="stat-item text-center">
                        <h4 class="text-info mb-1">{{ \App\Models\User::role('student')->whereNull('email_verified_at')->count() }}</h4>
                        <small class="text-muted">Belum Terverifikasi</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .info-item {
        padding: 8px 0;
    }
    
    .level-item {
        transition: all 0.3s ease;
    }
    
    .level-item:hover {
        background-color: #f8f9fa;
        border-color: #667eea !important;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }
    
    .stat-item:last-child {
        grid-column: 1 / -1;
    }
    
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .info-list .info-item:last-child {
        margin-bottom: 0 !important;
    }
</style>
@endpush
@endsection
