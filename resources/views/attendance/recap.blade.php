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
                                <i class="mdi mdi-chart-bar text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Rekap Absensi</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Export rekap kehadiran siswa ke format Excel</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('attendance.index') }}"
                           class="btn btn-light font-weight-bold"
                           style="border-radius: 8px; font-size: 13px;">
                            <i class="mdi mdi-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== FORM CARD ===== --}}
<div class="row justify-content-center">
    <div class="col-md-12">
        <form action="{{ route('attendance.export') }}" method="POST">
            @csrf

            {{-- Section: Mata Pelajaran --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-library-outline" style="font-size: 20px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Mata Pelajaran</h5>
                            <small class="text-muted">Pilih kelas yang ingin direkap</small>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="text-dark font-weight-600 mb-2" style="font-size: 13px; font-weight: 600;">
                            Mata Pelajaran / Kelas <span class="text-danger">*</span>
                        </label>
                        <div style="position: relative;">
                            <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); z-index: 2; pointer-events: none;">
                                <i class="mdi mdi-book-open-outline" style="font-size: 17px; color: #adb5bd;"></i>
                            </div>
                            <select name="course_id"
                                    class="form-control"
                                    required
                                    style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px; padding-left: 38px; appearance: none; -webkit-appearance: none; background-color: #fff;"
                                    onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                    onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">
                                        {{ $course->title }} — {{ $course->classroom->name ?? 'Kelas' }}
                                    </option>
                                @endforeach
                            </select>
                            <div style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                                <i class="mdi mdi-chevron-down" style="font-size: 18px; color: #adb5bd;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section: Rentang Tanggal --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div style="background: #e3f9e5; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-calendar-range-outline" style="font-size: 20px; color: #1cc88a;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Rentang Tanggal</h5>
                            <small class="text-muted">Tentukan periode rekap absensi</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-dark mb-2" style="font-size: 13px; font-weight: 600;">
                                <i class="mdi mdi-calendar-start mr-1 text-muted"></i> Dari Tanggal <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                   name="start_date"
                                   class="form-control"
                                   required
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                   onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                   onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark mb-2" style="font-size: 13px; font-weight: 600;">
                                <i class="mdi mdi-calendar-end mr-1 text-muted"></i> Sampai Tanggal <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                   name="end_date"
                                   class="form-control"
                                   required
                                   value="{{ date('Y-m-d') }}"
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                   onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                   onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                        </div>
                    </div>

                    {{-- Range preview --}}
                    <div id="rangePreview" class="mt-3 px-3 py-2" style="background: #f8f9fc; border-radius: 8px; border: 1px solid #eaecf4; display: none;">
                        <p class="mb-0 text-muted" style="font-size: 12px;">
                            <i class="mdi mdi-information-outline mr-1 text-primary"></i>
                            Rekap dari <strong id="previewStart" class="text-dark"></strong> hingga <strong id="previewEnd" class="text-dark"></strong>
                            <span id="previewDays" class="ml-1" style="background: #e8f0fe; color: #4e73df; border-radius: 4px; padding: 1px 7px; font-size: 11px; font-weight: 600;"></span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Action Bar --}}
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body px-4 py-3">
                    <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 10px;">
                        <p class="text-muted mb-0" style="font-size: 12px;">
                            <i class="mdi mdi-file-excel-outline mr-1 text-success"></i>
                            File akan diunduh dalam format <strong>.xlsx</strong>
                        </p>
                        <div class="d-flex" style="gap: 8px;">
                            <a href="{{ route('attendance.index') }}"
                               class="btn"
                               style="background: #f4f6fb; color: #6b7280; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 20px; border: 1px solid #e3e6f0; transition: all 0.2s;"
                               onmouseover="this.style.background='#e3e6f0';"
                               onmouseout="this.style.background='#f4f6fb';">
                                <i class="mdi mdi-arrow-left mr-1"></i> Batal
                            </a>
                            <button type="submit"
                                    class="btn"
                                    style="background: #1cc88a; color: #fff; border-radius: 8px; font-weight: 600; font-size: 13.5px; padding: 9px 20px; border: none; transition: all 0.2s;"
                                    onmouseover="this.style.background='#17a673';"
                                    onmouseout="this.style.background='#1cc88a';">
                                <i class="mdi mdi-file-excel mr-1"></i> Download Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>
    // Date range preview
    const startInput = document.querySelector('[name="start_date"]');
    const endInput   = document.querySelector('[name="end_date"]');
    const preview    = document.getElementById('rangePreview');
    const previewStart = document.getElementById('previewStart');
    const previewEnd   = document.getElementById('previewEnd');
    const previewDays  = document.getElementById('previewDays');

    function formatDate(dateStr) {
        if (!dateStr) return '';
        const d = new Date(dateStr);
        return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    }

    function updatePreview() {
        const s = startInput.value;
        const e = endInput.value;
        if (s && e && s <= e) {
            const diff = Math.round((new Date(e) - new Date(s)) / (1000 * 60 * 60 * 24)) + 1;
            previewStart.textContent = formatDate(s);
            previewEnd.textContent   = formatDate(e);
            previewDays.textContent  = diff + ' hari';
            preview.style.display    = 'block';
        } else {
            preview.style.display = 'none';
        }
    }

    startInput.addEventListener('change', updatePreview);
    endInput.addEventListener('change', updatePreview);
    updatePreview(); // run on load if end_date is pre-filled
</script>
@endpush

@endsection