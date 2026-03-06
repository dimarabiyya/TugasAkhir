@extends('layouts.skydash')

@section('content')
<div class="col-md-12 grid-margin">
        <div class="row mb-5">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <div class="d-flex align-items-center">
                    <div>
                        <h3 class="font-weight-bold mb-2">Absensi</h3>
                        <p class="text-muted mb-0">Kelola segala absensi dan kehadiran siswa</p>
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
            <h4>Absensi - {{ $course->title ?? '-' }} ({{ $course->classroom->name ?? 'N/A' }}) ({{ $date }})</h4>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @foreach($attendances as $attendance)
                <form action="{{ route('attendance.update', $attendance) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="col-md-12">
                        
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
                @endforeach
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('attendance.edit', $attendance) }}" class="btn btn-secondary">Batal</a>
                </form>
            
        </div>
    </div>
</div>
@endsection