@extends('layouts.skydash')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
            <div class="card-body py-4 px-4">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-8 mb-3 mb-xl-0">
                        <div class="d-flex align-items-center">
                            <div style="background: rgba(255,255,255,0.2); border-radius: 10px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; margin-right: 14px; flex-shrink: 0;">
                                <i class="mdi mdi-clipboard-list-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Daftar Absensi</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">
                                    {{ $course->title ?? '-' }}
                                    @if($course->classroom->name ?? false) &mdash; {{ $course->classroom->name }} @endif
                                    &mdash; {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end" style="gap: 8px;">
                        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
                        <a href="{{ route('attendance.create') }}"
                           class="btn font-weight-bold"
                           style="background: rgba(255,255,255,0.15); color: #fff; border-radius: 8px; font-size: 13px; border: 1px solid rgba(255,255,255,0.3);">
                            <i class="mdi mdi-plus mr-1"></i> Buat Absensi Baru
                        </a>
                        @endif
                        <a href="{{ route('attendance.index') }}"
                           class="btn font-weight-bold"
                           style="background: #fff; color: #4e73df; border-radius: 8px; font-size: 13px; border: none;">
                            <i class="mdi mdi-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== SUCCESS ALERT ===== --}}
@if(session('success'))
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #1cc88a !important;">
            <div class="card-body py-3 px-4 d-flex align-items-center" style="gap: 10px;">
                <i class="mdi mdi-check-circle-outline" style="font-size: 20px; color: #1cc88a; flex-shrink: 0;"></i>
                <p class="mb-0 font-weight-600 text-dark" style="font-size: 13px;">{{ session('success') }}</p>
            </div>
        </div>
    </div>
</div>
@endif

@if($attendances->isEmpty())

{{-- ===== EMPTY STATE ===== --}}
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body py-5 text-center">
                <div style="background: #e0f7fa; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="mdi mdi-clipboard-remove-outline" style="font-size: 40px; color: #17a2b8;"></i>
                </div>
                <h5 class="font-weight-bold text-dark mb-2">Tidak Ada Catatan Absensi</h5>
                <p class="text-muted mb-4" style="font-size: 14px;">Belum ada data absensi untuk grup ini.</p>
                <a href="{{ route('attendance.index') }}"
                   class="btn"
                   style="background: #f4f6fb; color: #6b7280; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 24px; border: 1px solid #e3e6f0;">
                    <i class="mdi mdi-arrow-left mr-1"></i> Kembali ke Daftar Absensi
                </a>
            </div>
        </div>
    </div>
</div>

@else

@php
    $canEditGroup  = auth()->user()->hasRole('admin') ||
                     (auth()->user()->hasRole('instructor') && auth()->id() === $attendances->first()->instructor_id);
    $classroomId   = $attendances->first()->classroom_id ?? null;
    $totalPresent  = $attendances->where('status', 'present')->count();
    $totalSick     = $attendances->where('status', 'sick')->count();
    $totalAbsent   = $attendances->where('status', 'absent')->count();
    $total         = $attendances->count();
@endphp

{{-- ===== STAT CARDS ===== --}}
<div class="row mb-4">
    <div class="col-6 col-md-3 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm text-center" style="border-radius: 12px;">
            <div class="card-body py-3 px-3">
                <div style="background: #e8f0fe; border-radius: 8px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;">
                    <i class="mdi mdi-account-multiple-outline" style="font-size: 20px; color: #4e73df;"></i>
                </div>
                <p class="font-weight-bold text-dark mb-0" style="font-size: 22px;">{{ $total }}</p>
                <small class="text-muted">Total Siswa</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm text-center" style="border-radius: 12px;">
            <div class="card-body py-3 px-3">
                <div style="background: #e3f9e5; border-radius: 8px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;">
                    <i class="mdi mdi-check-circle-outline" style="font-size: 20px; color: #1cc88a;"></i>
                </div>
                <p class="font-weight-bold text-dark mb-0" style="font-size: 22px;">{{ $totalPresent }}</p>
                <small class="text-muted">Total Hadir</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center" style="border-radius: 12px;">
            <div class="card-body py-3 px-3">
                <div style="background: #fff3e8; border-radius: 8px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;">
                    <i class="mdi mdi-medical-bag" style="font-size: 20px; color: #f6c23e;"></i>
                </div>
                <p class="font-weight-bold text-dark mb-0" style="font-size: 22px;">{{ $totalSick }}</p>
                <small class="text-muted">Total Sakit</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center" style="border-radius: 12px;">
            <div class="card-body py-3 px-3">
                <div style="background: #fde8e8; border-radius: 8px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;">
                    <i class="mdi mdi-close-circle-outline" style="font-size: 20px; color: #e74a3b;"></i>
                </div>
                <p class="font-weight-bold text-dark mb-0" style="font-size: 22px;">{{ $totalAbsent }}</p>
                <small class="text-muted">Total Alpa</small>
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
                            <i class="mdi mdi-account-group-outline" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Kehadiran Siswa</h5>
                            <small class="text-muted">{{ $total }} siswa terdaftar</small>
                        </div>
                    </div>

                    {{-- Legend --}}
                    <div class="d-none d-md-flex align-items-center" style="gap: 8px;">
                        <span style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">
                            <i class="mdi mdi-check-circle mr-1"></i>Hadir
                        </span>
                        <span style="background: #fff3e8; color: #f6c23e; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">
                            <i class="mdi mdi-medical-bag mr-1"></i>Sakit
                        </span>
                        <span style="background: #fde8e8; color: #e74a3b; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">
                            <i class="mdi mdi-close-circle mr-1"></i>Alpa
                        </span>
                    </div>
                </div>

                <form action="{{ route('attendance.group.update') }}" method="POST" id="attendanceForm">
                    @csrf
                    <input type="hidden" name="course_id"       value="{{ $course->id }}">
                    <input type="hidden" name="classroom_id"    value="{{ $classroomId }}">
                    <input type="hidden" name="attendance_date" value="{{ $date }}">

                    @foreach($attendances as $index => $a)
                    <div class="px-4 py-3"
                         style="border-bottom: 1px solid #f0f0f3; transition: background 0.15s ease;"
                         onmouseover="this.style.background='#fafbff';"
                         onmouseout="this.style.background='white';">

                        <div class="row align-items-center">

                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center" style="gap: 12px;">
                
                                    <div style="background: #e8f0fe; color: #4e73df; border-radius: 8px; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0;">
                                        {{ $index + 1 }}
                                    </div>
                                    
                                    @if($a->student->avatar ?? false)
                                        <img src="{{ asset('storage/' . $a->student->avatar) }}"
                                             alt="{{ $a->student->name }}"
                                             style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover; flex-shrink: 0; border: 2px solid #e8f0fe;">
                                    @else
                                        <div style="background: linear-gradient(135deg, #4e73df, #224abe); border-radius: 50%; width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <span class="text-white font-weight-bold" style="font-size: 15px;">
                                                {{ strtoupper(substr($a->student->name ?? '?', 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="mb-0 font-weight-bold text-dark" style="font-size: 13.5px;">{{ $a->student->name ?? '-' }}</p>
                                        <small class="text-muted">{{ $a->student->email ?? '-' }}</small>
                                    </div>
                                </div>
                            </div>

                            @if($canEditGroup)
                                <div class="col-md-2 mb-3 d-flex ">
                                    <span id="liveBadge-{{ $a->student_id }}"
                                        style="border-radius: 6px; padding: 4px 12px; font-size: 14px; font-weight: 700;
                                                {{ $a->status === 'present' ? 'background:#e3f9e5;color:#1cc88a;' :
                                                    ($a->status === 'sick'    ? 'background:#fff3e8;color:#f6c23e;' :
                                                                                'background:#fde8e8;color:#e74a3b;') }}">
                                        {{ $a->status === 'present' ? 'Hadir' : ($a->status === 'sick' ? 'Sakit' : 'Alpa') }}
                                    </span>
                                </div>
                            @endif

                            <div class="col-md-4 mb-3 d-flex justify-content-end">
                                @if($canEditGroup)
                                <div class="d-flex" style="gap: 6px; flex-wrap: wrap;">
                                    @foreach(['present' => ['','#1cc88a','mdi-check-circle-outline'], 'sick' => ['','#f6c23e','mdi-medical-bag'], 'absent' => ['','#e74a3b','mdi-close-circle-outline']] as $val => $cfg)
                                    <label style="margin: 0; cursor: pointer;">
                                        <input type="radio"
                                               name="attendances[{{ $a->student_id }}]"
                                               value="{{ $val }}"
                                               class="d-none status-radio-{{ $a->student_id }}"
                                               {{ $a->status === $val ? 'checked' : '' }}
                                               onchange="updateBadge({{ $a->student_id }}, '{{ $val }}')">
                                        <span class="status-pill-{{ $a->student_id }}-{{ $val }}"
                                              style="display: inline-flex; align-items: center; gap: 5px; padding: 6px 14px; border-radius: 8px; font-size: 12.5px; font-weight: 600; cursor: pointer; user-select: none; transition: all 0.15s;
                                                     {{ $a->status === $val
                                                         ? "background:{$cfg[1]};border:2px solid {$cfg[1]};color:#fff;"
                                                         : 'background:#f8f9fc;border:2px solid #e0e0e0;color:#9ca3af;' }}">
                                            <i class="mdi {{ $cfg[2] }}" style="font-size: 14px;"></i> {{ $cfg[0] }}
                                        </span>
                                    </label>
                                    @endforeach
                                </div>
                                @else
                                <span style="border-radius: 6px; padding: 5px 14px; font-size: 12.5px; font-weight: 700;
                                    {{ $a->status === 'present' ? 'background:#e3f9e5;color:#1cc88a;' :
                                       ($a->status === 'sick'    ? 'background:#fff3e8;color:#f6c23e;' :
                                                                    'background:#fde8e8;color:#e74a3b;') }}">
                                    <i class="mdi {{ $a->status === 'present' ? 'mdi-check-circle' : ($a->status === 'sick' ? 'mdi-medical-bag' : 'mdi-close-circle') }} mr-1"></i>
                                    {{ $a->status === 'present' ? 'Hadir' : ($a->status === 'sick' ? 'Sakit' : 'Alpa') }}
                                </span>
                                @endif
                            </div>

                        </div>
                    </div>
                    @endforeach

                    {{-- Action Bar --}}
                    <div class="px-4 py-3" style="background: #fafbff; border-top: 1px solid #f0f0f3; border-radius: 0 0 12px 12px;">
                        <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 10px;">
                            <p class="text-muted mb-0" style="font-size: 12px;">
                                <i class="mdi mdi-information-outline mr-1 text-primary"></i>
                                @if($canEditGroup)
                                    Ubah status siswa lalu klik simpan
                                @else
                                    Anda hanya dapat melihat data absensi ini
                                @endif
                            </p>
                            <div class="d-flex" style="gap: 8px;">
                                <a href="{{ route('attendance.index') }}"
                                   class="btn"
                                   style="background: #f4f6fb; color: #6b7280; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 20px; border: 1px solid #e3e6f0; transition: all 0.2s;"
                                   onmouseover="this.style.background='#e3e6f0';"
                                   onmouseout="this.style.background='#f4f6fb';">
                                    <i class="mdi mdi-arrow-left mr-1"></i> Kembali
                                </a>
                                @if($canEditGroup)
                                <button type="submit"
                                        style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 20px; border: none; box-shadow: 0 4px 12px rgba(78,115,223,0.3); transition: all 0.2s; cursor: pointer;"
                                        onmouseover="this.style.opacity='0.9';"
                                        onmouseout="this.style.opacity='1';">
                                    <i class="mdi mdi-content-save-outline mr-1"></i> Simpan Perubahan
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endif

@push('scripts')
<script>
    const statusLabels = { present: 'Hadir', sick: 'Sakit', absent: 'Alpa' };
    const statusBadgeStyle = {
        present: 'background:#e3f9e5;color:#1cc88a;',
        sick:    'background:#fff3e8;color:#f6c23e;',
        absent:  'background:#fde8e8;color:#e74a3b;'
    };
    const statusPillActive = {
        present: 'background:#1cc88a;border:2px solid #1cc88a;color:#fff;',
        sick:    'background:#f6c23e;border:2px solid #f6c23e;color:#fff;',
        absent:  'background:#e74a3b;border:2px solid #e74a3b;color:#fff;'
    };
    const statusPillInactive = 'background:#f8f9fc;border:2px solid #e0e0e0;color:#9ca3af;';

    function updateBadge(studentId, selectedVal) {
        // Update live badge
        const badge = document.getElementById('liveBadge-' + studentId);
        if (badge) {
            badge.textContent = statusLabels[selectedVal];
            badge.style.cssText = statusBadgeStyle[selectedVal] +
                'border-radius:6px;padding:4px 12px;font-size:11px;font-weight:700;';
        }

        // Update pill styles
        ['present', 'sick', 'absent'].forEach(val => {
            const pill = document.querySelector('.status-pill-' + studentId + '-' + val);
            if (pill) {
                pill.style.cssText = (val === selectedVal ? statusPillActive[val] : statusPillInactive) +
                    'display:inline-flex;align-items:center;gap:5px;padding:6px 14px;border-radius:8px;font-size:12.5px;font-weight:600;cursor:pointer;user-select:none;transition:all 0.15s;';
            }
        });
    }
</script>
@endpush

@endsection