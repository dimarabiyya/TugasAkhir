@extends('layouts.skydash')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Kelola Pertanyaan</h3>
                <h6 class="font-weight-normal mb-0">{{ $quiz->title }}</h6>
                <nav aria-label="breadcrumb" class="mt-2">
                    <ol class="breadcrumb" style="background: none; padding: 0; margin: 5px 0;">
                        <li class="breadcrumb-item"><a href="{{ route('courses.index') }}" class="text-muted">Mata Pelajaran</a></li>
                        <li class="breadcrumb-item text-muted">{{ $quiz->lesson->module->course->title ?? 'N/A' }}</li>
                        <li class="breadcrumb-item text-muted">›</li>
                        <li class="breadcrumb-item text-muted">{{ $quiz->lesson->module->title ?? 'N/A' }}</li>
                        <li class="breadcrumb-item text-muted">›</li>
                        <li class="breadcrumb-item text-muted">{{ $quiz->lesson->title ?? 'N/A' }}</li>
                        <li class="breadcrumb-item text-muted">›</li>
                        <li class="breadcrumb-item text-muted">{{ $quiz->title }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-xl-4">
                <div class="justify-content-end d-flex">
                    <a href="{{ route('quiz.questions.create', $quiz) }}" class="btn btn-primary mr-2">
                        <i class="icon-plus"></i> Tambah Pertanyaan
                    </a>
                    <a href="{{ $quiz->url }}" class="btn btn-secondary">
                        <i class="icon-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quiz Info Card -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <p class="mb-1 text-muted">Judul Kuis</p>
                        <strong>{{ $quiz->title }}</strong>
                    </div>
                    <div class="col-md-3">
                        <p class="mb-1 text-muted">Total Pertanyaan</p>
                        <strong>{{ $quiz->questions->count() }}</strong>
                    </div>
                    <div class="col-md-3">
                        <p class="mb-1 text-muted">Total Poin</p>
                        <strong>{{ $quiz->questions->sum('points') }}</strong>
                    </div>
                    <div class="col-md-3">
                        <p class="mb-1 text-muted">Status</p>
                        @php
                            $statusColors = [
                                'draft' => 'warning',
                                'published' => 'success',
                                'archived' => 'secondary'
                            ];
                        @endphp
                        <span class="badge badge-{{ $statusColors[$quiz->status] ?? 'secondary' }}">
                            {{ $quiz->status == 'draft' ? 'Draf' : ($quiz->status == 'published' ? 'Dipublikasikan' : ucfirst($quiz->status)) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Questions List -->
<div class="row mt-3">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">
                        <i class="icon-question text-primary"></i> Pertanyaan ({{ $quiz->questions->count() }})
                    </h5>
                </div>

                @if($quiz->questions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="40%">Pertanyaan</th>
                                <th width="12%">Tipe</th>
                                <th width="8%">Poin</th>
                                <th width="10%">Jawaban</th>
                                <th width="10%">Kesulitan</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quiz->questions->sortBy('order') as $question)
                            <tr>
                                <td>
                                    <span class="badge badge-primary">{{ $question->order ?? $loop->iteration }}</span>
                                </td>
                                <td>
                                    <strong>{{ Str::limit($question->question_text ?? $question->question, 70) }}</strong>
                                    @if($question->explanation)
                                        <br><small class="text-muted">Penjelasan: {{ Str::limit($question->explanation, 40) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $question->type == 'multiple_choice' ? 'Pilihan Ganda' : ucfirst(str_replace('_', ' ', $question->type ?? 'Pilihan Ganda')) }}</span>
                                </td>
                                <td>
                                    <strong class="text-primary">{{ $question->points }}</strong>
                                </td>
                                <td>
                                    <span class="badge badge-secondary">{{ $question->answers->count() }}</span>
                                    @if($question->answers->where('is_correct', true)->count() > 0)
                                        <br><small class="text-success"><i class="icon-check"></i> {{ $question->answers->where('is_correct', true)->count() }} benar</small>
                                    @endif
                                </td>
                                <td>
                                    @if($question->difficulty)
                                        @php
                                            $difficultyColors = [
                                                'easy' => 'success',
                                                'medium' => 'warning',
                                                'hard' => 'danger'
                                            ];
                                        @endphp
                                        <span class="badge badge-{{ $difficultyColors[$question->difficulty] ?? 'secondary' }}">
                                            {{ $question->difficulty == 'easy' ? 'Mudah' : ($question->difficulty == 'medium' ? 'Menengah' : ($question->difficulty == 'hard' ? 'Sulit' : ucfirst($question->difficulty))) }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('quiz.questions.edit', [$quiz, $question]) }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        <form action="{{ route('quiz.questions.destroy', [$quiz, $question]) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="event.preventDefault(); confirmDelete(event, 'Apakah Anda yakin ingin menghapus pertanyaan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <div class="icon-circle-lg bg-light d-inline-flex align-items-center justify-content-center mb-3">
                        <i class="icon-question text-muted" style="font-size: 48px;"></i>
                    </div>
                    <h5 class="text-muted">Belum ada pertanyaan</h5>
                    <p class="text-muted mb-3">Tambahkan pertanyaan pertama Anda untuk memulai</p>
                    <a href="{{ route('quiz.questions.create', $quiz) }}" class="btn btn-primary">
                        <i class="icon-plus mr-2"></i> Tambah Pertanyaan Pertama
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .badge {
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05);
    }
    
    .icon-circle-lg {
        width: 120px;
        height: 120px;
        border-radius: 50%;
    }
    
    .btn-group .btn {
        margin-right: 2px;
    }
</style>
@endpush
@endsection

