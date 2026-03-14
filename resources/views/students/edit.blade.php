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
                                <i class="mdi mdi-account-edit-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Edit Siswa</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Perbarui informasi <strong class="text-white">{{ $student->name }}</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end" style="gap: 8px;">
                        <a href="{{ route('students.show', $student) }}"
                           class="btn font-weight-bold"
                           style="background: rgba(255,255,255,0.15); color: #fff; border-radius: 8px; font-size: 13px; border: 1px solid rgba(255,255,255,0.3);">
                            <i class="mdi mdi-eye mr-1"></i> Lihat
                        </a>
                        <a href="{{ route('students.index') }}"
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

{{-- Student summary strip --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body py-3 px-4">
                <div class="d-flex align-items-center" style="gap: 14px;">
                    <img src="{{ $student->avatar_url }}" alt="{{ $student->name }}"
                         style="width: 46px; height: 46px; border-radius: 50%; object-fit: cover; border: 2px solid #e8f0fe; flex-shrink: 0;">
                    <div>
                        <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">{{ $student->name }}</p>
                        <small class="text-muted">ID #{{ $student->id }} &bull; {{ $student->enrollments->count() }} mata pelajaran &bull; Bergabung {{ $student->created_at->format('d M Y') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    {{-- ===== FORM ===== --}}
    <div class="col-md-8 mb-4">
        <form action="{{ route('students.update', $student) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Section: Informasi Siswa --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-account-outline" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Informasi Siswa</h5>
                            <small class="text-muted">Data pribadi dan kontak</small>
                        </div>
                    </div>
                    <div class="p-4">

                        {{-- Nama --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-account-outline mr-1 text-muted"></i> Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $student->name) }}" required
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                   onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                   onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Email --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-email-outline mr-1 text-muted"></i> Alamat Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" name="email" id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $student->email) }}" required
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                   onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                   onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted" style="font-size: 11px;">Digunakan untuk login dan notifikasi</small>
                        </div>

                        {{-- Telepon --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-phone-outline mr-1 text-muted"></i> Nomor Telepon
                            </label>
                            <input type="text" name="phone" id="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   placeholder="Contoh: 08123456789"
                                   value="{{ old('phone', $student->phone) }}"
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                   onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                   onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- NISN --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-card-account-details-outline mr-1 text-muted"></i> NISN
                            </label>
                            <input type="text" name="nisn" id="nisn"
                                   class="form-control @error('nisn') is-invalid @enderror"
                                   placeholder="Masukkan NISN siswa"
                                   value="{{ old('nisn', $student->nisn ?? '') }}"
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                   onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                   onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                            @error('nisn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Tingkat --}}
                        <div class="form-group mb-0">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-signal-cellular-outline mr-1 text-muted"></i> Tingkat Siswa
                            </label>
                            <div style="position: relative;">
                                <select name="level" id="level"
                                        class="form-control @error('level') is-invalid @enderror"
                                        style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px; appearance: none; -webkit-appearance: none; padding-right: 36px; cursor: pointer;"
                                        onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                        onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                                    <option value="">— Pilih tingkat (opsional) —</option>
                                    <option value="beginner"     {{ old('level', $student->level) == 'beginner'     ? 'selected' : '' }}>Pemula</option>
                                    <option value="intermediate" {{ old('level', $student->level) == 'intermediate' ? 'selected' : '' }}>Menengah</option>
                                    <option value="advanced"     {{ old('level', $student->level) == 'advanced'     ? 'selected' : '' }}>Lanjutan</option>
                                </select>
                                <div style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                                    <i class="mdi mdi-chevron-down" style="font-size: 18px; color: #adb5bd;"></i>
                                </div>
                            </div>
                            @error('level') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                    </div>
                </div>
            </div>

            {{-- Section: Kata Sandi (Opsional) --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                        <div style="background: #fde8e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-lock-outline" style="font-size: 18px; color: #e74a3b;"></i>
                        </div>
                        <div style="flex: 1;">
                            <h5 class="mb-0 font-weight-bold text-dark">Ganti Kata Sandi</h5>
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                        </div>
                        <span style="background: #f4f6fb; color: #858796; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">Opsional</span>
                    </div>
                    <div class="p-4">
                        {{-- Password --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">Kata Sandi Baru</label>
                            <div style="position: relative;">
                                <input type="password" name="password" id="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Isi jika ingin mengganti"
                                       style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px; padding-right: 44px;"
                                       onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                       onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';"
                                       oninput="checkStrength(this.value)">
                                <button type="button" onclick="togglePwd('password', this)"
                                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #adb5bd; cursor: pointer; padding: 0;">
                                    <i class="mdi mdi-eye-outline" style="font-size: 18px;"></i>
                                </button>
                            </div>
                            @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            <div id="strengthWrap" style="display: none; margin-top: 8px;">
                                <div style="height: 4px; background: #e3e6f0; border-radius: 4px; overflow: hidden;">
                                    <div id="strengthBar" style="height: 100%; width: 0; border-radius: 4px; transition: all 0.3s;"></div>
                                </div>
                                <small id="strengthLabel" style="font-size: 11px;"></small>
                            </div>
                        </div>
                        {{-- Confirm --}}
                        <div class="form-group mb-0">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">Konfirmasi Kata Sandi Baru</label>
                            <div style="position: relative;">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="form-control" placeholder="Ulangi kata sandi baru"
                                       style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px; padding-right: 44px;"
                                       onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                       onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';"
                                       oninput="checkMatch()">
                                <button type="button" onclick="togglePwd('password_confirmation', this)"
                                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #adb5bd; cursor: pointer; padding: 0;">
                                    <i class="mdi mdi-eye-outline" style="font-size: 18px;"></i>
                                </button>
                            </div>
                            <small id="matchLabel" style="font-size: 11px; display: none;"></small>
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
                            Perubahan diterapkan langsung setelah disimpan
                        </p>
                        <div class="d-flex" style="gap: 8px;">
                            <a href="{{ route('students.show', $student) }}" class="btn"
                               style="background: #f4f6fb; color: #6b7280; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 20px; border: 1px solid #e3e6f0; transition: all 0.2s;"
                               onmouseover="this.style.background='#e3e6f0';" onmouseout="this.style.background='#f4f6fb';">
                                <i class="mdi mdi-close mr-1"></i> Batal
                            </a>
                            <button type="submit"
                                    style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 22px; border: none; box-shadow: 0 4px 12px rgba(78,115,223,0.3); cursor: pointer;"
                                    onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                                <i class="mdi mdi-content-save-outline mr-1"></i> Perbarui Siswa
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

    {{-- ===== SIDEBAR ===== --}}
    <div class="col-md-4 mb-4">

        {{-- Stats --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-chart-bar" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Statistik Siswa</h5>
                </div>
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #f0f0f3;">
                        <span class="text-muted" style="font-size: 13px;"><i class="mdi mdi-book-outline mr-1"></i>Mata Pelajaran</span>
                        <span style="font-size: 18px; font-weight: 700; color: #4e73df;">{{ $student->enrollments->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #f0f0f3;">
                        <span class="text-muted" style="font-size: 13px;"><i class="mdi mdi-check-circle-outline mr-1"></i>Selesai</span>
                        <span style="font-size: 18px; font-weight: 700; color: #1cc88a;">{{ $student->enrollments->where('completed_at', '!=', null)->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2">
                        <span class="text-muted" style="font-size: 13px;"><i class="mdi mdi-calendar-outline mr-1"></i>Bergabung</span>
                        <span class="font-weight-bold text-dark" style="font-size: 13px;">{{ $student->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e3f9e5; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-account-check-outline" style="font-size: 18px; color: #1cc88a;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Status Akun</h5>
                </div>
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #f0f0f3;">
                        <span class="text-muted" style="font-size: 13px;">Status Email</span>
                        @if($student->email_verified_at)
                            <span style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">Terverifikasi</span>
                        @else
                            <span style="background: #fff3e8; color: #f6c23e; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">Belum</span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #f0f0f3;">
                        <span class="text-muted" style="font-size: 13px;">Status Akun</span>
                        @if($student->enrollments->count() > 0)
                            <span style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">Aktif</span>
                        @else
                            <span style="background: #f4f6fb; color: #858796; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">Tidak Aktif</span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2">
                        <span class="text-muted" style="font-size: 13px;">Terakhir Update</span>
                        <small class="text-muted">{{ $student->updated_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Danger Zone --}}
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border: 1px solid #fdd !important;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #fdd; background: #fff5f5; border-radius: 12px 12px 0 0;">
                    <div style="background: #fde8e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-alert-outline" style="font-size: 18px; color: #e74a3b;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold" style="color: #e74a3b;">Zona Berbahaya</h5>
                </div>
                <div class="p-4">
                    <p class="text-muted mb-3" style="font-size: 12.5px;">Menghapus siswa ini akan menghapus akun dan semua data terkait secara permanen.</p>

                    @if($student->enrollments->count() > 0)
                    <div class="mb-3 p-3" style="background: #fff8e8; border-radius: 8px; border: 1px solid #fde68a;">
                        <p class="mb-0" style="font-size: 12px; color: #b8860b;">
                            <i class="mdi mdi-alert-circle-outline mr-1"></i>
                            Siswa ini memiliki <strong>{{ $student->enrollments->count() }} pendaftaran</strong>. Hapus semua pendaftaran terlebih dahulu.
                        </p>
                    </div>
                    @endif

                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="m-0"
                          onsubmit="confirmDelete(event, 'Akun siswa ini akan dihapus permanen. Tindakan ini tidak dapat dibatalkan!');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-block"
                                style="background: #fff5f5; color: #e74a3b; border-radius: 8px; font-weight: 600; font-size: 13px; padding: 10px; border: 1px solid #fdd; width: 100%; transition: all 0.2s;"
                                {{ $student->enrollments->count() > 0 ? 'disabled' : '' }}
                                onmouseover="if(!this.disabled){this.style.background='#e74a3b';this.style.color='#fff';}"
                                onmouseout="if(!this.disabled){this.style.background='#fff5f5';this.style.color='#e74a3b';}">
                            <i class="mdi mdi-delete mr-1"></i> Hapus Siswa
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function togglePwd(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') { input.type = 'text'; icon.className = 'mdi mdi-eye-off-outline'; }
        else { input.type = 'password'; icon.className = 'mdi mdi-eye-outline'; }
    }
    function checkStrength(val) {
        const wrap = document.getElementById('strengthWrap');
        const bar = document.getElementById('strengthBar');
        const label = document.getElementById('strengthLabel');
        if (!val) { wrap.style.display = 'none'; return; }
        wrap.style.display = 'block';
        let score = 0;
        if (val.length >= 8) score++; if (/[A-Z]/.test(val)) score++; if (/[0-9]/.test(val)) score++; if (/[^A-Za-z0-9]/.test(val)) score++;
        const levels = [{w:'25%',c:'#e74a3b',t:'Sangat lemah'},{w:'50%',c:'#f6c23e',t:'Lemah'},{w:'75%',c:'#4e73df',t:'Cukup kuat'},{w:'100%',c:'#1cc88a',t:'Kuat'}];
        const lvl = levels[score-1]||levels[0];
        bar.style.width = lvl.w; bar.style.background = lvl.c; label.textContent = lvl.t; label.style.color = lvl.c;
        checkMatch();
    }
    function checkMatch() {
        const pw = document.getElementById('password').value;
        const conf = document.getElementById('password_confirmation').value;
        const lbl = document.getElementById('matchLabel');
        if (!conf) { lbl.style.display = 'none'; return; }
        lbl.style.display = 'inline';
        lbl.textContent = pw === conf ? '✓ Kata sandi cocok' : '✗ Kata sandi tidak cocok';
        lbl.style.color = pw === conf ? '#1cc88a' : '#e74a3b';
    }
</script>
@endpush

@endsection