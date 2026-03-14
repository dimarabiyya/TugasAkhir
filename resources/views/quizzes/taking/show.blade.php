@extends('layouts.skydash')

@section('content')

{{-- Debug (hidden in production) --}}
<script>
    console.log('Quiz ID: {{ $quiz->id }}');
    console.log('Attempt ID: {{ $attempt->id }}');
</script>

<div style="max-width: 860px; margin: 0 auto;">

    {{-- ===== QUIZ HEADER ===== --}}
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
                <div class="card-body py-3 px-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 12px;">
                        <div>
                            <h5 class="font-weight-bold text-white mb-0">{{ $quiz->title }}</h5>
                            @if($quiz->description)
                            <p class="text-white-50 mb-0" style="font-size: 12px;">{{ $quiz->description }}</p>
                            @endif
                        </div>
                        <div class="d-flex align-items-center" style="gap: 10px;">
                            @if($quiz->time_limit_minutes)
                            <div id="timer"
                                 style="background: rgba(255,255,255,0.2); border-radius: 8px; padding: 8px 16px; display: flex; align-items: center; gap: 6px;">
                                <i class="mdi mdi-clock-outline text-white" style="font-size: 18px;"></i>
                                <span id="time-remaining" class="text-white font-weight-bold" style="font-size: 18px; font-family: monospace; letter-spacing: 1px;">--:--</span>
                            </div>
                            @endif
                            <div style="background: rgba(255,255,255,0.15); border-radius: 8px; padding: 8px 14px; text-align: center;">
                                <p class="text-white-50 mb-0" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.4px;">Soal</p>
                                <p class="text-white font-weight-bold mb-0" style="font-size: 14px;">
                                    <span id="current-question">1</span> / {{ $questions->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== PROGRESS BAR ===== --}}
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                <div class="card-body py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <small class="text-muted font-weight-600">Terjawab: <strong id="answered-count" class="text-primary">0</strong></small>
                        <small class="text-muted">Total: <strong>{{ $questions->count() }}</strong> soal</small>
                    </div>
                    <div style="background: #e3e6f0; border-radius: 6px; height: 8px; overflow: hidden;">
                        <div id="progress-bar"
                             style="height: 100%; width: 0%; border-radius: 6px; background: linear-gradient(90deg, #4e73df, #224abe); transition: width 0.4s ease;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== QUESTION NAVIGATION ===== --}}
    @if($quiz->allow_navigation && $questions->count() > 1)
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                <div class="card-body py-3 px-4">
                    <div class="d-flex flex-wrap justify-content-center" style="gap: 6px;">
                        @foreach($questions as $index => $q)
                        <button type="button"
                                class="question-nav-btn"
                                data-question="{{ $index + 1 }}"
                                data-question-id="{{ $q->id }}"
                                title="Soal {{ $index + 1 }}"
                                style="width: 36px; height: 36px; border-radius: 50%; border: 2px solid #d1d3e2; background: #fff; font-size: 12px; font-weight: 700; cursor: pointer; transition: all 0.2s; color: #5a5c69;">
                            {{ $index + 1 }}
                        </button>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-2" style="gap: 14px;">
                        <small class="d-flex align-items-center" style="gap: 5px; font-size: 11px; color: #858796;">
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #4e73df; display: inline-block;"></span> Aktif
                        </small>
                        <small class="d-flex align-items-center" style="gap: 5px; font-size: 11px; color: #858796;">
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #1cc88a; display: inline-block;"></span> Terjawab
                        </small>
                        <small class="d-flex align-items-center" style="gap: 5px; font-size: 11px; color: #858796;">
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #fff; border: 2px solid #d1d3e2; display: inline-block;"></span> Belum
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ===== QUIZ FORM ===== --}}
    <form id="quiz-form"
          action="{{ route('quiz.taking.submit', ['quiz' => $quiz, 'attempt' => $attempt]) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="submitted" value="1">

        {{-- Questions --}}
        @foreach($questions as $index => $question)
        @php
            $shuffledAnswers = $quiz->shuffle_answers ? $question->answers->shuffle() : $question->answers;
            $userAnswerIds   = isset($userAnswers[$question->id]) ? (array)$userAnswers[$question->id] : [];
            $diffCfg = ['easy' => ['bg'=>'#e3f9e5','c'=>'#1cc88a','label'=>'Mudah'], 'medium' => ['bg'=>'#fff3e8','c'=>'#f6c23e','label'=>'Menengah'], 'hard' => ['bg'=>'#fde8e8','c'=>'#e74a3b','label'=>'Sulit']];
        @endphp

        <div class="question-card card border-0 shadow-sm mb-3 {{ $index === 0 ? 'active' : 'd-none' }}"
             data-question-index="{{ $index + 1 }}"
             data-question-id="{{ $question->id }}"
             style="border-radius: 12px;">
            <div class="card-body p-4">

                {{-- Question header badges --}}
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center" style="gap: 6px; flex-wrap: wrap;">
                        <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">
                            Soal {{ $index + 1 }}
                        </span>
                        <span style="background: #e0f7fa; color: #17a2b8; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">
                            {{ $question->points }} Poin
                        </span>
                        @if($question->difficulty && isset($diffCfg[$question->difficulty]))
                        @php $dc = $diffCfg[$question->difficulty]; @endphp
                        <span style="background: {{ $dc['bg'] }}; color: {{ $dc['c'] }}; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">
                            {{ $dc['label'] }}
                        </span>
                        @endif
                    </div>
                    {{-- Saved indicator --}}
                    <div class="saved-indicator" style="display: none; align-items: center; gap: 4px;">
                        <i class="mdi mdi-check-circle" style="font-size: 16px; color: #1cc88a;"></i>
                        <small style="color: #1cc88a; font-size: 11px; font-weight: 600;">Tersimpan</small>
                    </div>
                </div>

                {{-- Question text --}}
                <div class="mb-4 p-3" style="background: #f8f9fc; border-radius: 10px; border-left: 3px solid #4e73df;">
                    <h5 class="font-weight-bold text-dark mb-0" style="font-size: 15px; line-height: 1.6;">
                        {{ $question->question_text ?? $question->question }}
                    </h5>
                </div>

                {{-- Answer Options --}}
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @foreach($shuffledAnswers as $answer)
                    <label class="answer-option d-flex align-items-center p-3"
                           style="border-radius: 10px; border: 2px solid #eaecf4; background: #fff; cursor: pointer; transition: all 0.2s; margin: 0; user-select: none;"
                           onmouseover="if(!this.querySelector('input').checked){this.style.borderColor='#4e73df';this.style.background='#f0f4ff';}"
                           onmouseout="if(!this.querySelector('input').checked){this.style.borderColor='#eaecf4';this.style.background='#fff';}">
                        <input type="{{ $question->type == 'multiple_choice' || $question->type == 'true_false' ? 'radio' : 'checkbox' }}"
                               class="answer-input"
                               name="answers[{{ $question->id }}][]"
                               id="answer_{{ $answer->id }}"
                               value="{{ $answer->id }}"
                               data-question-id="{{ $question->id }}"
                               {{ in_array($answer->id, $userAnswerIds) ? 'checked' : '' }}
                               style="display: none;">
                        {{-- Custom bullet --}}
                        <div class="answer-bullet"
                             style="width: 20px; height: 20px; border-radius: {{ $question->type == 'multiple_choice' || $question->type == 'true_false' ? '50%' : '4px' }}; border: 2px solid #d1d3e2; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-right: 12px; transition: all 0.2s;">
                        </div>
                        <span class="answer-text" style="font-size: 13.5px; color: #3d3d3d; flex: 1;">{{ $answer->answer_text }}</span>
                    </label>
                    @endforeach
                </div>

                @if($question->explanation && $quiz->show_correct_answers)
                <div class="mt-3 p-3" style="background: #e8f0fe; border-radius: 8px; border-left: 3px solid #4e73df;">
                    <p class="mb-0" style="font-size: 13px; color: #3d3d3d;">
                        <i class="mdi mdi-information-outline mr-1" style="color: #4e73df;"></i>
                        <strong>Penjelasan:</strong> {{ $question->explanation }}
                    </p>
                </div>
                @endif

            </div>
        </div>
        @endforeach

        {{-- ===== NAVIGATION BUTTONS ===== --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body px-4 py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <button type="button" id="prev-btn"
                            style="background: #f4f6fb; color: #6b7280; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 20px; border: 1px solid #e3e6f0; cursor: pointer; display: none; transition: all 0.2s;"
                            onmouseover="this.style.background='#e3e6f0';" onmouseout="this.style.background='#f4f6fb';">
                        <i class="mdi mdi-arrow-left mr-1"></i> Sebelumnya
                    </button>
                    <div style="flex: 1;"></div>
                    <div class="d-flex align-items-center" style="gap: 8px;">
                        <button type="button" id="next-btn"
                                style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 22px; border: none; cursor: pointer; {{ $questions->count() <= 1 ? 'display:none;' : '' }} box-shadow: 0 4px 12px rgba(78,115,223,0.3);"
                                onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                            Berikutnya <i class="mdi mdi-arrow-right ml-1"></i>
                        </button>
                        <button type="button" id="submit-btn"
                                style="background: linear-gradient(135deg, #1cc88a, #17a673); color: #fff; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 22px; border: none; cursor: pointer; {{ $questions->count() > 1 ? 'display:none;' : '' }} box-shadow: 0 4px 12px rgba(28,200,138,0.3);"
                                onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                            <i class="mdi mdi-send-outline mr-1"></i> Kirim Kuis
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>

@push('styles')
<style>
    /* Active answer option */
    .answer-option:has(.answer-input:checked) {
        border-color: #4e73df !important;
        background: #f0f4ff !important;
    }
    .answer-option:has(.answer-input:checked) .answer-bullet {
        background: #4e73df;
        border-color: #4e73df;
    }
    .answer-option:has(.answer-input:checked) .answer-bullet::after {
        content: '';
        display: block;
        width: 8px; height: 8px;
        background: #fff;
        border-radius: 50%;
    }
    .answer-option:has(.answer-input:checked) .answer-text {
        color: #4e73df;
        font-weight: 600;
    }

    /* Timer warning states */
    #timer.warning { background: rgba(246,194,62,0.3) !important; }
    #timer.danger  { background: rgba(231,74,59,0.3) !important; animation: pulse 0.6s infinite; }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50%       { opacity: 0.65; }
    }

    /* Nav button states */
    .question-nav-btn.active   { background: #4e73df !important; color: #fff !important; border-color: #4e73df !important; }
    .question-nav-btn.answered { background: #1cc88a !important; color: #fff !important; border-color: #1cc88a !important; }
    .question-nav-btn:hover    { transform: scale(1.1); }

    @media (max-width: 576px) {
        #time-remaining { font-size: 16px !important; }
        .question-nav-btn { width: 32px !important; height: 32px !important; font-size: 11px !important; }
    }
</style>
@endpush

@push('scripts')
<script>
let currentQuestion  = 1;
const totalQuestions = {{ $questions->count() }};
const timeLimit      = {{ $quiz->time_limit_minutes ? $quiz->time_limit_minutes * 60 : 0 }};
let   timeRemaining  = timeLimit;
let   timerInterval  = null;
let   allowBeforeUnload = false;
const startTime      = new Date('{{ $attempt->started_at->toIso8601String() }}');

/* ===================== TIMER ===================== */
@if($quiz->time_limit_minutes)
(function() {
    const elapsed = Math.floor((new Date() - startTime) / 1000);
    timeRemaining = Math.max(0, timeLimit - elapsed);
    updateTimerDisplay();

    timerInterval = setInterval(() => {
        if (timeRemaining > 0) {
            timeRemaining--;
            updateTimerDisplay();
        }
        if (timeRemaining <= 0) {
            clearInterval(timerInterval);
            disableForm();
            submitQuizViaAjax();
        }
    }, 1000);
})();

function updateTimerDisplay() {
    const m = Math.floor(timeRemaining / 60);
    const s = timeRemaining % 60;
    document.getElementById('time-remaining').textContent =
        String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');

    const el = document.getElementById('timer');
    el.classList.remove('warning','danger');
    if (timeRemaining <= 300) el.classList.add('danger');
    else if (timeRemaining <= 600) el.classList.add('warning');
}
@endif

/* ===================== NAVIGATION ===================== */
function showQuestion(index) {
    document.querySelectorAll('.question-card').forEach(c => {
        c.classList.remove('active');
        c.classList.add('d-none');
    });
    const card = document.querySelector(`.question-card[data-question-index="${index}"]`);
    if (card) { card.classList.add('active'); card.classList.remove('d-none'); }

    currentQuestion = index;
    document.getElementById('current-question').textContent = index;

    // Nav buttons
    document.querySelectorAll('.question-nav-btn').forEach(b => {
        b.classList.remove('active');
        if (parseInt(b.dataset.question) === index) b.classList.add('active');
    });

    updateNavButtons();
    updateProgress();
}

function updateNavButtons() {
    const prev   = document.getElementById('prev-btn');
    const next   = document.getElementById('next-btn');
    const submit = document.getElementById('submit-btn');

    prev.style.display = currentQuestion > 1 ? 'block' : 'none';

    if (currentQuestion < totalQuestions && totalQuestions > 1) {
        next.style.display   = 'inline-block';
        submit.style.display = 'none';
    } else {
        next.style.display   = 'none';
        submit.style.display = 'inline-block';
    }
}

function updateProgress() {
    // Count unique answered questions (at least one checked answer)
    let answered = 0;
    document.querySelectorAll('.question-card').forEach(card => {
        if (card.querySelectorAll('.answer-input:checked').length > 0) answered++;
    });
    const pct = (answered / totalQuestions) * 100;
    document.getElementById('progress-bar').style.width = pct + '%';
    document.getElementById('answered-count').textContent = answered;
}

/* ===================== EVENTS ===================== */
document.getElementById('next-btn').addEventListener('click', e => {
    e.preventDefault();
    if (currentQuestion < totalQuestions) showQuestion(currentQuestion + 1);
});

document.getElementById('prev-btn').addEventListener('click', e => {
    e.preventDefault();
    if (currentQuestion > 1) showQuestion(currentQuestion - 1);
});

document.querySelectorAll('.question-nav-btn').forEach(btn => {
    btn.addEventListener('click', () => showQuestion(parseInt(btn.dataset.question)));
});

/* ===================== ANSWER AUTO-SAVE ===================== */
document.querySelectorAll('.answer-input').forEach(input => {
    // Style checked state on page load
    styleAnswerOption(input);

    input.addEventListener('change', function() {
        styleAnswerOption(this);
        const qid = this.dataset.questionId;
        const checked = Array.from(document.querySelectorAll(`input[data-question-id="${qid}"]:checked`))
                             .map(i => i.value);

        fetch('{{ route('quiz.taking.save', ['quiz' => $quiz, 'attempt' => $attempt]) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN':  '{{ csrf_token() }}'
            },
            body: JSON.stringify({ question_id: qid, answer_ids: checked })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                // Show saved indicator
                const indicator = this.closest('.question-card').querySelector('.saved-indicator');
                indicator.style.display = 'flex';
                setTimeout(() => { indicator.style.display = 'none'; }, 2000);

                // Mark nav button answered
                const navBtn = document.querySelector(`.question-nav-btn[data-question-id="${qid}"]`);
                if (navBtn) navBtn.classList.add('answered');

                updateProgress();
            }
        })
        .catch(err => console.error('Auto-save failed:', err));
    });
});

function styleAnswerOption(input) {
    const label = input.closest('.answer-option') || input.closest('label');
    if (!label) return;
    if (input.checked) {
        label.style.borderColor = '#4e73df';
        label.style.background  = '#f0f4ff';
        const bullet = label.querySelector('.answer-bullet');
        if (bullet) { bullet.style.background = '#4e73df'; bullet.style.borderColor = '#4e73df'; }
        const text = label.querySelector('.answer-text');
        if (text) { text.style.color = '#4e73df'; text.style.fontWeight = '600'; }
    } else {
        label.style.borderColor = '#eaecf4';
        label.style.background  = '#fff';
        const bullet = label.querySelector('.answer-bullet');
        if (bullet) { bullet.style.background = ''; bullet.style.borderColor = '#d1d3e2'; }
        const text = label.querySelector('.answer-text');
        if (text) { text.style.color = '#3d3d3d'; text.style.fontWeight = '400'; }
    }
}

/* ===================== SUBMIT ===================== */
document.getElementById('submit-btn').addEventListener('click', function(e) {
    e.preventDefault();

    let answered = 0;
    document.querySelectorAll('.question-card').forEach(c => {
        if (c.querySelectorAll('.answer-input:checked').length > 0) answered++;
    });

    let msg = answered === 0
        ? 'Anda belum menjawab pertanyaan apapun. Kirim sekarang?'
        : answered < totalQuestions
            ? `Anda telah menjawab ${answered} dari ${totalQuestions} soal. Kirim sekarang?`
            : 'Kirim kuis? Jawaban tidak dapat diubah setelah dikirim.';

    Swal.fire({
        title: 'Kirim Kuis?',
        text: msg,
        icon: answered < totalQuestions ? 'warning' : 'question',
        showCancelButton: true,
        confirmButtonColor: '#1cc88a',
        cancelButtonColor: '#858796',
        confirmButtonText: '<i class="mdi mdi-send-outline mr-1"></i> Ya, Kirim!',
        cancelButtonText: 'Lanjut Mengerjakan'
    }).then(result => {
        if (result.isConfirmed) {
            if (timerInterval) clearInterval(timerInterval);
            disableForm();
            allowBeforeUnload = true;
            submitQuizViaAjax();
        }
    });
});

function disableForm() {
    document.getElementById('quiz-form').querySelectorAll('input,button').forEach(el => el.disabled = true);
}

function submitQuizViaAjax() {
    const form = document.getElementById('quiz-form');
    const answers = {};

    document.querySelectorAll('.answer-input').forEach(input => {
        const qid = input.dataset.questionId;
        if (!qid) return;
        if (!answers[qid]) answers[qid] = [];
        if (input.checked) answers[qid].push(input.value);
    });

    fetch(form.action, {
        method: 'POST',
        headers: {
            'Content-Type':    'application/json',
            'X-CSRF-TOKEN':    '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept':          'application/json'
        },
        body: JSON.stringify({ answers, submitted: 1 })
    })
    .then(async res => {
        const data = await res.json().catch(() => null);
        if (data && data.success && data.redirect) {
            window.location.href = data.redirect;
        } else {
            form.submit();
        }
    })
    .catch(() => form.submit());
}

/* ===================== KEYBOARD SHORTCUTS ===================== */
document.addEventListener('keydown', e => {
    if (e.key === 'ArrowLeft'  && currentQuestion > 1)             showQuestion(currentQuestion - 1);
    if (e.key === 'ArrowRight' && currentQuestion < totalQuestions) showQuestion(currentQuestion + 1);
});

/* ===================== PREVENT ACCIDENTAL LEAVE ===================== */
window.addEventListener('beforeunload', e => {
    if (allowBeforeUnload) return;
    if (document.querySelectorAll('.answer-input:checked').length > 0) {
        e.preventDefault();
        e.returnValue = '';
    }
});

/* ===================== SESSION KEEPALIVE ===================== */
setInterval(() => {
    fetch('{{ route('quiz.taking.progress', ['quiz' => $quiz, 'attempt' => $attempt]) }}')
        .catch(() => {});
}, 120000);

/* ===================== INIT ===================== */
showQuestion(1);
updateNavButtons();
updateProgress();

// Mark already-answered nav buttons on load
document.querySelectorAll('.question-card').forEach(card => {
    if (card.querySelectorAll('.answer-input:checked').length > 0) {
        const qid = card.dataset.questionId;
        const btn = document.querySelector(`.question-nav-btn[data-question-id="${qid}"]`);
        if (btn) btn.classList.add('answered');
    }
});
</script>
@endpush

@endsection