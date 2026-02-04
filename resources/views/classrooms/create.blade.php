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
                    <h4 class="card-title">Tambah Kelas Baru</h4>
                    <form action="{{ route('classrooms.store') }}" method="POST" class="forms-sample">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Kelas</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Contoh: XI RPL 1" required>
                        </div>

                        <div class="form-group">
                            <label>Pilih Instruktur (Guru)</label>
                            <select name="instructor_id" class="form-control select2" style="width:100%">
                                <option value="">-- Pilih Guru --</option>
                                @foreach($instructors as $instructor)
                                    <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Assign Siswa ke Kelas</label>
                            <select name="student_ids[]" class="form-control select2" multiple="multiple" style="width:100%">
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Bisa pilih lebih dari satu siswa</small>
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="4"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                        <a href="{{ route('classrooms.index') }}" class="btn btn-light">Batal</a>
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
        $('.select2').select2();
    });
</script>
@endpush