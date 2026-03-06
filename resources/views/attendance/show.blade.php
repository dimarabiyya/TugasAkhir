@extends('layouts.skydash')

@section('content')

<div class="col-md-12 grid-margin">

        <div class="row mb-5">
            <div class="col-12 col-xl-8  mb-xl-0">
                <div class="d-flex align-items-center">
                    <div>
                        <h3 class="font-weight-bold mb-2">Daftar Absensi</h3>
                        <p class="text-muted mb-0">Daftar siswa absensi!</p>
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
                    <h4>Absensi - {{ $course->title ?? '-' }} ({{ $course->classroom->name ?? 'N/A' }}) ({{ $date }})</h4>

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
                                            <th>Siswa</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($attendances as $a)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    @if($a->student->avatar)
                                                        <img src="{{ asset('storage/' . $a->student->avatar) }}"
                                                            alt="{{ $a->student->name }}"
                                                            class="rounded-circle"
                                                            width="40" height="40"
                                                            style="object-fit: cover;">
                                                    @else
                                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white fw-bold"
                                                            style="width:40px; height:40px; font-size:16px; flex-shrink:0;">
                                                            {{ strtoupper(substr($a->student->name ?? '?', 0, 1)) }}
                                                        </div>
                                                    @endif
                                                    <span>{{ $a->student->name ?? '-' }}</span>
                                                </div>
                                            </td>
                                            <td class="text-muted" style="vertical-align: middle;">
                                                {{ $a->student->email ?? '-' }}
                                            </td>
                                            <td style="vertical-align: middle;">
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
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if($canEditGroup)
                                <button class="btn btn-primary">Simpan Perubahan</button>
                            @endif
                            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
