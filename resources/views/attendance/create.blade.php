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

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                @if($students->isEmpty())
                    <div class="alert alert-warning">Tidak ada siswa terdaftar di kelas ini. Silakan periksa pengaturan kelas atau tambahkan siswa terlebih dahulu.</div>
                    <a href="{{ route('attendance.index') }}" class="btn btn-secondary mt-2">Kembali</a>
                @else
                    <h4 class="card-title mb-4">Pilih Status Kehadiran</h4>
                    <form action="{{ route('attendance.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <input type="hidden" name="classroom_id" value="{{ $course->classroom_id }}">
                        
                        <div class="form-group mb-4">
                            <label for="attendance_date"><strong>Tanggal</strong></label>
                            <input type="date" id="attendance_date" name="attendance_date" class="form-control" value="{{ $attendanceDate ?? date('Y-m-d') }}" required>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Avatar</th>
                                        <th>Nama Siswa</th>
                                        <th>Email</th>
                                        <th>Status Kehadiran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if($student->avatar)
                                                    <img src="{{ asset('storage/' . $student->avatar) }}"
                                                        alt="{{ $student->name }}"
                                                        class="rounded-circle"
                                                        width="40" height="40"
                                                        style="object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white fw-bold"
                                                        style="width:40px; height:40px; font-size:16px; flex-shrink:0;">
                                                         {{ strtoupper(substr($student->name ?? '?', 0, 1)) }}
                                                    </div>
                                                 @endif
                                                <span>{{ $student->name ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="text-muted" style="vertical-align: middle;">
                                            {{ $student->email ?? '-' }}
                                        </td>
                                        <td>{{ $student->name }}</td>
                                        <td>
                                            <div class="btn-group btn-group-toggle" data-toggle="buttons" style="display: flex; gap: 5px;">
                                                <label class="btn btn-outline-success btn-sm active">
                                                    <input type="radio" name="attendances[{{ $student->id }}]" value="present" checked> Hadir
                                                </label>
                                                <label class="btn btn-outline-warning btn-sm">
                                                    <input type="radio" name="attendances[{{ $student->id }}]" value="sick"> Sakit
                                                </label>
                                                <label class="btn btn-outline-danger btn-sm">
                                                    <input type="radio" name="attendances[{{ $student->id }}]" value="absent"> Alpa
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Simpan Absensi</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection