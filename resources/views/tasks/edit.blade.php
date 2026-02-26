@extends('layouts.skydash')

@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Tugas: {{ $task->title }}</h4>
            <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Judul Tugas</label>
                    <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
                </div>
                <div class="form-group">
                    <label>Instruksi</label>
                    <textarea name="instructions" class="form-control" rows="5">{{ $task->instructions }}</textarea>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="draft" {{ $task->status == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ $task->status == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Tugas</button>
            </form>
        </div>
    </div>
</div>
@endsection