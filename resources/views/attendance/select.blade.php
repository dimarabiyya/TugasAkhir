@extends('layouts.skydash')

@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4>Pilih Mata Pelajaran untuk Membuat Absensi</h4>

            <form method="GET" action="{{ route('attendance.create') }}">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="course_id">Mata Pelajaran</label>
                        <select name="course_id" id="course_id" class="form-control" required>
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }} ({{ $course->classroom->name ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="attendance_date">Tanggal</label>
                        <input type="date" name="attendance_date" id="attendance_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="form-group col-md-2 align-self-end">
                        <button class="btn btn-success">Pilih</button>
                    </div>
                </div>
            </form>

            <a href="{{ route('attendance.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</div>
@endsection
