@extends('layouts.skydash')

@push('styles')
<style>
    /* Prevent text selection during exam */
    #exam-viewport { user-select: none; -webkit-user-select: none; }

    /* Hide scrollbar on nav panel but keep scrollable */
    .question-nav-panel::-webkit-scrollbar { width: 3px; }
    .question-nav-panel::-webkit-scrollbar-thumb { background: #d1d3e2; border-radius: 4px; }

    /* Nav button states */
    .q-nav-btn {
        width: 36px; height: 36px;
        border-radius: 8px;
        border: 1.5px solid #d1d3e2;
        background: #fff;
        color: #858796;
        font-size: 12px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        flex-shrink: 0;
    }
    .q-nav-btn:hover { background: #e8f0fe; border-color: #4e73df; color: #4e73df; }
    .q-nav-btn.answered { background: #4e73df; border-color: #4e73df; color: #fff; box-shadow: 0 2px 6px rgba(78,115,223,.35); }
    .q-nav-btn.active { background: #fff; border-color: #4e73df; color: #4e73df; box-shadow: 0 0 0 3px rgba(78,115,223,.2); }
    .q-nav-btn.answered.active { background: #224abe; border-color: #224abe; color: #fff; box-shadow: 0 0 0 3px rgba(78,115,223,.25); }

    /* Option rows */
    .option-row {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 14px;
        border: 1.5px solid #eaecf4;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.18s;
        margin-bottom: 8px;
        background: #fff;
    }
    .option-row:hover { background: #f4f6fb; border-color: #c5d5f8; }
    .option-row.selected { background: #e8f0fe; border-color: #4e73df; }
    .option-row.selected .opt-badge { background: #4e73df; color: #fff; }
    .option-row input[type="radio"] { display: none; }

    .opt-badge {
        width: 30px; height: 30px; border-radius: 8px;
        background: #f0f0f3; color: #858796;
        font-size: 12px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; transition: all 0.18s;
    }

    /* Timer states */
    .timer-normal { color: #4e73df; }
    .timer-warn   { color: #f6c23e; }
    .timer-danger { color: #e74a3b; animation: timerPulse 1s infinite; }
    @keyframes timerPulse { 0%,100% { opacity:1; } 50% { opacity:.5; } }

    .sidebar, .navbar, .footer { display: none !important; }
    .main-panel { width: 100% !important; margin-left: 0 !important; padding-top: 0 !important; }
    .content-wrapper { padding: 20px !important; background: #f4f7ff !important; width: 100% !important; }
    body { padding-top: 0 !important; }
</style>
@endpush

@section('content')
<div id="exam-viewport">

    {{-- ===== TOP BAR ===== --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
        <div class="card-body py-3 px-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-7 mb-2 mb-md-0">
                    <div class="d-flex align-items-center" style="gap: 12px;">
                        <div style="background: rgba(255,255,255,0.2); border-radius: 10px; width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="mdi mdi-pencil-box-outline text-white" style="font-size: 22px;"></i>
                        </div>
                        <div>
                            <h5 class="font-weight-bold text-white mb-0" style="font-size: 15px;">{{ $exam->title }}</h5>
                            <p class="text-white-50 mb-0" style="font-size: 12px;">
                                {{ $exam->course->title }}
                                <span style="opacity:.4; margin: 0 5px;">|</span>
                                {{ $exam->questions->count() }} soal
                                <span style="opacity:.4; margin: 0 5px;">|</span>
                                {{ $exam->duration }} menit
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-5 d-flex justify-content-md-end align-items-center" style="gap: 16px;">
                    {{-- Progress --}}
                    <div style="display: flex; flex-direction: column; align-items: flex-end; min-width: 120px;">
                        <div class="d-flex align-items-center justify-content-between w-100 mb-1">
                            <small class="text-white-50" style="font-size: 10px;">Progress</small>
                            <small id="progressLabel" class="text-white" style="font-size: 10px; font-weight: 700;">0 / {{ $exam->questions->count() }}</small>
                        </div>
                        <div style="width: 120px; height: 5px; background: rgba(255,255,255,0.2); border-radius: 3px; overflow: hidden;">
                            <div id="progressBar" style="height: 100%; width: 0%; background: #fff; border-radius: 3px; transition: width 0.4s;"></div>
                        </div>
                    </div>
                    {{-- Timer --}}
                    <div style="background: rgba(255,255,255,0.15); border-radius: 10px; padding: 8px 14px; text-align: center; border: 1px solid rgba(255,255,255,0.2);">
                        <p class="text-white-50 mb-0" style="font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px;">Sisa Waktu</p>
                        <p id="timer" class="text-white mb-0 font-weight-bold" style="font-size: 18px; font-family: monospace; letter-spacing: 1px;">
                            {{ gmdate('H:i:s', $exam->duration * 60) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        {{-- ===== LEFT: Question Navigator ===== --}}
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; position: sticky; top: 20px;">

                <div class="card-body border-bottom py-3 px-4" style="background: #f8f9fc; border-radius: 12px 12px 0 0;">
                    <div class="d-flex align-items-center" style="gap: 8px;">
                        <div style="background: #e8f0fe; border-radius: 7px; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                            <i class="mdi mdi-view-grid-outline" style="font-size: 16px; color: #4e73df;"></i>
                        </div>
                        <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px;">Navigasi Soal</p>
                    </div>
                </div>

                <div class="card-body p-3">
                    <div class="question-nav-panel" style="display: flex; flex-wrap: wrap; gap: 6px; max-height: 220px; overflow-y: auto;">
                        @foreach($exam->questions as $index => $q)
                        <button type="button"
                                class="q-nav-btn {{ $index === 0 ? 'active' : '' }}"
                                id="nav-{{ $q->id }}"
                                data-index="{{ $index }}"
                                onclick="showQuestion({{ $index }})">
                            {{ $index + 1 }}
                        </button>
                        @endforeach
                    </div>

                    <div style="border-top: 1px solid #eaecf4; margin: 12px 0 10px;"></div>

                    {{-- Legend --}}
                    <div style="display: flex; flex-direction: column; gap: 6px;">
                        <div class="d-flex align-items-center" style="gap: 8px;">
                            <div style="width: 14px; height: 14px; border-radius: 4px; background: #4e73df; flex-shrink: 0;"></div>
                            <small class="text-muted" style="font-size: 11px;">Sudah dijawab</small>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 8px;">
                            <div style="width: 14px; height: 14px; border-radius: 4px; background: #fff; border: 1.5px solid #d1d3e2; flex-shrink: 0;"></div>
                            <small class="text-muted" style="font-size: 11px;">Belum dijawab</small>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 8px;">
                            <div style="width: 14px; height: 14px; border-radius: 4px; background: #fff; border: 2px solid #4e73df; flex-shrink: 0;"></div>
                            <small class="text-muted" style="font-size: 11px;">Soal aktif</small>
                        </div>
                    </div>

                    <div style="border-top: 1px solid #eaecf4; margin: 12px 0 0;"></div>

                    {{-- Submit button in sidebar --}}
                    <button type="button" onclick="submitExam()"
                            style="width: 100%; margin-top: 12px; padding: 10px; border-radius: 8px; border: none; background: linear-gradient(135deg, #1cc88a, #17a673); color: #fff; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; transition: opacity 0.2s; box-shadow: 0 4px 10px rgba(28,200,138,.3);"
                            onmouseover="this.style.opacity='0.9';"
                            onmouseout="this.style.opacity='1';">
                        <i class="mdi mdi-send-check-outline" style="font-size: 16px;"></i> Selesai Ujian
                    </button>
                </div>
            </div>
        </div>

        {{-- ===== RIGHT: Question Content ===== --}}
        <div class="col-md-9 mb-4">
            <form id="examForm" action="{{ route('exams.submit', $exam->id) }}" method="POST">
                @csrf

                @foreach($exam->questions as $index => $q)
                <div class="question-card {{ $index > 0 ? 'd-none' : '' }}" id="q-{{ $index }}">
                    <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px; overflow: hidden;">

                        {{-- Question header --}}
                        <div class="card-body border-bottom py-3 px-4" style="background: #f8f9fc;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center" style="gap: 10px;">
                                    <div style="background: #4e73df; color: #fff; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; flex-shrink: 0;">
                                        {{ $index + 1 }}
                                    </div>
                                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">Soal Nomor {{ $index + 1 }}</p>
                                </div>
                                <span style="font-size: 11px; color: #adb5bd;">{{ $index + 1 }} / {{ $exam->questions->count() }}</span>
                            </div>
                        </div>

                        {{-- Question body --}}
                        <div class="card-body p-4">
                            <p style="font-size: 15px; color: #2d3748; line-height: 1.7; font-weight: 500; margin-bottom: 20px;">{!! $q->question_text !!}</p>

                            <div class="options-list">
                                @foreach($q->options as $key => $value)
                                <label class="option-row {{ (isset($attempt->answers[$q->id]) && $attempt->answers[$q->id] == $key) ? 'selected' : '' }}"
                                       id="label-{{ $q->id }}-{{ $key }}"
                                       for="opt-{{ $q->id }}-{{ $key }}"
                                       onclick="selectOption(this, {{ $q->id }}, '{{ $key }}')">
                                    <input type="radio"
                                           name="answers[{{ $q->id }}]"
                                           id="opt-{{ $q->id }}-{{ $key }}"
                                           value="{{ $key }}"
                                           {{ (isset($attempt->answers[$q->id]) && $attempt->answers[$q->id] == $key) ? 'checked' : '' }}>
                                    <div class="opt-badge {{ (isset($attempt->answers[$q->id]) && $attempt->answers[$q->id] == $key) ? 'bg-primary text-white' : '' }}">{{ $key }}</div>
                                    <span style="font-size: 13.5px; color: #3d3d3d; line-height: 1.5;">{{ $value }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Navigation buttons --}}
                    <div class="d-flex align-items-center justify-content-between">
                        <button type="button" onclick="prevQuestion()"
                                style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; border-radius: 8px; border: 1.5px solid #d1d3e2; background: #fff; color: #858796; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s;"
                                onmouseover="this.style.background='#f0f0f3';"
                                onmouseout="this.style.background='#fff';">
                            <i class="mdi mdi-arrow-left" style="font-size: 16px;"></i> Sebelumnya
                        </button>

                        <span style="font-size: 12px; color: #adb5bd;">Soal {{ $index + 1 }} dari {{ $exam->questions->count() }}</span>

                        @if($index < $exam->questions->count() - 1)
                        <button type="button" onclick="nextQuestion()"
                                style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; border-radius: 8px; border: none; background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; font-size: 13px; font-weight: 600; cursor: pointer; transition: opacity 0.2s; box-shadow: 0 3px 8px rgba(78,115,223,.3);"
                                onmouseover="this.style.opacity='0.9';"
                                onmouseout="this.style.opacity='1';">
                            Selanjutnya <i class="mdi mdi-arrow-right" style="font-size: 16px;"></i>
                        </button>
                        @else
                        <button type="button" onclick="submitExam()"
                                style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; border-radius: 8px; border: none; background: linear-gradient(135deg, #1cc88a, #17a673); color: #fff; font-size: 13px; font-weight: 600; cursor: pointer; transition: opacity 0.2s; box-shadow: 0 3px 8px rgba(28,200,138,.3);"
                                onmouseover="this.style.opacity='0.9';"
                                onmouseout="this.style.opacity='1';">
                            <i class="mdi mdi-send-check-outline" style="font-size: 16px;"></i> Selesai & Kumpulkan
                        </button>
                        @endif
                    </div>
                </div>
                @endforeach

            </form>
        </div>

    </div>
</div>

@push('scripts')
<script>
    let currentQuestion = 0;
    const totalQuestions = {{ $exam->questions->count() }};
    let answeredCount = 0;
    const answeredSet = new Set();

    // ===== NAVIGASI SOAL =====
    function showQuestion(index) {
        // Hide all
        document.querySelectorAll('.question-card').forEach(el => el.classList.add('d-none'));
        document.getElementById(`q-${index}`).classList.remove('d-none');

        // Update nav buttons active state
        document.querySelectorAll('.q-nav-btn').forEach(btn => btn.classList.remove('active'));
        const navBtns = document.querySelectorAll(`.q-nav-btn[data-index="${index}"]`);
        navBtns.forEach(btn => btn.classList.add('active'));

        currentQuestion = index;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function nextQuestion() { if (currentQuestion < totalQuestions - 1) showQuestion(currentQuestion + 1); }
    function prevQuestion() { if (currentQuestion > 0) showQuestion(currentQuestion - 1); }

    // ===== PILIH JAWABAN =====
    function selectOption(label, questionId, key) {
        // Clear all options for this question
        document.querySelectorAll(`[id^="label-${questionId}-"]`).forEach(el => {
            el.classList.remove('selected');
            const badge = el.querySelector('.opt-badge');
            if (badge) { badge.style.background = '#f0f0f3'; badge.style.color = '#858796'; }
        });

        // Mark selected
        label.classList.add('selected');
        const badge = label.querySelector('.opt-badge');
        if (badge) { badge.style.background = '#4e73df'; badge.style.color = '#fff'; }

        // Mark nav button as answered
        const navBtn = document.getElementById(`nav-${questionId}`);
        if (navBtn && !answeredSet.has(questionId)) {
            navBtn.classList.add('answered');
            answeredSet.add(questionId);
            answeredCount++;
            updateProgress();
        }

        saveAnswer(questionId, key);
    }

    // ===== PROGRESS BAR =====
    function updateProgress() {
        const pct = Math.round((answeredSet.size / totalQuestions) * 100);
        document.getElementById('progressBar').style.width = pct + '%';
        document.getElementById('progressLabel').textContent = answeredSet.size + ' / ' + totalQuestions;
    }

    // ===== AUTO-SAVE =====
    function saveAnswer(questionId, answer) {
        fetch("{{ route('exams.saveProgress', $exam->id) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ question_id: questionId, answer: answer })
        }).catch(err => console.warn('Save failed:', err));
    }

    // ===== TIMER =====
    let timeRemaining = {{ $exam->duration * 60 }};
    const timerEl = document.getElementById('timer');

    const countdown = setInterval(() => {
        if (timeRemaining <= 0) {
            clearInterval(countdown);
            timerEl.textContent = '00:00:00';
            // Auto-submit
            document.getElementById('examForm').submit();
            return;
        }

        const h = Math.floor(timeRemaining / 3600);
        const m = Math.floor((timeRemaining % 3600) / 60);
        const s = timeRemaining % 60;
        timerEl.textContent = `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;

        // Color warning thresholds
        timerEl.className = 'text-white mb-0 font-weight-bold';
        if (timeRemaining <= 60) {
            timerEl.style.animation = 'timerPulse 1s infinite';
            timerEl.style.color = '#ff9999';
        } else if (timeRemaining <= 300) {
            timerEl.style.animation = '';
            timerEl.style.color = '#ffe066';
        } else {
            timerEl.style.animation = '';
            timerEl.style.color = '#fff';
        }

        timeRemaining--;
    }, 1000);

    // ===== SUBMIT WITH CONFIRMATION =====
    function submitExam() {
        const unanswered = totalQuestions - answeredSet.size;
        const msg = unanswered > 0
            ? `Masih ada ${unanswered} soal yang belum dijawab. Yakin ingin mengumpulkan?`
            : 'Semua soal sudah dijawab. Yakin ingin mengumpulkan?';

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Kumpulkan Jawaban?',
                text: msg,
                icon: unanswered > 0 ? 'warning' : 'question',
                showCancelButton: true,
                confirmButtonColor: '#1cc88a',
                cancelButtonColor: '#858796',
                confirmButtonText: '<i class="mdi mdi-send-check-outline"></i> Ya, Kumpulkan!',
                cancelButtonText: 'Kembali'
            }).then(result => {
                if (result.isConfirmed) document.getElementById('examForm').submit();
            });
        } else {
            if (confirm(msg)) document.getElementById('examForm').submit();
        }
    }

    // ===== ANTI-CHEAT (INTEGRATED LOCKDOWN) =====

    let cheatCount = {{ $attempt->cheat_attempts ?? 0 }};
    const maxLimit = 2;
    const examForm = document.getElementById('examForm');

    // Fungsi pembantu untuk mematikan proteksi dan submit
    function forceSubmit(message) {
        // PENTING: Matikan listener beforeunload agar tidak muncul dialog "Stay/Leave"
        window.onbeforeunload = null;
        
        if (message) alert(message);
        examForm.submit();
    }

    // 1. Gabungan Deteksi Pindah Tab & Counter
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            // Kirim log cheat ke server via Fetch
            fetch("{{ route('exams.logCheat', $exam->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                cheatCount = data.current_attempts;

                if (cheatCount >= maxLimit) {
                    forceSubmit("Batas pelanggaran habis! Ujian dihentikan dan jawaban dikirim otomatis.");
                } else {
                    Swal.fire({
                        title: 'Peringatan Kecurangan!',
                        text: `Jangan tinggalkan halaman ujian! Pelanggaran: ${cheatCount}/${maxLimit}`,
                        icon: 'warning',
                        confirmButtonColor: '#e74a3b',
                        allowOutsideClick: false
                    });
                }
            })
            .catch(err => {
                // Jika fetch gagal (koneksi drop), tetap jalankan logic lokal
                cheatCount++;
                if(cheatCount >= maxLimit) forceSubmit("Kecurangan terdeteksi!");
            });
        }
    });

    // 2. Cegah Klik Kanan
    document.addEventListener('contextmenu', e => e.preventDefault());

    // 3. Proteksi Keluar/Refresh (Hanya muncul jika bukan auto-submit)
    window.onbeforeunload = function(e) {
        return "Yakin ingin meninggalkan ujian? Jawaban Anda mungkin belum tersimpan.";
    };

    // 4. Maksa Fullscreen
    document.addEventListener('fullscreenchange', function() {
        if (!document.fullscreenElement) {
            Swal.fire({
                title: 'Fullscreen Keluar!',
                text: 'Anda harus tetap dalam mode fullscreen untuk mengerjakan ujian.',
                icon: 'error',
                confirmButtonText: 'Masuk Fullscreen Kembali',
                allowOutsideClick: false
            }).then(() => {
                document.documentElement.requestFullscreen().catch(err => {
                    console.warn("Gagal masuk fullscreen otomatis");
                });
            });
        }
    });

    // 5. Cegah Shortcut (Ctrl+C, Ctrl+V, F12, dsb)
    window.addEventListener('keydown', function(e) {
        if ((e.ctrlKey && ['c','v','u','a','s'].includes(e.key)) || e.key === 'F12') {
            e.preventDefault();
            return false;
        }
    });

    // Pastikan fungsi submit manual (tombol Selesai) juga mematikan beforeunload
    function submitExam() {
        Swal.fire({
            title: 'Kumpulkan Jawaban?',
            text: "Pastikan semua soal telah terjawab.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1cc88a',
            confirmButtonText: 'Ya, Kumpulkan!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.onbeforeunload = null; // Matikan proteksi
                examForm.submit();
            }
        });
    }
</script>
@endpush

@endsection