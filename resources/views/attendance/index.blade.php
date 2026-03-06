@extends('layouts.skydash')

@section('content')

    <div class="col-md-12 grid-margin">
        <div class="row">
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
                                        <th>Guru</th>
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
                                            @if(auth()->user()->hasRole('admin') || (auth()->user()->hasRole('instructor') && auth()->id() === $g->instructor_id))
                                                <div class="btn-group gap-1">

                                                    <a href="{{ route('attendance.show', ['course' => $g->course_id, 'date' => $g->attendance_date]) }}" class="btn btn-info btn-sm">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>

                                                    @if(auth()->user()->hasRole('admin') || (auth()->user()->hasRole('instructor') && auth()->id() === $g->instructor_id))
                                                        <a href="{{ route('attendance.edit', ['course' => $g->course_id, 'date' => $g->attendance_date]) }}" class="btn btn-primary btn-sm">
                                                            <i class="mdi mdi-pencil"></i>
                                                        </a>
                                                    @endif
                                                
                                                    <form action="{{ route('attendance.destroyGroup') }}" method="POST" class="d-inline btn-danger btn-sm"
                                                        onsubmit="confirmDelete(event, 'Apakah Anda yakin? Seluruh data kehadiran siswa di kelas ini pada tanggal tersebut akan terhapus permanen.');">
                                                        @csrf
                                                        @method('DELETE')
                                                        
                                                        <input type="hidden" name="course_id" value="{{ $g->course_id }}">
                                                        <input type="hidden" name="classroom_id" value="{{ $g->classroom_id }}">
                                                        <input type="hidden" name="attendance_date" value="{{ $g->attendance_date }}">
                                                        
                                                        <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 0px 12px 12px 0px">
                                                            <i class="mdi mdi-delete"></i>
                                                        </button>
                                                    </form>
                                                </div>
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