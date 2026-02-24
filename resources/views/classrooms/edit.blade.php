@extends('layouts.skydash')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Kelas: {{ $classroom->name }}</h4>
                    <p class="card-description">Perbarui informasi kelas, instruktur, dan daftar siswa.</p>
                    
                    <form action="{{ route('classrooms.update', $classroom->id) }}" method="POST" class="forms-sample">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Nama Kelas</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" value="{{ old('name', $classroom->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Instruktur (Guru Pengampu)</label>
                            <select name="instructor_id" class="form-control select2" style="width:100%">
                                @foreach($instructors as $instructor)
                                    <option value="{{ $instructor->id }}" 
                                        {{ old('instructor_id', $classroom->instructor_id) == $instructor->id ? 'selected' : '' }}>
                                        {{ $instructor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Daftar Siswa di Kelas Ini</label>
                            <select name="student_ids[]" class="form-control select2" multiple="multiple" style="width:100%">
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" 
                                        {{ in_array($student->id, old('student_ids', $currentStudents)) ? 'selected' : '' }}>
                                        {{ $student->name }} ({{ $student->email }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Cari dan pilih siswa untuk ditambahkan ke kelas.</small>
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $classroom->description) }}</textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary mr-2">Simpan Perubahan</button>
                            <a href="{{ route('classrooms.index') }}" class="btn btn-light">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "-- Pilih --",
            allowClear: true
        });
    });
</script>
@endpush