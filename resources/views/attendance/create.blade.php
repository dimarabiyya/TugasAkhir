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
                                <i class="mdi mdi-note-plus-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Buat Absensi Baru</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Catat kehadiran siswa untuk sesi ini</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
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

@if($students->isEmpty())

{{-- ===== EMPTY STATE ===== --}}
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body py-5 text-center">
                <div style="background: #fff3e8; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="mdi mdi-account-off-outline" style="font-size: 40px; color: #f6c23e;"></i>
                </div>
                <h5 class="font-weight-bold text-dark mb-2">Tidak Ada Siswa Terdaftar</h5>
                <p class="text-muted mb-4" style="font-size: 14px; max-width: 400px; margin: 0 auto 20px;">
                    Belum ada siswa terdaftar di kelas ini. Silakan periksa pengaturan kelas atau tambahkan siswa terlebih dahulu.
                </p>
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

<form action="{{ route('attendance.store') }}" method="POST" id="attendanceForm">
    @csrf
    <input type="hidden" name="course_id"    value="{{ $course->id }}">
    <input type="hidden" name="classroom_id" value="{{ $course->classroom_id }}">

    {{-- ===== TANGGAL SECTION ===== --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-calendar-outline" style="font-size: 20px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Tanggal Absensi</h5>
                            <small class="text-muted">Pilih tanggal sesi kehadiran ini</small>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <input type="date"
                                   id="attendance_date"
                                   name="attendance_date"
                                   class="form-control"
                                   value="{{ $attendanceDate ?? date('Y-m-d') }}"
                                   required
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                   onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                   onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';"
                                   onchange="updateDateBadge(this.value)">
                        </div>
                        <div class="col-md-8 mt-3 mt-md-0">
                            <div id="dateBadge" class="d-flex align-items-center" style="gap: 10px; flex-wrap: wrap;">
                                <span id="dateDisplay"
                                      style="background: #e8f0fe; color: #4e73df; border-radius: 8px; padding: 6px 14px; font-size: 13px; font-weight: 600;">
                                    <i class="mdi mdi-calendar-check mr-1"></i>
                                    <span id="dateText">{{ \Carbon\Carbon::parse($attendanceDate ?? date('Y-m-d'))->translatedFormat('l, d F Y') }}</span>
                                </span>
                                <span style="background: #f4f6fb; color: #858796; border-radius: 8px; padding: 6px 14px; font-size: 13px; font-weight: 600;">
                                    <i class="mdi mdi-account-multiple-outline mr-1"></i>
                                    {{ $students->count() }} siswa
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== STUDENTS TABLE ===== --}}
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
                                <h5 class="mb-0 font-weight-bold text-dark">Daftar Kehadiran Siswa</h5>
                                <small class="text-muted">{{ $students->count() }} siswa — klik tombol untuk mengubah status</small>
                            </div>
                        </div>

                        {{-- Quick select all --}}
                        <div class="d-none d-md-flex align-items-center" style="gap: 6px;">
                            <span class="text-muted mr-2" style="font-size: 12px;">Pilih semua:</span>
                            <button type="button" onclick="setAll('present')"
                                    style="background: #e3f9e5; color: #1cc88a; border: none; border-radius: 6px; padding: 5px 12px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s;"
                                    onmouseover="this.style.background='#1cc88a';this.style.color='#fff';"
                                    onmouseout="this.style.background='#e3f9e5';this.style.color='#1cc88a';">
                                <i class="mdi mdi-check-all mr-1"></i> Hadir
                            </button>
                            <button type="button" onclick="setAll('sick')"
                                    style="background: #fff3e8; color: #f6c23e; border: none; border-radius: 6px; padding: 5px 12px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s;"
                                    onmouseover="this.style.background='#f6c23e';this.style.color='#fff';"
                                    onmouseout="this.style.background='#fff3e8';this.style.color='#f6c23e';">
                                <i class="mdi mdi-medical-bag mr-1"></i> Sakit
                            </button>
                            <button type="button" onclick="setAll('absent')"
                                    style="background: #fde8e8; color: #e74a3b; border: none; border-radius: 6px; padding: 5px 12px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s;"
                                    onmouseover="this.style.background='#e74a3b';this.style.color='#fff';"
                                    onmouseout="this.style.background='#fde8e8';this.style.color='#e74a3b';">
                                <i class="mdi mdi-close-circle mr-1"></i> Alpa
                            </button>
                        </div>
                    </div>

                    {{-- Student Rows --}}
                    @foreach($students as $index => $student)
                    <div class="px-4 py-3 student-row"
                         style="border-bottom: 1px solid #f0f0f3; transition: background 0.15s ease;"
                         onmouseover="this.style.background='#fafbff';"
                         onmouseout="this.style.background='white';">

                        <div class="row align-items-center">

                            {{-- No + Nama --}}
                            <div class="col-12 col-md-5 mb-3 mb-md-0">
                                <div class="d-flex align-items-center" style="gap: 12px;">
                                    {{-- Nomor --}}
                                    <div style="background: #e8f0fe; color: #4e73df; border-radius: 8px; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0;">
                                        {{ $index + 1 }}
                                    </div>
                                    {{-- Avatar --}}
                                    @if($student->avatar)
                                        <img src="{{ asset('storage/' . $student->avatar) }}"
                                             alt="{{ $student->name }}"
                                             style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover; flex-shrink: 0; border: 2px solid #e8f0fe;">
                                    @else
                                        <div style="background: linear-gradient(135deg, #4e73df, #224abe); border-radius: 50%; width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <span class="text-white font-weight-bold" style="font-size: 15px;">
                                                {{ strtoupper(substr($student->name ?? '?', 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                    {{-- Info --}}
                                    <div>
                                        <p class="mb-0 font-weight-bold text-dark" style="font-size: 13.5px;">{{ $student->name ?? '-' }}</p>
                                        <small class="text-muted">{{ $student->email ?? '-' }}</small>
                                    </div>
                                </div>
                            </div>

                            {{-- Status Toggle Buttons --}}
                            <div class="col-12 col-md-7">
                                <div class="d-flex" style="gap: 6px; flex-wrap: wrap;">

                                    <label class="status-btn-label"
                                           style="margin: 0; cursor: pointer;">
                                        <input type="radio"
                                               name="attendances[{{ $student->id }}]"
                                               value="present"
                                               checked
                                               class="d-none status-radio"
                                               onchange="updateCounter()">
                                        <span class="status-pill"
                                              data-value="present"
                                              style="display: inline-flex; align-items: center; gap: 5px; padding: 7px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; border: 2px solid #1cc88a; background: #1cc88a; color: #fff; transition: all 0.15s; cursor: pointer; user-select: none;">
                                            <i class="mdi mdi-check-circle-outline" style="font-size: 15px;"></i> Hadir
                                        </span>
                                    </label>

                                    <label class="status-btn-label"
                                           style="margin: 0; cursor: pointer;">
                                        <input type="radio"
                                               name="attendances[{{ $student->id }}]"
                                               value="sick"
                                               class="d-none status-radio"
                                               onchange="updateCounter()">
                                        <span class="status-pill"
                                              data-value="sick"
                                              style="display: inline-flex; align-items: center; gap: 5px; padding: 7px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; border: 2px solid #e0e0e0; background: #f8f9fc; color: #9ca3af; transition: all 0.15s; cursor: pointer; user-select: none;">
                                            <i class="mdi mdi-medical-bag" style="font-size: 15px;"></i> Sakit
                                        </span>
                                    </label>

                                    <label class="status-btn-label"
                                           style="margin: 0; cursor: pointer;">
                                        <input type="radio"
                                               name="attendances[{{ $student->id }}]"
                                               value="absent"
                                               class="d-none status-radio"
                                               onchange="updateCounter()">
                                        <span class="status-pill"
                                              data-value="absent"
                                              style="display: inline-flex; align-items: center; gap: 5px; padding: 7px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; border: 2px solid #e0e0e0; background: #f8f9fc; color: #9ca3af; transition: all 0.15s; cursor: pointer; user-select: none;">
                                            <i class="mdi mdi-close-circle-outline" style="font-size: 15px;"></i> Alpa
                                        </span>
                                    </label>

                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach

                    {{-- Summary + Action Bar --}}
                    <div class="px-4 py-3" style="background: #fafbff; border-radius: 0 0 12px 12px; border-top: 1px solid #f0f0f3;">
                        <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 12px;">
                            {{-- Live summary --}}
                            <div class="d-flex align-items-center" style="gap: 8px; flex-wrap: wrap;">
                                <span class="text-muted" style="font-size: 12px;">Ringkasan:</span>
                                <span id="countPresent" style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 700;">
                                    <i class="mdi mdi-check-circle mr-1"></i><span id="numPresent">{{ $students->count() }}</span> Hadir
                                </span>
                                <span id="countSick" style="background: #fff3e8; color: #f6c23e; border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 700;">
                                    <i class="mdi mdi-medical-bag mr-1"></i><span id="numSick">0</span> Sakit
                                </span>
                                <span id="countAbsent" style="background: #fde8e8; color: #e74a3b; border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 700;">
                                    <i class="mdi mdi-close-circle mr-1"></i><span id="numAbsent">0</span> Alpa
                                </span>
                            </div>
                            {{-- Submit --}}
                            <div class="d-flex" style="gap: 8px;">
                                <a href="{{ route('attendance.index') }}"
                                   class="btn"
                                   style="background: #f4f6fb; color: #6b7280; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 20px; border: 1px solid #e3e6f0; transition: all 0.2s;"
                                   onmouseover="this.style.background='#e3e6f0';"
                                   onmouseout="this.style.background='#f4f6fb';">
                                    <i class="mdi mdi-arrow-left mr-1"></i> Batal
                                </a>
                                <button type="submit"
                                        style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 20px; border: none; box-shadow: 0 4px 12px rgba(78,115,223,0.3); transition: all 0.2s; cursor: pointer;"
                                        onmouseover="this.style.opacity='0.9';"
                                        onmouseout="this.style.opacity='1';">
                                    <i class="mdi mdi-content-save-outline mr-1"></i> Simpan Absensi
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</form>
@endif

@push('styles')
<style>
    /* Active pill styles */
    input[type="radio"].status-radio:checked + .status-pill[data-value="present"] {
        background: #1cc88a !important;
        border-color: #1cc88a !important;
        color: #fff !important;
    }
    input[type="radio"].status-radio:checked + .status-pill[data-value="sick"] {
        background: #f6c23e !important;
        border-color: #f6c23e !important;
        color: #fff !important;
    }
    input[type="radio"].status-radio:checked + .status-pill[data-value="absent"] {
        background: #e74a3b !important;
        border-color: #e74a3b !important;
        color: #fff !important;
    }

    /* Inactive pill hover */
    .status-pill:hover {
        border-color: #adb5bd !important;
        color: #5a5c69 !important;
        background: #f0f0f3 !important;
    }
    input[type="radio"].status-radio:checked + .status-pill:hover {
        opacity: 0.88;
    }
</style>
@endpush

@push('scripts')
<script>
    /* ===== DATE BADGE ===== */
    function updateDateBadge(val) {
        if (!val) return;
        const d = new Date(val + 'T00:00:00');
        const formatted = d.toLocaleDateString('id-ID', {
            weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
        });
        document.getElementById('dateText').textContent = formatted;
    }

    /* ===== LIVE COUNTER ===== */
    function updateCounter() {
        let present = 0, sick = 0, absent = 0;
        document.querySelectorAll('.status-radio:checked').forEach(r => {
            if (r.value === 'present') present++;
            else if (r.value === 'sick') sick++;
            else if (r.value === 'absent') absent++;
        });
        document.getElementById('numPresent').textContent = present;
        document.getElementById('numSick').textContent    = sick;
        document.getElementById('numAbsent').textContent  = absent;
    }

    /* ===== SET ALL ===== */
    function setAll(val) {
        document.querySelectorAll(`input[type="radio"][value="${val}"]`).forEach(r => {
            r.checked = true;
        });
        updateCounter();
    }

    /* Init counter on load */
    updateCounter();
</script>
@endpush

@endsection