@extends('layouts.skydash')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Edit Pertanyaan</h3>
                <h6 class="font-weight-normal mb-0">{{ $quiz->title }}</h6>
            </div>
            <div class="col-12 col-xl-4">
                <div class="justify-content-end d-flex">
                    <a href="{{ route('quiz.questions.index', $quiz) }}" class="btn btn-secondary">
                        <i class="icon-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('quiz.questions.update', [$quiz, $question]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="question_text" class="form-label">Teks Pertanyaan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('question_text') is-invalid @enderror" 
                                  id="question_text" name="question_text" rows="3" required
                                  placeholder="Masukkan pertanyaan...">{{ old('question_text', $question->question_text ?? $question->question) }}</textarea>
                        @error('question_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="type" class="form-label">Tipe <span class="text-danger">*</span></label>
                                <select class="form-control @error('type') is-invalid @enderror" 
                                        id="type" name="type" required>
                                    <option value="">Pilih tipe...</option>
                                    @foreach($questionTypes as $value => $label)
                                        <option value="{{ $value }}" {{ old('type', $question->type) == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="points" class="form-label">Poin <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('points') is-invalid @enderror" 
                                       id="points" name="points" value="{{ old('points', $question->points ?? 1) }}" 
                                       min="1" required>
                                @error('points')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="difficulty" class="form-label">Kesulitan</label>
                                <select class="form-control @error('difficulty') is-invalid @enderror" 
                                        id="difficulty" name="difficulty">
                                    <option value="">Pilih kesulitan...</option>
                                    <option value="easy" {{ old('difficulty', $question->difficulty) == 'easy' ? 'selected' : '' }}>Mudah</option>
                                    <option value="medium" {{ old('difficulty', $question->difficulty) == 'medium' ? 'selected' : '' }}>Menengah</option>
                                    <option value="hard" {{ old('difficulty', $question->difficulty) == 'hard' ? 'selected' : '' }}>Sulit</option>
                                </select>
                                @error('difficulty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="explanation" class="form-label">Penjelasan</label>
                        <textarea class="form-control @error('explanation') is-invalid @enderror" 
                                  id="explanation" name="explanation" rows="2"
                                  placeholder="Penjelasan opsional untuk jawaban yang benar">{{ old('explanation', $question->explanation) }}</textarea>
                        @error('explanation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <!-- Answers Section -->
                    <h5 class="mb-3"><i class="icon-options text-success"></i> Jawaban</h5>
                    <div id="answers-container">
                        @foreach($question->answers as $index => $answer)
                        <div class="answer-item card mb-3" data-index="{{ $index }}">
                            <div class="card-body">
                                <div class="form-row align-items-center">
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" 
                                               name="answers[{{ $index }}][text]" 
                                               value="{{ old("answers.{$index}.text", $answer->answer_text) }}"
                                               placeholder="Enter answer option..." required>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="answers[{{ $index }}][is_correct]" 
                                                   value="1" 
                                                   id="correct_{{ $index }}"
                                                   {{ old("answers.{$index}.is_correct", $answer->is_correct) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="correct_{{ $index }}">
                                                Jawaban yang Benar
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-sm btn-danger remove-answer" {{ count($question->answers) > 2 ? '' : 'disabled' }}>
                                            <i class="icon-close"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-outline-success" id="add-answer">
                        <i class="icon-plus"></i> Tambah Jawaban
                    </button>

                    <hr class="my-4">

                    <div class="form-group">
                        <label for="order" class="form-label">Urutan Pertanyaan</label>
                        <input type="number" class="form-control @error('order') is-invalid @enderror" 
                               id="order" name="order" value="{{ old('order', $question->order) }}" 
                               min="1">
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="icon-check"></i> Perbarui Pertanyaan
                        </button>
                        <a href="{{ route('quiz.questions.index', $quiz) }}" class="btn btn-secondary ml-2">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let answerIndex = {{ $question->answers->count() }};

document.getElementById('add-answer').addEventListener('click', function() {
    const container = document.getElementById('answers-container');
    const newAnswer = document.createElement('div');
    newAnswer.className = 'answer-item card mb-3';
    newAnswer.dataset.index = answerIndex;
    newAnswer.innerHTML = `
        <div class="card-body">
            <div class="form-row align-items-center">
                <div class="col-md-8">
                    <input type="text" class="form-control" name="answers[${answerIndex}][text]" 
                           placeholder="Enter answer option..." required>
                </div>
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="answers[${answerIndex}][is_correct]" 
                               value="1" id="correct_${answerIndex}">
                        <label class="form-check-label" for="correct_${answerIndex}">
                            Correct Answer
                        </label>
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger remove-answer">
                        <i class="icon-close"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    container.appendChild(newAnswer);
    updateRemoveButtons();
    answerIndex++;
});

document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-answer')) {
        const answerItem = e.target.closest('.answer-item');
        const allItems = document.querySelectorAll('.answer-item');
        if (allItems.length > 2) {
            answerItem.remove();
            updateRemoveButtons();
        }
    }
});

function updateRemoveButtons() {
    const items = document.querySelectorAll('.answer-item');
    items.forEach(item => {
        const btn = item.querySelector('.remove-answer');
        if (items.length > 2) {
            btn.disabled = false;
        } else {
            btn.disabled = true;
        }
    });
}
</script>
@endpush
@endsection

