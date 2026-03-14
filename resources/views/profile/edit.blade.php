@extends('layouts.skydash')

@section('content')

@php
    $roleLabels = [
        'admin'      => 'Administrator',
        'instructor' => 'Instruktur',
        'student'    => 'Siswa',
        'user'       => 'Pengguna',
    ];
    $userRole = $user->roles->first()->name ?? 'user';
@endphp

{{-- ===== PAGE HEADER ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
            <div class="card-body py-4 px-4">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-8 mb-3 mb-xl-0">
                        <div class="d-flex align-items-center">
                            <div style="background: rgba(255,255,255,0.2); border-radius: 10px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; margin-right: 14px; flex-shrink: 0;">
                                <i class="mdi mdi-account-cog-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Pengaturan Profil</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Kelola informasi akun dan keamanan Anda</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('dashboard') }}"
                           class="btn font-weight-bold"
                           style="background: #fff; color: #4e73df; border-radius: 8px; font-size: 13px; border: none;">
                            <i class="mdi mdi-view-dashboard-outline mr-1"></i> Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== SESSION ALERTS ===== --}}
@if(session('status') === 'profile-updated')
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #1cc88a !important;">
            <div class="card-body py-3 px-4 d-flex align-items-center" style="gap: 10px;">
                <i class="mdi mdi-check-circle-outline" style="font-size: 20px; color: #1cc88a; flex-shrink: 0;"></i>
                <p class="mb-0 text-dark font-weight-600" style="font-size: 13px;">Profil berhasil disimpan!</p>
            </div>
        </div>
    </div>
</div>
@elseif(session('status') === 'avatar-updated')
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #1cc88a !important;">
            <div class="card-body py-3 px-4 d-flex align-items-center" style="gap: 10px;">
                <i class="mdi mdi-check-circle-outline" style="font-size: 20px; color: #1cc88a; flex-shrink: 0;"></i>
                <p class="mb-0 text-dark font-weight-600" style="font-size: 13px;">Foto profil berhasil diperbarui!</p>
            </div>
        </div>
    </div>
</div>
@elseif(session('status') === 'avatar-deleted')
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #17a2b8 !important;">
            <div class="card-body py-3 px-4 d-flex align-items-center" style="gap: 10px;">
                <i class="mdi mdi-information-outline" style="font-size: 20px; color: #17a2b8; flex-shrink: 0;"></i>
                <p class="mb-0 text-dark font-weight-600" style="font-size: 13px;">Foto profil berhasil dihapus.</p>
            </div>
        </div>
    </div>
</div>
@elseif(session('status') === 'password-updated')
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #1cc88a !important;">
            <div class="card-body py-3 px-4 d-flex align-items-center" style="gap: 10px;">
                <i class="mdi mdi-check-circle-outline" style="font-size: 20px; color: #1cc88a; flex-shrink: 0;"></i>
                <p class="mb-0 text-dark font-weight-600" style="font-size: 13px;">Kata sandi berhasil diperbarui!</p>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">

    {{-- ===== LEFT COLUMN ===== --}}
    <div class="col-md-8 mb-4">

        {{-- ---- SECTION: Informasi Profil ---- --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">

                {{-- Section Header --}}
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-account-outline" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Informasi Profil</h5>
                        <small class="text-muted">Perbarui nama dan alamat email akun Anda</small>
                    </div>
                </div>

                <div class="p-4">

                    {{-- Avatar Row --}}
                    <div class="d-flex align-items-center mb-4 p-3" style="background: #f8f9fc; border-radius: 10px; border: 1px solid #eaecf4; gap: 20px;">
                        {{-- Avatar --}}
                        <div style="position: relative; flex-shrink: 0;">
                            <img src="{{ $user->avatar_url }}"
                                 alt="Foto Profil"
                                 id="avatar-preview"
                                 style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #e8f0fe; transition: all 0.3s ease;">
                            <button type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#avatarModal"
                                    title="Ganti foto"
                                    style="position: absolute; bottom: 0; right: 0; width: 26px; height: 26px; border-radius: 50%; background: #4e73df; border: 2px solid #fff; color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; padding: 0;">
                                <i class="mdi mdi-camera" style="font-size: 13px;"></i>
                            </button>
                        </div>
                        {{-- Info --}}
                        <div style="flex: 1;">
                            <p class="font-weight-bold text-dark mb-0" style="font-size: 14px;">{{ $user->name }}</p>
                            <p class="text-muted mb-2" style="font-size: 12px;">{{ $user->email }}</p>
                            <div class="d-flex" style="gap: 6px; flex-wrap: wrap;">
                                <button type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#avatarModal"
                                        style="background: #e8f0fe; color: #4e73df; border: none; border-radius: 6px; padding: 4px 12px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s;"
                                        onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                        onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                    <i class="mdi mdi-camera mr-1"></i> Ganti Foto
                                </button>
                                @if($user->avatar)
                                <form action="{{ route('profile.avatar.delete') }}" method="POST" class="d-inline m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Hapus foto profil?')"
                                            style="background: #fde8e8; color: #e74a3b; border: none; border-radius: 6px; padding: 4px 12px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s;"
                                            onmouseover="this.style.background='#e74a3b';this.style.color='#fff';"
                                            onmouseout="this.style.background='#fde8e8';this.style.color='#e74a3b';">
                                        <i class="mdi mdi-delete mr-1"></i> Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                        {{-- Status info --}}
                        <div class="d-none d-md-block">
                            @if($user->avatar)
                                <span style="background: #e3f9e5; color: #1cc88a; border-radius: 8px; padding: 5px 12px; font-size: 11px; font-weight: 600; white-space: nowrap;">
                                    <i class="mdi mdi-check-circle mr-1"></i> Foto Kustom
                                </span>
                            @else
                                <span style="background: #e8f0fe; color: #4e73df; border-radius: 8px; padding: 5px 12px; font-size: 11px; font-weight: 600; white-space: nowrap;">
                                    <i class="mdi mdi-account-circle mr-1"></i> Foto Otomatis
                                </span>
                            @endif
                        </div>
                    </div>

                    @if (auth()->user()->hasRole('admin') && (auth()->user()->hasRole('student')))
                    {{-- Profile Form --}}
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        {{-- Nama --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-account-outline mr-1 text-muted"></i> Nama <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}"
                                   required autofocus autocomplete="name"
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                   onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                   onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="form-group mb-4">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-email-outline mr-1 text-muted"></i> Email <span class="text-danger">*</span>
                            </label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}"
                                   required autocomplete="username"
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                   onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                   onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-2 p-3" style="background: #fff8e8; border-radius: 8px; border: 1px solid #fde68a;">
                                <p class="mb-2" style="font-size: 12px; color: #b8860b;">
                                    <i class="mdi mdi-alert-circle-outline mr-1"></i>
                                    Alamat email Anda belum diverifikasi.
                                </p>
                                <form id="send-verification" method="POST" action="{{ route('verification.send') }}" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            style="background: #fff3cd; color: #856404; border: 1px solid #fde68a; border-radius: 6px; padding: 4px 12px; font-size: 12px; font-weight: 600; cursor: pointer;">
                                        <i class="mdi mdi-email-outline mr-1"></i> Kirim ulang verifikasi
                                    </button>
                                </form>
                                @if(session('status') === 'verification-link-sent')
                                <p class="mb-0 mt-2" style="font-size: 12px; color: #1cc88a;">
                                    <i class="mdi mdi-check-circle mr-1"></i> Link verifikasi telah dikirim.
                                </p>
                                @endif
                            </div>
                            @endif
                        </div>
                        
                        @endif
                    </form>

                    @if (auth()->user()->hasRole('student'))
                    {{-- Nama --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-account-outline mr-1 text-muted"></i> Nama <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}"
                                   required autofocus autocomplete="name"
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                   onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                   onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';" disabled>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="form-group mb-4">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-email-outline mr-1 text-muted"></i> Email <span class="text-danger">*</span>
                            </label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}"
                                   required autocomplete="username"
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                   onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                   onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';" disabled>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-2 p-3" style="background: #fff8e8; border-radius: 8px; border: 1px solid #fde68a;">
                                <p class="mb-2" style="font-size: 12px; color: #b8860b;">
                                    <i class="mdi mdi-alert-circle-outline mr-1"></i>
                                    Alamat email Anda belum diverifikasi.
                                </p>
                                <form id="send-verification" method="POST" action="{{ route('verification.send') }}" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            style="background: #fff3cd; color: #856404; border: 1px solid #fde68a; border-radius: 6px; padding: 4px 12px; font-size: 12px; font-weight: 600; cursor: pointer;">
                                        <i class="mdi mdi-email-outline mr-1"></i> Kirim ulang verifikasi
                                    </button>
                                </form>
                                @if(session('status') === 'verification-link-sent')
                                <p class="mb-0 mt-2" style="font-size: 12px; color: #1cc88a;">
                                    <i class="mdi mdi-check-circle mr-1"></i> Link verifikasi telah dikirim.
                                </p>
                                @endif
                            </div>
                            @endif
                        </div>
                        {{-- nisn --}}
                            <div class="form-group mb-3">
                                <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                    <i class="mdi mdi-account-outline mr-1 text-muted"></i> NISN <span class="text-danger">*</span>
                                </label>
                                <div class="">
                                    
                                </div>
                                <input type="text"
                                    name="nisn"
                                    id="nisn"
                                    class="form-control @error('nisn') is-invalid @enderror"
                                    value="{{ old('nisn', $user->nisn) }}"
                                    required autofocus autocomplete="nisn"
                                    style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                    onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                    onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';" disabled>
                                @error('nisn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        {{-- Action --}}
                        <div class="d-flex justify-content-end">
                            <button type="submit"
                                    style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 22px; border: none; box-shadow: 0 4px 12px rgba(78,115,223,0.3); cursor: pointer; transition: all 0.2s;"
                                    onmouseover="this.style.opacity='0.9';"
                                    onmouseout="this.style.opacity='1';">
                                <i class="mdi mdi-content-save-outline mr-1"></i> Simpan Perubahan
                            </button>
                        </div>
                </div>
                
            </div>
        </div>

        {{-- ---- SECTION: Kata Sandi ---- --}}
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">

                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #fde8e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-lock-outline" style="font-size: 18px; color: #e74a3b;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Perbarui Kata Sandi</h5>
                        <small class="text-muted">Gunakan kata sandi yang kuat dan unik</small>
                    </div>
                </div>

                <div class="p-4">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        {{-- Current Password --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-lock-outline mr-1 text-muted"></i> Kata Sandi Saat Ini
                            </label>
                            <div style="position: relative;">
                                <input type="password"
                                       name="current_password"
                                       id="current_password"
                                       class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                       autocomplete="current-password"
                                       style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px; padding-right: 44px;"
                                       onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                       onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                                <button type="button" onclick="togglePwd('current_password', this)"
                                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #adb5bd; cursor: pointer; padding: 0;">
                                    <i class="mdi mdi-eye-outline" style="font-size: 18px;"></i>
                                </button>
                            </div>
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- New Password --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-lock-plus-outline mr-1 text-muted"></i> Kata Sandi Baru
                            </label>
                            <div style="position: relative;">
                                <input type="password"
                                       name="password"
                                       id="new_password"
                                       class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                       autocomplete="new-password"
                                       style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px; padding-right: 44px;"
                                       onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                       onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';"
                                       oninput="checkStrength(this.value)">
                                <button type="button" onclick="togglePwd('new_password', this)"
                                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #adb5bd; cursor: pointer; padding: 0;">
                                    <i class="mdi mdi-eye-outline" style="font-size: 18px;"></i>
                                </button>
                            </div>
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            {{-- Strength bar --}}
                            <div class="mt-2" id="strengthWrap" style="display: none;">
                                <div style="height: 4px; background: #e3e6f0; border-radius: 4px; overflow: hidden;">
                                    <div id="strengthBar" style="height: 100%; width: 0; border-radius: 4px; transition: all 0.3s;"></div>
                                </div>
                                <small id="strengthLabel" class="text-muted" style="font-size: 11px;"></small>
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="form-group mb-4">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-lock-check-outline mr-1 text-muted"></i> Konfirmasi Kata Sandi Baru
                            </label>
                            <div style="position: relative;">
                                <input type="password"
                                       name="password_confirmation"
                                       id="password_confirmation"
                                       class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                                       autocomplete="new-password"
                                       style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px; padding-right: 44px;"
                                       onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                       onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                                <button type="button" onclick="togglePwd('password_confirmation', this)"
                                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #adb5bd; cursor: pointer; padding: 0;">
                                    <i class="mdi mdi-eye-outline" style="font-size: 18px;"></i>
                                </button>
                            </div>
                            @error('password_confirmation', 'updatePassword')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit"
                                    style="background: linear-gradient(135deg, #e74a3b, #c0392b); color: #fff; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 22px; border: none; box-shadow: 0 4px 12px rgba(231,74,59,0.25); cursor: pointer; transition: all 0.2s;"
                                    onmouseover="this.style.opacity='0.9';"
                                    onmouseout="this.style.opacity='1';">
                                <i class="mdi mdi-lock-reset mr-1"></i> Perbarui Kata Sandi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    {{-- ===== RIGHT COLUMN: Account Info ===== --}}
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; position: sticky; top: 80px;">
            <div class="card-body p-0">

                {{-- Profile banner --}}
                <div style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px 12px 0 0; padding: 24px; text-align: center;">
                    <img src="{{ $user->avatar_url }}"
                         alt="avatar"
                         style="width: 72px; height: 72px; border-radius: 50%; object-fit: cover; border: 3px solid rgba(255,255,255,0.5); margin-bottom: 10px;">
                    <p class="font-weight-bold text-white mb-0" style="font-size: 15px;">{{ $user->name }}</p>
                    <p class="text-white-50 mb-0" style="font-size: 12px;">{{ $user->email }}</p>
                </div>

                {{-- Info rows --}}
                <div class="p-4">
                    <div class="d-flex align-items-center justify-content-between py-2" style="border-bottom: 1px solid #f0f0f3;">
                        <span class="text-muted" style="font-size: 13px;"><i class="mdi mdi-account-badge-outline mr-1"></i> Peran</span>
                        <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 600;">
                            {{ $roleLabels[$userRole] ?? ucfirst($userRole) }}
                        </span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between py-2" style="border-bottom: 1px solid #f0f0f3;">
                        <span class="text-muted" style="font-size: 13px;"><i class="mdi mdi-calendar-outline mr-1"></i> Bergabung</span>
                        <span class="font-weight-bold text-dark" style="font-size: 13px;">
                            {{ $user->created_at->translatedFormat('M Y') }}
                        </span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between py-2" style="border-bottom: 1px solid #f0f0f3;">
                        <span class="text-muted" style="font-size: 13px;"><i class="mdi mdi-email-check-outline mr-1"></i> Status Email</span>
                        @if($user->hasVerifiedEmail())
                            <span style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 600;">
                                <i class="mdi mdi-check-circle mr-1"></i> Terverifikasi
                            </span>
                        @else
                            <span style="background: #fff3e8; color: #f6c23e; border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 600;">
                                <i class="mdi mdi-alert-circle mr-1"></i> Belum
                            </span>
                        @endif
                    </div>
                    <div class="d-flex align-items-center justify-content-between py-2">
                        <span class="text-muted" style="font-size: 13px;"><i class="mdi mdi-camera-outline mr-1"></i> Foto Profil</span>
                        @if($user->avatar)
                            <span style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 600;">
                                Kustom
                            </span>
                        @else
                            <span style="background: #f4f6fb; color: #858796; border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 600;">
                                Otomatis
                            </span>
                        @endif
                    </div>

                    {{-- Logout --}}
                    <div class="mt-3 pt-2" style="border-top: 1px solid #f0f0f3;">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-100"
                                    style="background: #fff5f5; color: #e74a3b; border: 1px solid #fdd; border-radius: 8px; padding: 9px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s; width: 100%;"
                                    onmouseover="this.style.background='#e74a3b';this.style.color='#fff';"
                                    onmouseout="this.style.background='#fff5f5';this.style.color='#e74a3b';">
                                <i class="mdi mdi-logout mr-1"></i> Keluar dari Akun
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 16px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">

            <div style="background: linear-gradient(135deg, #4e73df, #224abe); padding: 20px 24px; display: flex; align-items: center; justify-content: space-between;">
                <div class="d-flex align-items-center" style="gap: 10px;">
                    <div style="background: rgba(255,255,255,0.2); border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center;">
                        <i class="mdi mdi-camera text-white" style="font-size: 18px;"></i>
                    </div>
                    <h5 class="text-white mb-0 font-weight-bold" style="font-size: 15px;">Unggah Foto Profil</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="filter: brightness(0) invert(1); opacity: 0.8;"></button>
            </div>

            <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-4">

                    <div class="text-center mb-4">
                        <div style="position: relative; display: inline-block;">
                            <img id="avatar-preview-modal"
                                 src="{{ $user->avatar_url }}"
                                 alt="Pratinjau"
                                 style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #e8f0fe;">
                            <div style="position: absolute; bottom: 2px; right: 2px; background: #4e73df; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; border: 2px solid #fff;">
                                <i class="mdi mdi-camera text-white" style="font-size: 12px;"></i>
                            </div>
                        </div>
                        <p class="text-muted mt-2 mb-0" style="font-size: 12px;">Pratinjau foto</p>
                    </div>

                    <div class="form-group mb-3">
                        <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">Pilih Gambar</label>
                        <input type="file"
                               class="form-control @error('avatar') is-invalid @enderror"
                               id="avatar"
                               name="avatar"
                               accept="image/*"
                               onchange="previewAvatar(this)"
                               style="border-radius: 8px; border-color: #d1d3e2; font-size: 13px;">
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted" style="font-size: 11px;">Format: JPG, PNG, GIF &mdash; Maks. 2MB</small>
                    </div>

                </div>

                <div class="px-4 pb-4 d-flex justify-content-end" style="gap: 8px;">
                    <button type="button"
                            data-bs-dismiss="modal"
                            style="background: #f4f6fb; color: #6b7280; border-radius: 8px; font-weight: 600; font-size: 13px; padding: 9px 18px; border: 1px solid #e3e6f0; cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.background='#e3e6f0';"
                            onmouseout="this.style.background='#f4f6fb';">
                        <i class="mdi mdi-close mr-1"></i> Batal
                    </button>
                    <button type="submit"
                            style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 8px; font-weight: 600; font-size: 13px; padding: 9px 18px; border: none; box-shadow: 0 4px 12px rgba(78,115,223,0.3); cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.opacity='0.9';"
                            onmouseout="this.style.opacity='1';">
                        <i class="mdi mdi-upload mr-1"></i> Unggah Sekarang
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@push('scripts')
<script>
    /* ===== AVATAR PREVIEW ===== */
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('avatar-preview-modal').src = e.target.result;
                document.getElementById('avatar-preview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    /* ===== TOGGLE PASSWORD VISIBILITY ===== */
    function togglePwd(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon  = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'mdi mdi-eye-off-outline';
        } else {
            input.type = 'password';
            icon.className = 'mdi mdi-eye-outline';
        }
    }

    /* ===== PASSWORD STRENGTH ===== */
    function checkStrength(val) {
        const wrap  = document.getElementById('strengthWrap');
        const bar   = document.getElementById('strengthBar');
        const label = document.getElementById('strengthLabel');

        if (!val) { wrap.style.display = 'none'; return; }
        wrap.style.display = 'block';

        let score = 0;
        if (val.length >= 8)              score++;
        if (/[A-Z]/.test(val))            score++;
        if (/[0-9]/.test(val))            score++;
        if (/[^A-Za-z0-9]/.test(val))     score++;

        const levels = [
            { width: '25%', color: '#e74a3b', text: 'Sangat lemah' },
            { width: '50%', color: '#f6c23e', text: 'Lemah' },
            { width: '75%', color: '#4e73df', text: 'Cukup kuat' },
            { width: '100%', color: '#1cc88a', text: 'Kuat' },
        ];
        const lvl = levels[score - 1] || levels[0];
        bar.style.width = lvl.width;
        bar.style.background = lvl.color;
        label.textContent = lvl.text;
        label.style.color = lvl.color;
    }

    /* ===== AUTO-RELOAD AFTER AVATAR CHANGE ===== */
    @if(session('status') === 'avatar-updated' || session('status') === 'avatar-deleted')
        setTimeout(() => location.reload(), 2000);
    @endif
</script>
@endpush

@endsection