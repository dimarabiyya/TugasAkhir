@extends('layouts.skydash')

@section('content')

    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <div class="d-flex align-items-center">
                    <div>
                        <h3 class="font-weight-bold mb-2">Absensi Management</h3>
                        <p class="text-muted mb-0">Manage student accounts and their learning progress</p>
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
                    <a href="{{ route('dashboard') }}" class="btn btn-light">
                        <i class="mdi mdi-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    @if(isset($groups) && $groups->count())
                        <h4 class="card-title">Daftar Grup Absensi</h4>
                        <div class="table-responsive mb-4">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Kelas</th>
                                        <th>Instruktur</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($groups as $g)
                                    <tr>
                                        <td>{{ $g->attendance_date }}</td>
                                        <td>{{ $g->course->title ?? '-' }}</td>
                                        <td>{{ $g->classroom->name ?? '-' }}</td>
                                        <td>{{ $g->instructor->name ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('attendance.show', ['course' => $g->course_id, 'date' => $g->attendance_date]) }}" class="btn btn-info btn-sm">Lihat</a>
                                            @if(auth()->user()->hasRole('admin') || (auth()->user()->hasRole('instructor') && auth()->id() === $g->instructor_id))
                                                <a href="{{ route('attendance.show', ['course' => $g->course_id, 'date' => $g->attendance_date]) }}" class="btn btn-primary btn-sm">Edit</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection