@extends('layouts.skydash')

@section('content')
<div class="col-md-12 grid-margin">
        <div class="row mb-5">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <div class="d-flex align-items-center">
                    <div>
                        <h3 class="font-weight-bold mb-2">Pilih Absensi</h3>
                        <p class="text-muted mb-0">Pilih kelas dan mata pelajaran untuk absensi siswa!</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-4">
                <div class="justify-content-end d-flex">
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
                        <a href="{{ route('attendance.create') }}" class="btn btn-primary mr-2">
                            <i class="mdi mdi-plus"></i> Buat Absensi Baru
                        </a>
                    @endif
                </div>
            </div>
        </div>
        
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
                        <button class="btn btn-primary">Pilih</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
