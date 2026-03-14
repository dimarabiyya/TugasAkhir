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
                                <h4 class="font-weight-bold text-white mb-0">Edit Data Guru</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Perbarui informasi akun <strong class="text-white">{{ $instructor->name }}</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('instructors.index') }}"
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

{{-- ===== FORM ===== --}}
<div class="row justify-content-center">
    <div class="col-md-12">
        <form action="{{ route('instructors.update', $instructor->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Section: Informasi Guru --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-0">

                    <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-account-outline" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Informasi Guru</h5>
                            <small class="text-muted">Nama lengkap dan alamat email guru</small>
                        </div>
                    </div>

                    <div class="p-4">

                        {{-- Nama --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-account-outline mr-1 text-muted"></i> Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $instructor->name) }}"
                                   required
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                   onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                   onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="form-group mb-0">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-email-outline mr-1 text-muted"></i> Alamat Email <span class="text-danger">*</span>
                            </label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $instructor->email) }}"
                                   required
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                   onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                   onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            {{-- Section: Ganti Kata Sandi (Opsional) --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-0">

                    <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                        <div style="background: #fde8e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-lock-outline" style="font-size: 18px; color: #e74a3b;"></i>
                        </div>
                        <div style="flex: 1;">
                            <h5 class="mb-0 font-weight-bold text-dark">Ganti Kata Sandi</h5>
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah kata sandi</small>
                        </div>
                        {{-- Optional badge --}}
                        <span style="background: #f4f6fb; color: #858796; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">
                            Opsional
                        </span>
                    </div>

                    <div class="p-4">

                        {{-- Password Baru --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-lock-plus-outline mr-1 text-muted"></i> Kata Sandi Baru
                            </label>
                            <div style="position: relative;">
                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Isi jika ingin mengganti kata sandi"
                                       style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px; padding-right: 44px;"
                                       onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                       onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';"
                                       oninput="checkStrength(this.value)">
                                <button type="button" onclick="togglePwd('password', this)"
                                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #adb5bd; cursor: pointer; padding: 0;">
                                    <i class="mdi mdi-eye-outline" style="font-size: 18px;"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            {{-- Strength bar --}}
                            <div id="strengthWrap" style="display: none; margin-top: 8px;">
                                <div style="height: 4px; background: #e3e6f0; border-radius: 4px; overflow: hidden;">
                                    <div id="strengthBar" style="height: 100%; width: 0; border-radius: 4px; transition: all 0.3s;"></div>
                                </div>
                                <small id="strengthLabel" style="font-size: 11px;"></small>
                            </div>
                        </div>

                        {{-- Konfirmasi --}}
                        <div class="form-group mb-0">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-lock-check-outline mr-1 text-muted"></i> Konfirmasi Kata Sandi Baru
                            </label>
                            <div style="position: relative;">
                                <input type="password"
                                       name="password_confirmation"
                                       id="password_confirmation"
                                       class="form-control"
                                       placeholder="Ulangi kata sandi baru"
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
                            Perubahan akan langsung diterapkan setelah disimpan
                        </p>
                        <div class="d-flex" style="gap: 8px;">
                            <a href="{{ route('instructors.index') }}"
                               class="btn"
                               style="background: #f4f6fb; color: #6b7280; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 20px; border: 1px solid #e3e6f0; transition: all 0.2s;"
                               onmouseover="this.style.background='#e3e6f0';"
                               onmouseout="this.style.background='#f4f6fb';">
                                <i class="mdi mdi-close mr-1"></i> Batal
                            </a>
                            <button type="submit"
                                    style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 22px; border: none; box-shadow: 0 4px 12px rgba(78,115,223,0.3); transition: all 0.2s; cursor: pointer;"
                                    onmouseover="this.style.opacity='0.9';"
                                    onmouseout="this.style.opacity='1';">
                                <i class="mdi mdi-content-save-outline mr-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>
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

    function checkStrength(val) {
        const wrap  = document.getElementById('strengthWrap');
        const bar   = document.getElementById('strengthBar');
        const label = document.getElementById('strengthLabel');
        if (!val) { wrap.style.display = 'none'; return; }
        wrap.style.display = 'block';
        let score = 0;
        if (val.length >= 8)           score++;
        if (/[A-Z]/.test(val))         score++;
        if (/[0-9]/.test(val))         score++;
        if (/[^A-Za-z0-9]/.test(val))  score++;
        const levels = [
            { w: '25%',  c: '#e74a3b', t: 'Sangat lemah' },
            { w: '50%',  c: '#f6c23e', t: 'Lemah' },
            { w: '75%',  c: '#4e73df', t: 'Cukup kuat' },
            { w: '100%', c: '#1cc88a', t: 'Kuat' },
        ];
        const lvl = levels[score - 1] || levels[0];
        bar.style.width      = lvl.w;
        bar.style.background = lvl.c;
        label.textContent    = lvl.t;
        label.style.color    = lvl.c;
        checkMatch();
    }

    function checkMatch() {
        const pw   = document.getElementById('password').value;
        const conf = document.getElementById('password_confirmation').value;
        const lbl  = document.getElementById('matchLabel');
        if (!conf) { lbl.style.display = 'none'; return; }
        lbl.style.display = 'inline';
        if (pw === conf) {
            lbl.textContent = '✓ Kata sandi cocok';
            lbl.style.color = '#1cc88a';
        } else {
            lbl.textContent = '✗ Kata sandi tidak cocok';
            lbl.style.color = '#e74a3b';
        }
    }
</script>
@endpush

@endsection