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
                                <i class="mdi mdi-note-check-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Pilih Absensi</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Pilih kelas dan mata pelajaran untuk absensi siswa</p>
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

<div class="row justify-content-center">
    <div class="col-md-12 ">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">

                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-tune-variant" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Pilih Mata Pelajaran & Tanggal</h5>
                        <small class="text-muted">Tentukan sesi absensi yang ingin dibuat</small>
                    </div>
                </div>

                <form method="GET" action="{{ route('attendance.create') }}">
                    <div class="p-4">

                        <div class="mb-4">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-library-outline mr-1 text-muted"></i>
                                Mata Pelajaran <span class="text-danger">*</span>
                            </label>
                            <div style="position: relative;">
                                <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); z-index: 2; pointer-events: none;">
                                    <i class="mdi mdi-book-open-outline" style="font-size: 17px; color: #adb5bd;"></i>
                                </div>
                                <select name="course_id"
                                        id="course_id"
                                        class="form-control"
                                        required
                                        style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 46px; padding-left: 38px; appearance: none; -webkit-appearance: none; background: #fff; cursor: pointer;"
                                        onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                        onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                                    <option value="">— Pilih Mata Pelajaran —</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">
                                            {{ $course->title }} ({{ $course->classroom->name ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                <div style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                                    <i class="mdi mdi-chevron-down" style="font-size: 18px; color: #adb5bd;"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Tanggal --}}
                        <div class="mb-4">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-calendar-outline mr-1 text-muted"></i>
                                Tanggal Absensi <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                   name="attendance_date"
                                   id="attendance_date"
                                   class="form-control"
                                   value="{{ date('Y-m-d') }}"
                                   required
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 46px;"
                                   onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                   onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';"
                                   onchange="updateDatePreview(this.value)">

                            {{-- Date preview --}}
                            <div id="datePreview" class="mt-2">
                                <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 4px 12px; font-size: 12px; font-weight: 600;">
                                    <i class="mdi mdi-calendar-check mr-1"></i>
                                    <span id="datePreviewText">{{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}</span>
                                </span>
                            </div>
                        </div>

                    </div>

                    {{-- Action Bar --}}
                    <div class="px-4 py-3" style="border-top: 1px solid #f0f0f3; background: #fafbff; border-radius: 0 0 12px 12px;">
                        <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 10px;">
                            <p class="text-muted mb-0" style="font-size: 12px;">
                                <i class="mdi mdi-information-outline mr-1 text-primary"></i>
                                Pastikan mata pelajaran dan tanggal sudah benar
                            </p>
                            <div class="d-flex" style="gap: 8px;">
                                <a href="{{ route('attendance.index') }}"
                                   class="btn"
                                   style="background: #f4f6fb; color: #6b7280; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 20px; border: 1px solid #e3e6f0; transition: all 0.2s;"
                                   onmouseover="this.style.background='#e3e6f0';"
                                   onmouseout="this.style.background='#f4f6fb';">
                                    <i class="mdi mdi-close mr-1"></i> Batal
                                </a>
                                <button type="submit"
                                        style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 22px; border: none; box-shadow: 0 4px 12px rgba(78,115,223,0.3); transition: all 0.2s; cursor: pointer;"
                                        onmouseover="this.style.opacity='0.9';"
                                        onmouseout="this.style.opacity='1';">
                                    <i class="mdi mdi-arrow-right mr-1"></i> Lanjutkan
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateDatePreview(val) {
        if (!val) return;
        const d = new Date(val + 'T00:00:00');
        const formatted = d.toLocaleDateString('id-ID', {
            weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
        });
        document.getElementById('datePreviewText').textContent = formatted;
    }
</script>
@endpush

@endsection