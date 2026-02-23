@extends('layouts.skydash')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <div class="d-flex align-items-center">
                    <div>
                        <h3 class="font-weight-bold mb-2">Pengaturan Profil</h3>
                        <p class="text-muted mb-0">Kelola pengaturan akun dan informasi profil Anda</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-4">
                <div class="justify-content-end d-flex">
                    <a href="{{ route('dashboard') }}" class="btn btn-light">
                        <i class="mdi mdi-arrow-left"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">
                    <i class="mdi mdi-account text-primary"></i> Informasi Profil
                </h4>
                <p class="text-muted mb-4">Perbarui informasi profil dan alamat email akun Anda.</p>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="avatar-section text-center">
                            <div class="avatar-container mb-3">
                                <img src="{{ $user->avatar_url }}" 
                                     alt="Foto Profil" 
                                     class="avatar-image"
                                     id="avatar-preview">
                            </div>
                            <div class="avatar-actions">
                                <button type="button" 
                                        class="btn btn-sm btn-primary mb-2" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#avatarModal">
                                    <i class="mdi mdi-camera mr-1"></i> Ganti Foto
                                </button>
                                @if($user->avatar)
                                    <form action="{{ route('profile.avatar.delete') }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus foto profil?')">
                                            <i class="mdi mdi-delete mr-1"></i> Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="avatar-info">
                            <h6 class="mb-2">Foto Profil</h6>
                            <p class="text-muted small mb-2">
                                Unggah foto profil untuk mempersonalisasi akun Anda. 
                                Format yang didukung: JPG, PNG, GIF (maks. 2MB)
                            </p>
                            @if($user->avatar)
                                <div class="alert alert-success small">
                                    <i class="mdi mdi-check-circle mr-1"></i>
                                    Anda telah mengunggah foto profil kustom.
                                </div>
                            @else
                                <div class="alert alert-info small">
                                    <i class="mdi mdi-information mr-1"></i>
                                    Menggunakan foto profil otomatis berdasarkan inisial Anda.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="form-group mb-4">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $user->name) }}" 
                               required 
                               autofocus 
                               autocomplete="name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}" 
                               required 
                               autocomplete="username">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-2">
                                <p class="text-sm text-warning">
                                    <i class="mdi mdi-alert-circle mr-1"></i>
                                    Alamat email Anda belum diverifikasi.
                                </p>
                                <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-warning">
                                        <i class="mdi mdi-email mr-1"></i> Kirim ulang email verifikasi
                                    </button>
                                </form>

                                @if (session('status') === 'verification-link-sent')
                                    <div class="alert alert-success mt-2">
                                        <i class="mdi mdi-check-circle mr-1"></i>
                                        Link verifikasi baru telah dikirim ke alamat email Anda.
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary mr-3">
                            <i class="mdi mdi-check"></i> Simpan Perubahan
                        </button>

                        @if (session('status') === 'profile-updated')
                            <span class="text-success ml-3">
                                <i class="mdi mdi-check-circle mr-1"></i> Berhasil disimpan!
                            </span>
                        @elseif (session('status') === 'avatar-updated')
                            <span class="text-success ml-3">
                                <i class="mdi mdi-check-circle mr-1"></i> Foto profil berhasil diperbarui!
                            </span>
                        @elseif (session('status') === 'avatar-deleted')
                            <span class="text-info ml-3">
                                <i class="mdi mdi-information mr-1"></i> Foto profil berhasil dihapus!
                            </span>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="mdi mdi-account-circle text-info"></i> Informasi Akun
                </h5>
                
                <div class="user-info">
                    <div class="d-flex align-items-center mb-3">
                        <div class="sidebar-avatar mr-3">
                            <img src="{{ $user->avatar_url }}" 
                                 alt="Foto Profil" 
                                 class="sidebar-avatar-image">
                        </div>
                        <div>
                            <h6 class="mb-1">{{ $user->name }}</h6>
                            <small class="text-muted">{{ $user->email }}</small>
                        </div>
                    </div>

                    <div class="account-stats">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Peran:</span>
                            @php
                                $roleLabels = [
                                    'admin' => 'Administrator',
                                    'instructor' => 'Instruktur',
                                    'student' => 'Siswa',
                                    'user' => 'Pengguna'
                                ];
                                $userRole = $user->roles->first()->name ?? 'user';
                            @endphp
                            <strong>{{ $roleLabels[$userRole] ?? ucfirst($userRole) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Anggota sejak:</span>
                            <strong>{{ $user->created_at->translatedFormat('M Y') }}</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Status Email:</span>
                            @if($user->hasVerifiedEmail())
                                <span class="badge badge-success">Terverifikasi</span>
                            @else
                                <span class="badge badge-warning">Belum Verifikasi</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">
                    <i class="mdi mdi-lock text-primary"></i> Perbarui Kata Sandi
                </h4>
                <p class="text-muted mb-4">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk menjaga keamanan.</p>

                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="form-group mb-4">
                        <label for="update_password_current_password" class="form-label">Kata Sandi Saat Ini</label>
                        <input type="password" 
                               class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                               id="update_password_current_password" 
                               name="current_password" 
                               autocomplete="current-password">
                        @error('current_password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="update_password_password" class="form-label">Kata Sandi Baru</label>
                        <input type="password" 
                               class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                               id="update_password_password" 
                               name="password" 
                               autocomplete="new-password">
                        @error('password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="update_password_password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" 
                               class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                               id="update_password_password_confirmation" 
                               name="password_confirmation" 
                               autocomplete="new-password">
                        @error('password_confirmation', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary mr-3">
                            <i class="mdi mdi-check"></i> Perbarui Kata Sandi
                        </button>

                        @if (session('status') === 'password-updated')
                            <span class="text-success ml-3">
                                <i class="mdi mdi-check-circle mr-1"></i> Kata sandi berhasil diperbarui!
                            </span>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="avatarModalLabel">
                    <i class="mdi mdi-camera text-primary"></i> Unggah Foto Profil
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="avatar" class="form-label">Pilih Gambar</label>
                        <input type="file" 
                               class="form-control @error('avatar') is-invalid @enderror" 
                               id="avatar" 
                               name="avatar" 
                               accept="image/*"
                               onchange="previewAvatar(this)">
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Format didukung: JPG, PNG, GIF. Ukuran maksimal: 2MB
                        </small>
                    </div>
                    
                    <div class="avatar-preview-container text-center">
                        <img id="avatar-preview-modal" 
                             src="{{ $user->avatar_url }}" 
                             alt="Pratinjau Foto" 
                             class="avatar-preview-image">
                        <p class="text-muted small mt-2">Pratinjau</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="mdi mdi-close mr-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-upload mr-1"></i> Unggah Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Avatar Styling */
    .avatar-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #e3e6f0;
        transition: all 0.3s ease;
    }
    
    .avatar-image:hover {
        border-color: #667eea;
        transform: scale(1.05);
    }
    
    .sidebar-avatar-image {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e3e6f0;
    }
    
    .avatar-preview-image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e3e6f0;
    }
    
    .avatar-container {
        position: relative;
        display: inline-block;
    }
    
    .avatar-section {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #e3e6f0;
    }
    
    .avatar-info {
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
    }
    
    .avatar-actions {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    
    .avatar-preview-container {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #e3e6f0;
    }
    
    /* Legacy avatar circle for fallback */
    .avatar-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: bold;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .account-stats {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
    }
    
    .card.border-danger {
        border-color: #dc3545 !important;
    }
    
    .badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }
    
    .badge-success {
        background-color: #28a745;
        color: white;
    }
    
    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }
    
    /* File input styling */
    .form-control[type="file"] {
        padding: 0.375rem 0.75rem;
    }
    
    .form-control[type="file"]::-webkit-file-upload-button {
        background-color: #667eea;
        color: white;
        border: none;
        padding: 0.375rem 0.75rem;
        border-radius: 0.25rem;
        margin-right: 0.5rem;
        cursor: pointer;
    }
    
    .form-control[type="file"]::-webkit-file-upload-button:hover {
        background-color: #5a6fd8;
    }
</style>
@endpush

@push('scripts')
<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            // Update preview in modal
            document.getElementById('avatar-preview-modal').src = e.target.result;
            
            // Update main avatar preview
            document.getElementById('avatar-preview').src = e.target.result;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Auto-refresh page after successful avatar upload
@if(session('status') === 'avatar-updated' || session('status') === 'avatar-deleted')
    setTimeout(function() {
        location.reload();
    }, 2000);
@endif
</script>
@endpush
@endsection
