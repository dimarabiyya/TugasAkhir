<x-guest-layout>

<style>
/* ── Import MDI just in case ── */
/* Assumes MDI is already loaded via dashboard layout */

/* ── Overrides scoped to this form ── */
.auth-form-wrap * { box-sizing: border-box; }

/* Header */
.auth-header {
    text-align: center;
    margin-bottom: 28px;
}
.auth-icon-wrap {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #4e73df, #224abe);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 14px;
    box-shadow: 0 6px 18px rgba(78,115,223,0.35);
}
.auth-icon-wrap i {
    font-size: 30px;
    color: #fff;
}
.auth-title {
    font-size: 20px;
    font-weight: 800;
    color: #1a1a2e;
    letter-spacing: -0.3px;
    margin-bottom: 4px;
}
.auth-subtitle {
    font-size: 13px;
    color: #858796;
}

/* Status alert */
.auth-alert {
    background: #e3f9e5;
    border: 1px solid #c3e6cb;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 13px;
    color: #1cc88a;
    font-weight: 500;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Field group */
.auth-field {
    margin-bottom: 16px;
}
.auth-label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.7px;
    color: #858796;
    margin-bottom: 7px;
}
.auth-input-wrap {
    position: relative;
}
.auth-input-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #adb5bd;
    pointer-events: none;
    display: flex;
    align-items: center;
}
.auth-input-icon i { font-size: 17px; }

.auth-input {
    display: block;
    width: 100%;
    font-size: 13.5px;
    color: #2d3748;
    background: #f8f9fc;
    border: 1.5px solid #e3e6f0;
    border-radius: 10px;
    padding: 11px 42px;
    outline: none;
    transition: all 0.2s;
    -webkit-appearance: none;
}
.auth-input::placeholder {
    color: #c4c6d0;
    font-size: 13px;
}
.auth-input:hover  { border-color: #b0bdf8; }
.auth-input:focus  {
    background: #fff;
    border-color: #4e73df;
    box-shadow: 0 0 0 3px rgba(78,115,223,0.12);
}
.auth-input.is-error {
    border-color: #e74a3b;
    background: #fff8f7;
}

/* Password toggle button */
.pwd-eye {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    color: #adb5bd;
    display: flex;
    align-items: center;
    transition: color 0.15s;
}
.pwd-eye:hover { color: #4e73df; }
.pwd-eye i { font-size: 17px; }

/* Field error */
.auth-error {
    font-size: 12px;
    color: #e74a3b;
    margin-top: 5px;
    display: flex;
    align-items: center;
    gap: 4px;
}
.auth-error i { font-size: 13px; }

/* Remember + forgot row */
.auth-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}
.auth-remember {
    display: flex;
    align-items: center;
    gap: 7px;
    cursor: pointer;
}
.auth-remember input[type="checkbox"] {
    width: 15px;
    height: 15px;
    accent-color: #4e73df;
    cursor: pointer;
    border-radius: 4px;
}
.auth-remember span {
    font-size: 13px;
    font-weight: 500;
    color: #5a5c69;
    user-select: none;
}
.auth-forgot {
    font-size: 13px;
    font-weight: 600;
    color: #4e73df;
    text-decoration: none;
    transition: color 0.15s;
}
.auth-forgot:hover { color: #224abe; text-decoration: underline; }

/* Submit button */
.auth-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    background: linear-gradient(135deg, #4e73df, #224abe);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 13px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 4px 14px rgba(78,115,223,0.3);
    letter-spacing: 0.2px;
}
.auth-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(78,115,223,0.4);
    opacity: 0.95;
}
.auth-btn:active { transform: translateY(0); }
.auth-btn i { font-size: 18px; }

/* Divider */
.auth-divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 20px 0 16px;
}
.auth-divider-line {
    flex: 1;
    height: 1px;
    background: #e3e6f0;
}
.auth-divider-text {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #adb5bd;
    white-space: nowrap;
}

/* Demo credentials */
.demo-box {
    background: #f8f9fc;
    border: 1px solid #e3e6f0;
    border-radius: 10px;
    padding: 14px;
}
.demo-box-title {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #adb5bd;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 5px;
}
.demo-box-title i { font-size: 13px; color: #4e73df; }
.demo-grid {
    display: flex;
    gap: 8px;
}
.demo-pill {
    flex: 1;
    background: #fff;
    border: 1.5px solid #e3e6f0;
    border-radius: 9px;
    padding: 9px 8px;
    text-align: center;
    cursor: pointer;
    transition: all 0.18s;
}
.demo-pill:hover {
    border-color: #4e73df;
    background: #f0f4ff;
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(78,115,223,0.12);
}
.demo-pill-role {
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    margin-bottom: 3px;
}
.demo-pill-role.r-admin    { color: #e74a3b; }
.demo-pill-role.r-guru     { color: #f6c23e; }
.demo-pill-role.r-siswa    { color: #1cc88a; }
.demo-pill-email {
    font-size: 10.5px;
    color: #858796;
    margin-bottom: 2px;
    word-break: break-all;
}
.demo-pill-pass {
    font-size: 10px;
    color: #4e73df;
    font-weight: 600;
}

/* Shake animation */
@keyframes lms-shake {
    0%,100% { transform: translateX(0); }
    20%      { transform: translateX(-5px); }
    40%      { transform: translateX(5px); }
    60%      { transform: translateX(-3px); }
    80%      { transform: translateX(3px); }
}
.lms-shake { animation: lms-shake 0.35s ease; }
</style>

<div class="auth-form-wrap">

    {{-- ── Header ── --}}
    <div class="auth-header">
        <div class="auth-icon-wrap">
            <i class="mdi mdi-school"></i>
        </div>
        <div class="auth-title">Selamat Datang!</div>
        <div class="auth-subtitle">Masuk untuk melanjutkan belajar</div>
    </div>

    {{-- ── Session status ── --}}
    @if (session('status'))
    <div class="auth-alert">
        <i class="mdi mdi-check-circle-outline"></i>
        {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email / NISN --}}
        <div class="auth-field {{ $errors->get('login') ? 'lms-shake' : '' }}">
            <label class="auth-label" for="login">Email atau NISN</label>
            <div class="auth-input-wrap">
                <span class="auth-input-icon"><i class="mdi mdi-account-outline"></i></span>
                <input
                    id="login" name="login" type="text"
                    class="auth-input {{ $errors->get('login') ? 'is-error' : '' }}"
                    value="{{ old('login') }}"
                    placeholder="Masukkan email atau NISN"
                    required autofocus autocomplete="username">
            </div>
            @foreach ($errors->get('login') as $msg)
                <div class="auth-error">
                    <i class="mdi mdi-alert-circle-outline"></i> {{ $msg }}
                </div>
            @endforeach
        </div>

        {{-- Password --}}
        <div class="auth-field {{ $errors->get('password') ? 'lms-shake' : '' }}">
            <label class="auth-label" for="password">Password</label>
            <div class="auth-input-wrap">
                <span class="auth-input-icon"><i class="mdi mdi-lock-outline"></i></span>
                <input
                    id="password-field" name="password" type="password"
                    class="auth-input {{ $errors->get('password') ? 'is-error' : '' }}"
                    placeholder="Masukkan password"
                    required autocomplete="current-password">
                <button type="button" class="pwd-eye" onclick="togglePwd()" tabindex="-1">
                    <i class="mdi mdi-eye-outline" id="pwd-eye-icon"></i>
                </button>
            </div>
            @foreach ($errors->get('password') as $msg)
                <div class="auth-error">
                    <i class="mdi mdi-alert-circle-outline"></i> {{ $msg }}
                </div>
            @endforeach
        </div>

        {{-- Remember + Forgot --}}
        <div class="auth-meta">
            <label class="auth-remember">
                <input type="checkbox" name="remember" id="remember_me">
                <span>Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-forgot">Lupa password?</a>
            @endif
        </div>

        {{-- Submit --}}
        <button type="submit" class="auth-btn {{ $errors->any() ? 'lms-shake' : '' }}">
            <i class="mdi mdi-login-variant"></i>
            Masuk Sekarang
        </button>

        {{-- Demo Credentials --}}
        <div class="auth-divider">
            <div class="auth-divider-line"></div>
            <div class="auth-divider-text">Akun Demo</div>
            <div class="auth-divider-line"></div>
        </div>

        <div class="demo-box">
            <div class="demo-box-title">
                <i class="mdi mdi-cursor-default-click-outline"></i>
                Klik untuk isi otomatis
            </div>
            <div class="demo-grid">
                <div class="demo-pill" onclick="fillDemo('admin@lms.com')">
                    <div class="demo-pill-role r-admin">Admin</div>
                    <div class="demo-pill-email">admin@lms.com</div>
                    <div class="demo-pill-pass">password</div>
                </div>
                <div class="demo-pill" onclick="fillDemo('instructor@lms.com')">
                    <div class="demo-pill-role r-guru">Guru</div>
                    <div class="demo-pill-email">instructor@lms.com</div>
                    <div class="demo-pill-pass">password</div>
                </div>
                <div class="demo-pill" onclick="fillDemo('student@lms.com')">
                    <div class="demo-pill-role r-siswa">Siswa</div>
                    <div class="demo-pill-email">student@lms.com</div>
                    <div class="demo-pill-pass">password</div>
                </div>
            </div>
        </div>

    </form>
</div>

<script>
function togglePwd() {
    var f = document.getElementById('password-field');
    var i = document.getElementById('pwd-eye-icon');
    if (f.type === 'password') {
        f.type = 'text';
        i.className = 'mdi mdi-eye-off-outline';
    } else {
        f.type = 'password';
        i.className = 'mdi mdi-eye-outline';
    }
}

function fillDemo(email) {
    document.getElementById('login').value          = email;
    document.getElementById('password-field').value = 'password';
}
</script>

</x-guest-layout>