@extends('layouts.skydash')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
            <div class="card-body py-4 px-4">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-8 mb-3 mb-xl-0">
                        <div class="d-flex align-items-center">
                            <div style="background: rgba(255,255,255,0.2); border-radius: 10px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; margin-right: 14px; flex-shrink: 0;">
                                <i class="mdi mdi-comment-plus-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Bagikan Pengalaman Anda</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Berikan penilaian untuk membantu sekolah berkembang lebih baik</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('testimonials.create') }}" class="btn btn-light font-weight-bold" style="border-radius: 8px; font-size: 13px;">
                            <i class="mdi mdi-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">

        <form action="{{ route('testimonials.store') }}" method="POST">
            @csrf

            {{-- ===== SECTION 1: Mata Pelajaran ===== --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body border-bottom py-3 px-4" style="background: #f8f9fc; border-radius: 12px 12px 0 0;">
                    <div class="d-flex align-items-center">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-library-outline" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">
                                Mata Pelajaran
                                <span style="background: #f0f0f3; color: #858796; border-radius: 20px; padding: 2px 8px; font-size: 10px; font-weight: 600; margin-left: 4px;">Opsional</span>
                            </p>
                            <small class="text-muted">Pilih jika aduan ini terkait mata pelajaran tertentu</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div style="position: relative;">
                        <select name="course_id"
                                style="width: 100%; padding: 10px 36px 10px 14px; border: 1px solid {{ $errors->has('course_id') ? '#e74a3b' : '#d1d3e2' }}; border-radius: 8px; font-size: 13px; color: #3d3d3d; background: #fff; appearance: none; -webkit-appearance: none; outline: none; transition: border-color 0.2s; cursor: pointer;"
                                onfocus="this.style.borderColor='#4e73df';"
                                onblur="this.style.borderColor='{{ $errors->has('course_id') ? '#e74a3b' : '#d1d3e2' }}';">
                            <option value="">— Aduan Umum (tidak terkait mata pelajaran) —</option>
                            @foreach($enrolledCourses ?? [] as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}{{ $course->instructor ? ' — oleh ' . $course->instructor->name : '' }}
                            </option>
                            @endforeach
                        </select>
                        <i class="mdi mdi-chevron-down" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); font-size: 18px; color: #adb5bd; pointer-events: none;"></i>
                    </div>
                    @error('course_id')
                        <p style="font-size: 11px; color: #e74a3b; margin-top: 5px; display: flex; align-items: center; gap: 4px;">
                            <i class="mdi mdi-alert-circle-outline"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- ===== SECTION 2: Rating ===== --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body border-bottom py-3 px-4" style="background: #f8f9fc; border-radius: 12px 12px 0 0;">
                    <div class="d-flex align-items-center">
                        <div style="background: #fff3cd; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-star-outline" style="font-size: 18px; color: #f6c23e;"></i>
                        </div>
                        <div>
                            <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">
                                Penilaian
                                <span style="background: #f0f0f3; color: #858796; border-radius: 20px; padding: 2px 8px; font-size: 10px; font-weight: 600; margin-left: 4px;">Opsional</span>
                            </p>
                            <small class="text-muted">Nilai pengalaman kamu secara keseluruhan (1–5 bintang)</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center" style="gap: 6px;" id="star-container">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button"
                                class="star-btn"
                                data-value="{{ $i }}"
                                style="background: none; border: none; padding: 4px; cursor: pointer; transition: transform 0.15s;"
                                onmouseover="hoverStars({{ $i }})"
                                onmouseout="resetStars()"
                                onclick="selectStar({{ $i }})">
                            <i class="mdi mdi-star" id="star-{{ $i }}" style="font-size: 34px; color: #e0e0e0; transition: color 0.15s;"></i>
                        </button>
                        @endfor
                        <input type="hidden" name="rating" id="rating-value" value="{{ old('rating', '') }}">
                        <span id="rating-label" style="margin-left: 8px; font-size: 13px; color: #858796; font-weight: 600;"></span>
                    </div>
                    @error('rating')
                        <p style="font-size: 11px; color: #e74a3b; margin-top: 8px; display: flex; align-items: center; gap: 4px;">
                            <i class="mdi mdi-alert-circle-outline"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- ===== SECTION 3: Isi Aduan ===== --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body border-bottom py-3 px-4" style="background: #f8f9fc; border-radius: 12px 12px 0 0;">
                    <div class="d-flex align-items-center">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-text-box-edit-outline" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">Isi Aduan / Testimoni <span style="color: #e74a3b;">*</span></p>
                            <small class="text-muted">Minimal 20 karakter, maksimal 1000 karakter</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <textarea name="testimonial_text"
                              id="testimonial_text"
                              rows="6"
                              required
                              placeholder="Ceritakan pengalamanmu — apa yang kamu pelajari, bagaimana membantu kamu, atau masukan untuk perbaikan..."
                              style="width: 100%; padding: 12px 14px; border: 1px solid {{ $errors->has('testimonial_text') ? '#e74a3b' : '#d1d3e2' }}; border-radius: 8px; font-size: 13px; color: #3d3d3d; resize: vertical; outline: none; transition: border-color 0.2s; font-family: inherit; line-height: 1.6;"
                              onfocus="this.style.borderColor='#4e73df';"
                              onblur="this.style.borderColor='{{ $errors->has('testimonial_text') ? '#e74a3b' : '#d1d3e2' }}';">{{ old('testimonial_text') }}</textarea>

                    {{-- Character counter --}}
                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <div>
                            @error('testimonial_text')
                                <p style="font-size: 11px; color: #e74a3b; margin: 0; display: flex; align-items: center; gap: 4px;">
                                    <i class="mdi mdi-alert-circle-outline"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <div id="char-bar-wrap" style="width: 80px; height: 4px; background: #f0f0f3; border-radius: 4px; overflow: hidden;">
                                <div id="char-bar" style="height: 100%; width: 0%; border-radius: 4px; background: #e74a3b; transition: width 0.3s, background 0.3s;"></div>
                            </div>
                            <small id="char-count" style="font-size: 11px; color: #e74a3b; font-weight: 600; min-width: 60px; text-align: right;">0 / 1000</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== INFO NOTICE ===== --}}
            <div style="background: #e8f0fe; border: 1px solid #c5d5f8; border-radius: 10px; padding: 14px 16px; display: flex; align-items: flex-start; gap: 10px; margin-bottom: 20px;">
                <i class="mdi mdi-information-outline" style="font-size: 18px; color: #4e73df; flex-shrink: 0; margin-top: 1px;"></i>
                <div>
                    <p class="mb-0 font-weight-bold" style="font-size: 13px; color: #4e73df;">Perlu Ditinjau Dulu</p>
                    <p class="mb-0" style="font-size: 12px; color: #5a7fd4; margin-top: 2px;">Testimoni / aduan kamu akan ditinjau sebelum dipublikasikan. Ini membantu menjaga kualitas dan keaslian konten.</p>
                </div>
            </div>

            {{-- ===== ACTION BAR ===== --}}
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body py-3 px-4 d-flex align-items-center justify-content-between" style="gap: 10px;">
                    <p class="mb-0 text-muted" style="font-size: 12px;">
                        <i class="mdi mdi-shield-check-outline mr-1" style="color: #1cc88a;"></i>
                        Testimoni bersifat anonim dan aman
                    </p>
                    <div class="d-flex" style="gap: 8px;">
                        <a href="{{ route('testimonials.index') }}"
                           style="padding: 10px 18px; border-radius: 8px; border: 1px solid #d1d3e2; background: #fff; color: #858796; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; white-space: nowrap;"
                           onmouseover="this.style.background='#f0f0f3';"
                           onmouseout="this.style.background='#fff';">
                            <i class="mdi mdi-close" style="font-size: 15px;"></i> Batal
                        </a>
                        <button type="submit"
                                style="padding: 10px 20px; border-radius: 8px; border: none; background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: opacity 0.2s; white-space: nowrap; box-shadow: 0 4px 12px rgba(78,115,223,0.35);"
                                onmouseover="this.style.opacity='0.9';"
                                onmouseout="this.style.opacity='1';">
                            <i class="mdi mdi-send-outline" style="font-size: 16px;"></i> Kirim Testimoni
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>
const ratingLabels = { 1: 'Sangat Buruk', 2: 'Buruk', 3: 'Cukup', 4: 'Baik', 5: 'Sangat Baik' };
let selectedRating = {{ old('rating', 0) }};

function paintStars(upTo, color) {
    for (let i = 1; i <= 5; i++) {
        document.getElementById(`star-${i}`).style.color = i <= upTo ? color : '#e0e0e0';
    }
}

function hoverStars(val) { paintStars(val, '#ffb606'); }

function resetStars() {
    if (selectedRating) {
        paintStars(selectedRating, '#ffb606');
        document.getElementById('rating-label').textContent = ratingLabels[selectedRating];
    } else {
        paintStars(0, '#e0e0e0');
        document.getElementById('rating-label').textContent = '';
    }
}

function selectStar(val) {
    selectedRating = val;
    document.getElementById('rating-value').value = val;
    paintStars(val, '#ffb606');
    document.getElementById('rating-label').textContent = ratingLabels[val];
}

// Init if old value
if (selectedRating) { paintStars(selectedRating, '#ffb606'); document.getElementById('rating-label').textContent = ratingLabels[selectedRating]; }

// Character counter
const textarea = document.getElementById('testimonial_text');
const charCount = document.getElementById('char-count');
const charBar   = document.getElementById('char-bar');
const MIN = 20, MAX = 1000;

function updateCounter() {
    const len = textarea.value.length;
    const pct = Math.min((len / MAX) * 100, 100);
    charCount.textContent = len + ' / ' + MAX;
    charBar.style.width = pct + '%';

    if (len === 0 || len < MIN) {
        charCount.style.color = '#e74a3b';
        charBar.style.background = '#e74a3b';
    } else if (len > MAX) {
        charCount.style.color = '#e74a3b';
        charBar.style.background = '#e74a3b';
    } else if (len > MAX * 0.85) {
        charCount.style.color = '#f6c23e';
        charBar.style.background = '#f6c23e';
    } else {
        charCount.style.color = '#1cc88a';
        charBar.style.background = '#1cc88a';
    }
}

textarea.addEventListener('input', updateCounter);
updateCounter();
</script>
@endpush

@endsection