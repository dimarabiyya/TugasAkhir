@extends('layouts.skydash')

@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4>Absensi - {{ $course->title ?? '-' }} ({{ $date }})</h4>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($attendances->isEmpty())
                <div class="alert alert-info">Tidak ada catatan absensi untuk group ini.</div>
            @else
                @php
                    $canEditGroup = auth()->user()->hasRole('admin') || (auth()->user()->hasRole('instructor') && auth()->id() === $attendances->first()->instructor_id);
                    $classroomId = $attendances->first()->classroom_id ?? null;
                @endphp

                <form action="{{ route('attendance.group.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <input type="hidden" name="classroom_id" value="{{ $classroomId }}">
                    <input type="hidden" name="attendance_date" value="{{ $date }}">

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Siswa</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $a)
                                <tr>
                                    <td>{{ $a->student->name ?? '-' }}</td>
                                    <td>
                                        @if($canEditGroup)
                                        <select name="attendances[{{ $a->student_id }}]" class="form-control">
                                            <option value="present" {{ $a->status === 'present' ? 'selected' : '' }}>Hadir</option>
                                            <option value="sick" {{ $a->status === 'sick' ? 'selected' : '' }}>Sakit</option>
                                            <option value="absent" {{ $a->status === 'absent' ? 'selected' : '' }}>Alpa</option>
                                        </select>
                                        @else
                                            {{ ucfirst($a->status) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(auth()->user()->hasRole('admin') || (auth()->user()->hasRole('instructor') && auth()->id() === $a->instructor_id))
                                            <a href="{{ route('attendance.edit', $a) }}" class="btn btn-sm btn-secondary">Edit Individual</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($canEditGroup)
                        <button class="btn btn-success">Simpan Perubahan</button>
                    @endif
                    <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            @endif

        </div>
    </div>
</div>
@endsection
