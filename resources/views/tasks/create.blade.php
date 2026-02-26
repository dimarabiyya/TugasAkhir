@extends('layouts.skydash')

@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Buat Tugas Baru</h4>
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    {{-- 1. Pilih Kelas --}}
                    <div class="col-md-6 form-group">
                        <label>Pilih Kelas</label>
                        <select id="classroom_id" class="form-control" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($classrooms as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 2. Pilih Course --}}
                    <div class="col-md-6 form-group">
                        <label>Pilih Mata Pelajaran (Course)</label>
                        <select id="course_id" class="form-control" disabled required>
                            <option value="">-- Pilih Kelas Terlebih Dahulu --</option>
                        </select>
                    </div>

                    {{-- 3. Pilih Module --}}
                    <div class="col-md-6 form-group">
                        <label>Pilih Modul</label>
                        <select id="module_id" class="form-control" disabled required>
                            <option value="">-- Pilih Course Terlebih Dahulu --</option>
                        </select>
                    </div>

                    {{-- 4. Pilih Lesson (Input Utama) --}}
                    <div class="col-md-6 form-group">
                        <label>Pilih Materi (Lesson)</label>
                        <select name="lesson_id" id="lesson_id" class="form-control" disabled required>
                            <option value="">-- Pilih Modul Terlebih Dahulu --</option>
                        </select>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label>Judul Tugas</label>
                    <input type="text" name="title" class="form-control" placeholder="Contoh: Tugas Mandiri Pertemuan 1" required>
                </div>

                <div class="form-group">
                    <label>Instruksi</label>
                    <textarea name="instructions" class="form-control" rows="4"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Nilai Maksimal</label>
                        <input type="number" name="max_score" class="form-control" value="100">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Deadline</label>
                        <input type="datetime-local" name="due_date" class="form-control">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Simpan Tugas</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>

{{-- Script AJAX untuk Dropdown Berjenjang --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // 1. KELAS -> COURSE
    $('#classroom_id').on('change', function() {
        let classroomId = $(this).val();
        $('#course_id').empty().append('<option value="">Loading...</option>').prop('disabled', true);
        $('#module_id, #lesson_id').empty().append('<option value="">-- Pilih --</option>').prop('disabled', true);

        if(classroomId) {
            $.get('/get-courses/' + classroomId, function(data) {
                $('#course_id').empty().append('<option value="">-- Pilih Course --</option>').prop('disabled', false);
                $.each(data, function(key, value) {
                    $('#course_id').append('<option value="'+ value.id +'">'+ value.title +'</option>');
                });
            });
        }
    });

    // 2. COURSE -> MODULE (Perhatikan ID Selector-nya)
    $('#course_id').on('change', function() {
        let courseId = $(this).val();
        $('#module_id').empty().append('<option value="">Loading...</option>').prop('disabled', true);
        $('#lesson_id').empty().append('<option value="">-- Pilih --</option>').prop('disabled', true);

        if(courseId) {
            $.get('/get-modules/' + courseId, function(data) {
                $('#module_id').empty().append('<option value="">-- Pilih Modul --</option>').prop('disabled', false);
                $.each(data, function(key, value) {
                    $('#module_id').append('<option value="'+ value.id +'">'+ value.title +'</option>');
                });
            }).fail(function() {
                alert("Gagal memuat modul. Periksa koneksi atau route.");
            });
        }
    });

    // 3. MODULE -> LESSON
    $('#module_id').on('change', function() {
        let moduleId = $(this).val();
        $('#lesson_id').empty().append('<option value="">Loading...</option>').prop('disabled', true);

        if(moduleId) {
            $.get('/get-lessons/' + moduleId, function(data) {
                $('#lesson_id').empty().append('<option value="">-- Pilih Materi --</option>').prop('disabled', false);
                $.each(data, function(key, value) {
                    $('#lesson_id').append('<option value="'+ value.id +'">'+ value.title +'</option>');
                });
            });
        }
    });
});
</script>
@endsection