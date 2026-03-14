@extends('layouts.skydash')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
            <div class="card-body py-4 px-4">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-7 mb-3 mb-xl-0">
                        <div class="d-flex align-items-center">
                            <div style="background: rgba(255,255,255,0.2); border-radius: 10px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; margin-right: 14px; flex-shrink: 0;">
                                <i class="mdi mdi-note-check-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Absensi</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Kelola segala absensi dan kehadiran siswa</p>
                            </div>
                        </div>
                    </div>
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
                    <div class="col-12 col-xl-5 d-flex justify-content-xl-end" style="gap: 8px;">
                        <a href="{{ route('attendance.recap') }}"
                           class="btn btn-light font-weight-bold"
                           style="border-radius: 8px; font-size: 13px;">
                            <i class="mdi mdi-chart-bar mr-1"></i> Rekap
                        </a>
                        <a href="{{ route('attendance.create') }}"
                           class="btn btn-light font-weight-bold"
                           style="border-radius: 8px; font-size: 13px; color: #4e73df;">
                            <i class="mdi mdi-plus mr-1"></i> Buat Absensi
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== TABLE CARD ===== --}}
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">

                {{-- Card Header --}}
                <div class="d-flex align-items-center justify-content-between px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div class="d-flex align-items-center">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-calendar-check-outline" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Daftar Grup Absensi</h5>
                            <small class="text-muted">
                                @if(isset($groups) && $groups->count())
                                    {{ $groups->count() }} sesi ditemukan
                                @else
                                    Belum ada data absensi
                                @endif
                            </small>
                        </div>
                    </div>
                </div>

                @if(isset($groups) && $groups->count())
                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table mb-0" style="border-collapse: separate; border-spacing: 0;">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th style="padding: 12px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; white-space: nowrap;">#</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; white-space: nowrap;">Tanggal</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Mata Pelajaran</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Kelas</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Guru</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groups as $index => $g)
                            <tr style="transition: background 0.15s ease;"
                                onmouseover="this.style.background='#f8f9fc';"
                                onmouseout="this.style.background='white';">

                                {{-- No --}}
                                <td style="padding: 14px 20px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 2px 8px; font-size: 12px; font-weight: 700;">
                                        {{ $index + 1 }}
                                    </span>
                                </td>

                                {{-- Tanggal --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                        <div style="background: #f0f4ff; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <i class="mdi mdi-calendar-outline" style="font-size: 16px; color: #4e73df;"></i>
                                        </div>
                                        <div>
                                            <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px;">
                                                {{ \Carbon\Carbon::parse($g->attendance_date)->format('d M Y') }}
                                            </p>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($g->attendance_date)->format('l') }}</small>
                                        </div>
                                    </div>
                                </td>

                                {{-- Mata Pelajaran --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                        <div style="background: #e3f9e5; border-radius: 6px; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <i class="mdi mdi-library-outline" style="font-size: 14px; color: #1cc88a;"></i>
                                        </div>
                                        <span style="font-size: 13px; color: #3d3d3d; font-weight: 500;">{{ $g->course->title ?? '-' }}</span>
                                    </div>
                                </td>

                                {{-- Kelas --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                        <div style="background: #fff3e8; border-radius: 6px; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <i class="mdi mdi-google-classroom" style="font-size: 14px; color: #f6c23e;"></i>
                                        </div>
                                        <span style="font-size: 13px; color: #3d3d3d; font-weight: 500;">{{ $g->classroom->name ?? '-' }}</span>
                                    </div>
                                </td>

                                {{-- Guru --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                        <div style="background: linear-gradient(135deg, #4e73df, #224abe); border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <img src="{{ $g->instructor->avatar_url }}" 
                                                 alt="Avatar" 
                                                 class="table-avatar">
                                        </div>
                                        <span style="font-size: 13px; color: #3d3d3d; font-weight: 500;">{{ $g->instructor->name ?? '-' }}</span>
                                    </div>
                                </td>

                                {{-- Aksi --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                                    @if(auth()->user()->hasRole('admin') || (auth()->user()->hasRole('instructor') && auth()->id() === $g->instructor_id))
                                    <div class="d-flex align-items-center justify-content-center" style="gap: 6px;">

                                        {{-- View --}}
                                        <a href="{{ route('attendance.show', ['course' => $g->course_id, 'date' => $g->attendance_date]) }}"
                                           class="btn btn-sm"
                                           title="Lihat Detail"
                                           style="background: #e8f0fe; color: #4e73df; border-radius: 8px; width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center; border: none; transition: all 0.2s;"
                                           onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                           onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                            <i class="mdi mdi-eye" style="font-size: 15px;"></i>
                                        </a>

                                        {{-- Edit --}}
                                        @if(auth()->user()->hasRole('admin') || (auth()->user()->hasRole('instructor') && auth()->id() === $g->instructor_id))
                                        <a href="{{ route('attendance.edit', ['course' => $g->course_id, 'date' => $g->attendance_date]) }}"
                                           class="btn btn-sm"
                                           title="Edit"
                                           style="background: #e8f0fe; color: #4e73df; border-radius: 8px; width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center; border: none; transition: all 0.2s;"
                                           onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                           onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                            <i class="mdi mdi-pencil" style="font-size: 15px;"></i>
                                        </a>
                                        @endif

                                        {{-- Delete --}}
                                        <form action="{{ route('attendance.destroyGroup') }}" method="POST" class="d-inline m-0"
                                              onsubmit="confirmDelete(event, 'Seluruh data kehadiran siswa di kelas ini pada tanggal tersebut akan terhapus permanen.');">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="course_id"       value="{{ $g->course_id }}">
                                            <input type="hidden" name="classroom_id"    value="{{ $g->classroom_id }}">
                                            <input type="hidden" name="attendance_date" value="{{ $g->attendance_date }}">
                                            <button type="submit"
                                                    title="Hapus"
                                                    style="background: #fde8e8; color: #e74a3b; border-radius: 8px; width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.2s;"
                                                    onmouseover="this.style.background='#e74a3b';this.style.color='#fff';"
                                                    onmouseout="this.style.background='#fde8e8';this.style.color='#e74a3b';">
                                                <i class="mdi mdi-delete" style="font-size: 15px;"></i>
                                            </button>
                                        </form>

                                    </div>
                                    @else
                                    <span class="text-muted" style="font-size: 12px;">—</span>
                                    @endif
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Footer --}}
                <div class="px-4 py-3" style="border-top: 1px solid #f0f0f3; background: #fafbff; border-radius: 0 0 12px 12px;">
                    <p class="text-muted mb-0" style="font-size: 12px;">
                        <i class="mdi mdi-information-outline mr-1"></i>
                        Menampilkan {{ $groups->count() }} sesi absensi
                    </p>
                </div>

                @else
                {{-- Empty State --}}
                <div class="text-center py-5">
                    <div style="background: #f0f0f3; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                        <i class="mdi mdi-calendar-remove-outline" style="font-size: 40px; color: #c4c6d0;"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-1">Belum Ada Data Absensi</h5>
                    <p class="text-muted mb-4" style="font-size: 14px;">Mulai buat sesi absensi untuk kelas Anda</p>
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
                    <a href="{{ route('attendance.create') }}"
                       class="btn btn-primary"
                       style="border-radius: 8px; font-weight: 600; padding: 10px 24px;">
                        <i class="mdi mdi-plus mr-1"></i> Buat Absensi Pertama
                    </a>
                    @endif
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection