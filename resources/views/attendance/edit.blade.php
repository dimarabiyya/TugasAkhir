@extends('layouts.skydash')

@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4>Edit Absensi</h4>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('attendance.update', $attendance) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" class="form-control" value="{{ $attendance->attendance_date }}" readonly>
                </div>

                <div class="form-group">
                    <label>Mata Pelajaran</label>
                    <input type="text" class="form-control" value="{{ $attendance->course->title ?? '-' }}" readonly>
                </div>

                <div class="form-group">
                    <label>Siswa</label>
                    <input type="text" class="form-control" value="{{ $attendance->student->name ?? '-' }}" readonly>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="present" {{ $attendance->status === 'present' ? 'selected' : '' }}>Hadir</option>
                        <option value="sick" {{ $attendance->status === 'sick' ? 'selected' : '' }}>Sakit</option>
                        <option value="absent" {{ $attendance->status === 'absent' ? 'selected' : '' }}>Alpa</option>
                    </select>
                </div>

                <button class="btn btn-success">Simpan</button>
                <a href="{{ route('attendance.show', $attendance) }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
