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
                                <i class="mdi mdi-pencil-circle-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Edit Pertanyaan</h4>
                                <p class="text-white-50 mb-0" style="font-size: 14px;">{{ $quiz->title }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('quiz.questions.index', $quiz) }}" class="btn btn-light font-weight-bold" style="border-radius: 8px; font-size: 13px;">
                            <i class="mdi mdi-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== FORM ===== --}}
<form action="{{ route('quiz.questions.update', [$quiz, $question]) }}" method="POST">
@csrf
@method('PUT')

<div class="row">
    <div class="col-md-12">

        {{-- ===== SECTION 1: Detail Pertanyaan ===== --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-help-circle-outline" style="font-size: 20px; color: #4e73df;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Detail Pertanyaan</h5>
                        <small class="text-muted">Teks pertanyaan, tipe, poin, dan tingkat kesulitan</small>
                    </div>
                </div>

                {{-- Teks Pertanyaan --}}
                <div class="form-group mb-4">
                    <label for="question_text" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                        <i class="mdi mdi-comment-question-outline mr-1 text-muted"></i> Teks Pertanyaan <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control @error('question_text') is-invalid @enderror"
                              id="question_text" name="question_text" rows="3" required
                              placeholder="Masukkan pertanyaan..."
                              style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2; resize: vertical;">{{ old('question_text', $question->question_text ?? $question->question) }}</textarea>
                    @error('question_text')
                        <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tipe, Poin, Kesulitan --}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-4">
                            <label for="type" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                                <i class="mdi mdi-radiobox-marked mr-1 text-muted"></i> Tipe Soal <span class="text-danger">*</span>
                            </label>
                            <select class="form-control @error('type') is-invalid @enderror"
                                    id="type" name="type" required
                                    style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2;">
                                <option value="">Pilih tipe...</option>
                                @foreach($questionTypes as $value => $label)
                                    <option value="{{ $value }}" {{ old('type', $question->type) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-4">
                            <label for="points" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                                <i class="mdi mdi-star-outline mr-1 text-muted"></i> Poin <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                   class="form-control @error('points') is-invalid @enderror"
                                   id="points" name="points"
                                   value="{{ old('points', $question->points ?? 1) }}"
                                   min="1" required
                                   style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2;">
                            @error('points')
                                <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-4">
                            <label for="difficulty" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                                <i class="mdi mdi-signal-cellular-outline mr-1 text-muted"></i> Tingkat Kesulitan
                            </label>
                            <select class="form-control @error('difficulty') is-invalid @enderror"
                                    id="difficulty" name="difficulty"
                                    style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2;">
                                <option value="">Pilih kesulitan...</option>
                                <option value="easy"   {{ old('difficulty', $question->difficulty) == 'easy'   ? 'selected' : '' }}>Mudah</option>
                                <option value="medium" {{ old('difficulty', $question->difficulty) == 'medium' ? 'selected' : '' }}>Menengah</option>
                                <option value="hard"   {{ old('difficulty', $question->difficulty) == 'hard'   ? 'selected' : '' }}>Sulit</option>
                            </select>
                            @error('difficulty')
                                <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Penjelasan --}}
                <div class="form-group mb-0">
                    <label for="explanation" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                        <i class="mdi mdi-lightbulb-outline mr-1 text-muted"></i> Penjelasan
                    </label>
                    <textarea class="form-control @error('explanation') is-invalid @enderror"
                              id="explanation" name="explanation" rows="2"
                              placeholder="Penjelasan opsional untuk jawaban yang benar..."
                              style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2; resize: vertical;">{{ old('explanation', $question->explanation) }}</textarea>
                    @error('explanation')
                        <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted mt-1 d-block"><i class="mdi mdi-information-outline mr-1"></i>Opsional — ditampilkan setelah siswa menjawab</small>
                </div>
            </div>
        </div>

        {{-- ===== SECTION 2: Pilihan Jawaban ===== --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center">
                        <div style="background: #e3f9e5; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-format-list-checks" style="font-size: 20px; color: #1cc88a;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Pilihan Jawaban</h5>
                            <small class="text-muted">Edit pilihan, centang jawaban yang benar</small>
                        </div>
                    </div>
                    <button type="button" id="add-answer"
                            class="btn btn-sm"
                            style="background: #e3f9e5; color: #1cc88a; border-radius: 8px; font-size: 13px; font-weight: 600; border: none; padding: 8px 16px;"
                            onmouseover="this.style.background='#1cc88a';this.style.color='#fff';"
                            onmouseout="this.style.background='#e3f9e5';this.style.color='#1cc88a';">
                        <i class="mdi mdi-plus-circle-outline mr-1"></i> Tambah Jawaban
                    </button>
                </div>

                {{-- Answers Container --}}
                <div id="answers-container">
                    @php $labels = ['A','B','C','D','E','F','G','H','I','J']; @endphp
                    @foreach($question->answers as $index => $answer)
                    <div class="answer-item mb-3" data-index="{{ $index }}">
                        <div style="background: #f8f9fc; border: 1px solid {{ old("answers.{$index}.is_correct", $answer->is_correct) ? '#1cc88a' : '#e3e6f0' }}; border-radius: 10px; padding: 14px 16px; {{ old("answers.{$index}.is_correct", $answer->is_correct) ? 'background: #f0fdf4 !important;' : '' }}">
                            <div class="d-flex align-items-center" style="gap: 12px;">
                                <div class="answer-badge" style="background: #4e73df; color: white; border-radius: 8px; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; flex-shrink: 0;">{{ $labels[$index] ?? ($index + 1) }}</div>
                                <input type="hidden" name="answers[{{ $index }}][id]" value="{{ $answer->id }}">
                                <input type="text" class="form-control flex-grow-1"
                                       name="answers[{{ $index }}][text]"
                                       value="{{ old("answers.{$index}.text", $answer->answer_text) }}"
                                       placeholder="Masukkan opsi jawaban..." required
                                       style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2;">
                                <div class="d-flex align-items-center" style="flex-shrink: 0; gap: 8px;">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input correct-check"
                                               name="answers[{{ $index }}][is_correct]"
                                               value="1" id="correct_{{ $index }}"
                                               {{ old("answers.{$index}.is_correct", $answer->is_correct) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="correct_{{ $index }}" style="font-size: 13px; white-space: nowrap; color: #1cc88a; font-weight: 600;">
                                            Benar
                                        </label>
                                    </div>
                                    <button type="button" class="btn btn-sm remove-answer"
                                            {{ $question->answers->count() <= 2 ? 'disabled' : '' }}
                                            style="background: #fde8e8; color: #e74a3b; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border: none; opacity: {{ $question->answers->count() <= 2 ? '0.35' : '1' }};"
                                            onmouseover="if(!this.disabled){this.style.background='#e74a3b';this.style.color='#fff';}"
                                            onmouseout="if(!this.disabled){this.style.background='#fde8e8';this.style.color='#e74a3b';}">
                                        <i class="mdi mdi-close" style="font-size: 16px;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Info hint --}}
                <div class="mt-2" style="background: #e8f0fe; border-radius: 8px; padding: 10px 14px;">
                    <small class="text-primary"><i class="mdi mdi-information-outline mr-1"></i>Centang kolom <strong>Benar</strong> untuk menandai jawaban yang benar. Bisa lebih dari satu.</small>
                </div>
            </div>
        </div>

        {{-- ===== SECTION 3: Urutan ===== --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div style="background: #fff3cd; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-sort-numeric-ascending" style="font-size: 20px; color: #f6c23e;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Urutan Pertanyaan</h5>
                        <small class="text-muted">Tentukan posisi pertanyaan dalam kuis</small>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <label for="order" class="form-label font-weight-600 text-dark" style="font-size: 13px;">
                        <i class="mdi mdi-order-numeric-ascending mr-1 text-muted"></i> Nomor Urut
                    </label>
                    <input type="number"
                           class="form-control @error('order') is-invalid @enderror"
                           id="order" name="order"
                           value="{{ old('order', $question->order) }}"
                           min="1"
                           style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2; max-width: 200px;">
                    @error('order')
                        <div class="invalid-feedback"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted mt-1 d-block"><i class="mdi mdi-information-outline mr-1"></i>Kosongkan untuk menambahkan di akhir daftar</small>
                </div>
            </div>
        </div>

        {{-- ===== ACTION BUTTONS ===== --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 10px;">
                    <p class="mb-0 text-muted" style="font-size: 13px;">
                        <i class="mdi mdi-information-outline mr-1"></i> Pastikan minimal 2 jawaban telah diisi dan 1 jawaban ditandai benar.
                    </p>
                    <div class="d-flex" style="gap: 10px;">
                        <a href="{{ route('quiz.questions.index', $quiz) }}"
                           class="btn btn-outline-secondary"
                           style="border-radius: 8px; padding: 10px 20px; font-size: 14px; font-weight: 600;">
                            <i class="mdi mdi-close mr-1"></i> Batal
                        </a>
                        <button type="submit"
                                class="btn btn-primary"
                                style="border-radius: 8px; padding: 10px 24px; font-size: 14px; font-weight: 600;">
                            <i class="mdi mdi-content-save-outline mr-1"></i> Perbarui Pertanyaan
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</form>

@push('styles')
<style>
    .form-control:focus {
        border-color: #4e73df !important;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15) !important;
    }

    .answer-item .form-control:focus {
        border-color: #1cc88a !important;
        box-shadow: 0 0 0 0.2rem rgba(28, 200, 138, 0.15) !important;
    }

    .answer-item > div {
        transition: border-color 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
    }

    .answer-item > div:hover {
        border-color: #b7c2e8 !important;
        box-shadow: 0 2px 8px rgba(78, 115, 223, 0.08);
    }

    .answer-item > div:has(.correct-check:checked) {
        border-color: #1cc88a !important;
        background: #f0fdf4 !important;
    }

    .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #1cc88a;
        border-color: #1cc88a;
    }

    .remove-answer:disabled {
        opacity: 0.35;
        cursor: not-allowed;
    }

    select.form-control {
        appearance: auto;
    }
</style>
@endpush

@push('scripts')
<script>
const LABELS = ['A','B','C','D','E','F','G','H','I','J'];
let answerIndex = {{ $question->answers->count() }};

function getLabel(index) {
    return LABELS[index] || (index + 1);
}

function rebuildLabels() {
    const items = document.querySelectorAll('.answer-item');
    items.forEach((item, i) => {
        const badge = item.querySelector('.answer-badge');
        if (badge) badge.textContent = getLabel(i);
    });
}

document.getElementById('add-answer').addEventListener('click', function () {
    const container = document.getElementById('answers-container');
    const currentCount = container.querySelectorAll('.answer-item').length;
    const label = getLabel(currentCount);

    const newAnswer = document.createElement('div');
    newAnswer.className = 'answer-item mb-3';
    newAnswer.dataset.index = answerIndex;
    newAnswer.innerHTML = `
        <div style="background: #f8f9fc; border: 1px solid #e3e6f0; border-radius: 10px; padding: 14px 16px;">
            <div class="d-flex align-items-center" style="gap: 12px;">
                <div class="answer-badge" style="background: #4e73df; color: white; border-radius: 8px; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; flex-shrink: 0;">${label}</div>
                <input type="text" class="form-control flex-grow-1" name="answers[${answerIndex}][text]"
                       placeholder="Masukkan opsi jawaban..." required
                       style="border-radius: 8px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2;">
                <div class="d-flex align-items-center" style="flex-shrink: 0; gap: 8px;">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input correct-check" name="answers[${answerIndex}][is_correct]"
                               value="1" id="correct_${answerIndex}">
                        <label class="custom-control-label" for="correct_${answerIndex}" style="font-size: 13px; white-space: nowrap; color: #1cc88a; font-weight: 600;">
                            Benar
                        </label>
                    </div>
                    <button type="button" class="btn btn-sm remove-answer"
                            style="background: #fde8e8; color: #e74a3b; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border: none;"
                            onmouseover="if(!this.disabled){this.style.background='#e74a3b';this.style.color='#fff';}"
                            onmouseout="if(!this.disabled){this.style.background='#fde8e8';this.style.color='#e74a3b';}">
                        <i class="mdi mdi-close" style="font-size: 16px;"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    container.appendChild(newAnswer);
    updateRemoveButtons();
    answerIndex++;
});

document.addEventListener('click', function (e) {
    if (e.target.closest('.remove-answer')) {
        const answerItem = e.target.closest('.answer-item');
        const allItems = document.querySelectorAll('.answer-item');
        if (allItems.length > 2) {
            answerItem.remove();
            rebuildLabels();
            updateRemoveButtons();
        }
    }
});

function updateRemoveButtons() {
    const items = document.querySelectorAll('.answer-item');
    items.forEach(item => {
        const btn = item.querySelector('.remove-answer');
        btn.disabled = items.length <= 2;
        btn.style.opacity = items.length <= 2 ? '0.35' : '1';
        btn.style.cursor = items.length <= 2 ? 'not-allowed' : 'pointer';
    });
}
</script>
@endpush

@endsection