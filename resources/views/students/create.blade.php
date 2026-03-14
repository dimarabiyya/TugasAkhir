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
                                <i class="mdi mdi-account-plus-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Tambah Siswa Baru</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Buat akun baru untuk siswa</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
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

<div class="row">

    {{-- ===== FORM ===== --}}
    <div class="col-md-8 mb-4">
        <form action="{{ route('students.store') }}" method="POST">
            @csrf

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
                                   placeholder="Masukkan nama lengkap siswa"
                                   value="{{ old('name') }}" required
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
                                   placeholder="Masukkan alamat email siswa"
                                   value="{{ old('email') }}" required
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
                                   value="{{ old('phone') }}"
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
                                   value="{{ old('nisn') }}"
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
                                    <option value="beginner"     {{ old('level') == 'beginner'     ? 'selected' : '' }}>Pemula</option>
                                    <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>Menengah</option>
                                    <option value="advanced"     {{ old('level') == 'advanced'     ? 'selected' : '' }}>Lanjutan</option>
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

            {{-- Section: Kata Sandi --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                        <div style="background: #fde8e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-lock-outline" style="font-size: 18px; color: #e74a3b;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Kata Sandi</h5>
                            <small class="text-muted">Minimal 8 karakter</small>
                        </div>
                    </div>
                    <div class="p-4">

                        {{-- Password --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                Kata Sandi <span class="text-danger">*</span>
                            </label>
                            <div style="position: relative;">
                                <input type="password" name="password" id="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Minimal 8 karakter" required
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
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                Konfirmasi Kata Sandi <span class="text-danger">*</span>
                            </label>
                            <div style="position: relative;">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="form-control" placeholder="Ulangi kata sandi" required
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
                            Siswa akan mendapat role <strong>Siswa</strong> secara otomatis
                        </p>
                        <div class="d-flex" style="gap: 8px;">
                            <a href="{{ route('students.index') }}" class="btn"
                               style="background: #f4f6fb; color: #6b7280; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 20px; border: 1px solid #e3e6f0; transition: all 0.2s;"
                               onmouseover="this.style.background='#e3e6f0';" onmouseout="this.style.background='#f4f6fb';">
                                <i class="mdi mdi-close mr-1"></i> Batal
                            </a>
                            <button type="submit"
                                    style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 22px; border: none; box-shadow: 0 4px 12px rgba(78,115,223,0.3); cursor: pointer;"
                                    onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                                <i class="mdi mdi-content-save-outline mr-1"></i> Buat Siswa
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

    {{-- ===== SIDEBAR ===== --}}
    <div class="col-md-4 mb-4">

        {{-- Info --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e0f7fa; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-information-outline" style="font-size: 18px; color: #17a2b8;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Info Akun Siswa</h5>
                </div>
                <div class="p-4">
                    @foreach([
                        ['icon' => 'mdi-account-outline',  'c' => '#4e73df', 'title' => 'Peran Siswa',           'desc' => "Otomatis ditetapkan sebagai 'Siswa'"],
                        ['icon' => 'mdi-email-outline',     'c' => '#1cc88a', 'title' => 'Verifikasi Email',      'desc' => 'Siswa perlu memverifikasi email mereka'],
                        ['icon' => 'mdi-book-outline',      'c' => '#f6c23e', 'title' => 'Akses Mata Pelajaran',  'desc' => 'Dapat mendaftar ke kursus yang tersedia'],
                        ['icon' => 'mdi-chart-line',        'c' => '#e74a3b', 'title' => 'Pelacakan Kemajuan',    'desc' => 'Progress belajar tercatat otomatis'],
                    ] as $item)
                    <div class="d-flex align-items-start mb-3" style="gap: 10px;">
                        <div style="background: {{ $item['c'] }}20; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="mdi {{ $item['icon'] }}" style="font-size: 17px; color: {{ $item['c'] }};"></i>
                        </div>
                        <div>
                            <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px;">{{ $item['title'] }}</p>
                            <small class="text-muted">{{ $item['desc'] }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Level Guide --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #fff3e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-school-outline" style="font-size: 18px; color: #f6c23e;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Panduan Tingkat</h5>
                </div>
                <div class="p-4">
                    @foreach([
                        ['bg'=>'#e3f9e5','c'=>'#1cc88a','label'=>'Pemula',   'desc'=>'Baru dalam materi pelajaran'],
                        ['bg'=>'#fff3e8','c'=>'#f6c23e','label'=>'Menengah', 'desc'=>'Memiliki pengetahuan dasar'],
                        ['bg'=>'#fde8e8','c'=>'#e74a3b','label'=>'Lanjutan', 'desc'=>'Berpengalaman dan mahir'],
                    ] as $lvl)
                    <div class="d-flex align-items-center mb-3 p-2" style="background: #f8f9fc; border-radius: 8px;">
                        <span style="background: {{ $lvl['bg'] }}; color: {{ $lvl['c'] }}; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700; flex-shrink: 0; margin-right: 10px;">{{ $lvl['label'] }}</span>
                        <small class="text-muted">{{ $lvl['desc'] }}</small>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Quick Stats --}}
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e3f9e5; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-chart-bar" style="font-size: 18px; color: #1cc88a;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Statistik Cepat</h5>
                </div>
                <div class="p-4">
                    @foreach([
                        ['label'=>'Total Siswa',       'val'=> \App\Models\User::role('student')->count(),                                    'c'=>'#4e73df'],
                        ['label'=>'Siswa Aktif',        'val'=> \App\Models\User::role('student')->whereHas('enrollments')->count(),            'c'=>'#1cc88a'],
                        ['label'=>'Belum Verifikasi',   'val'=> \App\Models\User::role('student')->whereNull('email_verified_at')->count(),     'c'=>'#f6c23e'],
                    ] as $s)
                    <div class="d-flex align-items-center justify-content-between py-2" style="border-bottom: 1px solid #f0f0f3;">
                        <span class="text-muted" style="font-size: 13px;">{{ $s['label'] }}</span>
                        <span style="font-size: 18px; font-weight: 700; color: {{ $s['c'] }};">{{ $s['val'] }}</span>
                    </div>
                    @endforeach
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