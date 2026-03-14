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
                                <i class="mdi mdi-file-document-edit-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Edit Ujian</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">{{ $exam->title }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('exams.index') }}" class="btn btn-light font-weight-bold" style="border-radius: 8px; font-size: 13px;">
                            <i class="mdi mdi-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    {{-- ===== LEFT: Edit Form ===== --}}
    <div class="col-md-5 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">

            {{-- Section header --}}
            <div class="card-body border-bottom py-3 px-4" style="background: #f8f9fc; border-radius: 12px 12px 0 0;">
                <div class="d-flex align-items-center">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-pencil-outline" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <div>
                        <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">Detail Ujian</p>
                        <small class="text-muted">Ubah informasi ujian</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('exams.update', $exam->id) }}" method="POST">
                    @csrf @method('PUT')

                    {{-- Judul --}}
                    <div class="mb-4">
                        <label style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 6px; display: block;">
                            <i class="mdi mdi-format-title mr-1"></i> Judul Ujian
                        </label>
                        <input type="text" name="title" required
                               value="{{ $exam->title }}"
                               placeholder="Masukkan judul ujian..."
                               style="width: 100%; padding: 10px 14px; border: 1px solid #d1d3e2; border-radius: 8px; font-size: 13px; color: #3d3d3d; transition: border-color 0.2s; outline: none;"
                               onfocus="this.style.borderColor='#4e73df';"
                               onblur="this.style.borderColor='#d1d3e2';">
                    </div>

                    {{-- Pilih Kelas --}}
                    <div class="mb-4">
                        <label style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 6px; display: block;">
                            <i class="mdi mdi-google-classroom mr-1"></i> Pilih Kelas
                        </label>
                        <div style="border: 1px solid #d1d3e2; border-radius: 8px; padding: 10px 14px; background: #f8f9fc; display: flex; flex-direction: column; gap: 8px;">
                            @foreach($classrooms as $class)
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; margin: 0; padding: 6px 8px; border-radius: 6px; transition: background 0.15s;"
                                   onmouseover="this.style.background='#e8f0fe';"
                                   onmouseout="this.style.background='transparent';">
                                <input type="checkbox" name="classroom_ids[]"
                                       value="{{ $class->id }}"
                                       id="cl-{{ $class->id }}"
                                       {{ $exam->classrooms->contains($class->id) ? 'checked' : '' }}
                                       style="width: 16px; height: 16px; accent-color: #4e73df; cursor: pointer; flex-shrink: 0;">
                                <span style="font-size: 13px; color: #3d3d3d; font-weight: 500;">{{ $class->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Waktu --}}
                    <div class="row mb-4">
                        <div class="col-6">
                            <label style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 6px; display: block;">
                                <i class="mdi mdi-calendar-clock-outline mr-1"></i> Mulai
                            </label>
                            <input type="datetime-local" name="start_time"
                                   value="{{ \Carbon\Carbon::parse($exam->start_time)->format('Y-m-d\TH:i') }}"
                                   style="width: 100%; padding: 10px 14px; border: 1px solid #d1d3e2; border-radius: 8px; font-size: 13px; color: #3d3d3d; transition: border-color 0.2s; outline: none;"
                                   onfocus="this.style.borderColor='#4e73df';"
                                   onblur="this.style.borderColor='#d1d3e2';">
                        </div>
                        <div class="col-6">
                            <label style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 6px; display: block;">
                                <i class="mdi mdi-calendar-remove-outline mr-1"></i> Selesai
                            </label>
                            <input type="datetime-local" name="end_time"
                                   value="{{ \Carbon\Carbon::parse($exam->end_time)->format('Y-m-d\TH:i') }}"
                                   style="width: 100%; padding: 10px 14px; border: 1px solid #d1d3e2; border-radius: 8px; font-size: 13px; color: #3d3d3d; transition: border-color 0.2s; outline: none;"
                                   onfocus="this.style.borderColor='#4e73df';"
                                   onblur="this.style.borderColor='#d1d3e2';">
                        </div>
                    </div>

                    {{-- Durasi --}}
                    <div class="mb-4">
                        <label style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 6px; display: block;">
                            <i class="mdi mdi-timer-outline mr-1"></i> Durasi (Menit)
                        </label>
                        <input type="number" name="duration" min="1"
                               value="{{ $exam->duration }}"
                               placeholder="Contoh: 90"
                               style="width: 100%; padding: 10px 14px; border: 1px solid #d1d3e2; border-radius: 8px; font-size: 13px; color: #3d3d3d; transition: border-color 0.2s; outline: none;"
                               onfocus="this.style.borderColor='#4e73df';"
                               onblur="this.style.borderColor='#d1d3e2';">
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            style="width: 100%; padding: 11px; border-radius: 8px; border: none; background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; transition: opacity 0.2s;"
                            onmouseover="this.style.opacity='0.9';"
                            onmouseout="this.style.opacity='1';">
                        <i class="mdi mdi-content-save-outline" style="font-size: 16px;"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== RIGHT: Questions ===== --}}
    <div class="col-md-7 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">

            {{-- Section header --}}
            <div class="card-body border-bottom py-3 px-4 d-flex align-items-center justify-content-between" style="background: #f8f9fc; border-radius: 12px 12px 0 0;">
                <div class="d-flex align-items-center">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-help-circle-outline" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <div>
                        <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">Daftar Soal</p>
                        <small class="text-muted">{{ $exam->questions->count() }} soal terdaftar</small>
                    </div>
                </div>
                <button type="button" data-bs-toggle="modal" data-bs-target="#modalTambahSoal"
                        style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 8px; background: #e3f9e5; color: #1cc88a; font-size: 13px; font-weight: 600; border: 1px solid #b8efd8; cursor: pointer; transition: all 0.2s;"
                        onmouseover="this.style.background='#1cc88a';this.style.color='#fff';"
                        onmouseout="this.style.background='#e3f9e5';this.style.color='#1cc88a';">
                    <i class="mdi mdi-plus" style="font-size: 16px;"></i> Tambah Soal
                </button>
            </div>

            {{-- Questions List --}}
            <div class="card-body p-4">
                @forelse($exam->questions as $index => $q)
                <div style="border: 1px solid #eaecf4; border-radius: 10px; padding: 14px 16px; margin-bottom: 10px; transition: box-shadow 0.2s;"
                     onmouseover="this.style.boxShadow='0 4px 12px rgba(78,115,223,0.1)';"
                     onmouseout="this.style.boxShadow='';">

                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <div class="d-flex align-items-center" style="gap: 10px;">
                            <div style="background: #4e73df; color: #fff; border-radius: 6px; width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; flex-shrink: 0;">
                                {{ $index + 1 }}
                            </div>
                            <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px;">Soal #{{ $index + 1 }}</p>
                        </div>

                        {{-- Delete --}}
                        <form action="{{ route('exams.questions.destroy', [$exam->id, $q->id]) }}" method="POST" style="margin: 0;">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    onclick="return confirmDelete(event, 'Soal ini akan dihapus permanen!')"
                                    title="Hapus soal"
                                    style="width: 28px; height: 28px; border-radius: 6px; background: #fde8e8; color: #e74a3b; border: none; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; font-size: 13px; padding: 0;"
                                    onmouseover="this.style.background='#e74a3b';this.style.color='#fff';"
                                    onmouseout="this.style.background='#fde8e8';this.style.color='#e74a3b';">
                                <i class="mdi mdi-delete-outline"></i>
                            </button>
                        </form>
                    </div>

                    {{-- Question text --}}
                    <p class="mb-2 text-dark" style="font-size: 13px; line-height: 1.5; padding-left: 36px;">{{ $q->question_text }}</p>

                    {{-- Options --}}
                    @if(is_array($q->options) || is_object($q->options))
                    <div style="padding-left: 36px; display: flex; flex-direction: column; gap: 4px; margin-bottom: 8px;">
                        @foreach(['A','B','C','D'] as $opt)
                        @php $optVal = is_array($q->options) ? ($q->options[$opt] ?? null) : ($q->options->$opt ?? null); @endphp
                        @if($optVal)
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="background: {{ $q->correct_answer === $opt ? '#1cc88a' : '#f0f0f3' }}; color: {{ $q->correct_answer === $opt ? '#fff' : '#858796' }}; border-radius: 5px; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; flex-shrink: 0;">{{ $opt }}</span>
                            <span style="font-size: 12px; color: {{ $q->correct_answer === $opt ? '#1cc88a' : '#3d3d3d' }}; font-weight: {{ $q->correct_answer === $opt ? '600' : '400' }};">{{ $optVal }}</span>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @endif

                    {{-- Kunci --}}
                    <div style="padding-left: 36px; display: inline-flex; align-items: center; gap: 5px; background: #e3f9e5; border-radius: 6px; padding: 3px 10px 3px 10px;">
                        <i class="mdi mdi-key-outline" style="font-size: 13px; color: #1cc88a;"></i>
                        <span style="font-size: 11px; font-weight: 700; color: #1cc88a;">Kunci: {{ $q->correct_answer }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <div style="background: #f0f0f3; border-radius: 50%; width: 64px; height: 64px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                        <i class="mdi mdi-help-circle-outline" style="font-size: 32px; color: #c4c6d0;"></i>
                    </div>
                    <p class="text-muted mb-0" style="font-size: 13px;">Belum ada soal. Klik <strong>Tambah Soal</strong> untuk mulai.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

{{-- ===== MODAL TAMBAH SOAL ===== --}}
<div class="modal fade" id="modalTambahSoal" tabindex="-1" aria-labelledby="modalTambahSoalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('exams.questions.store', $exam->id) }}" method="POST">
            @csrf
            <div class="modal-content border-0" style="border-radius: 14px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">

                {{-- Modal Header --}}
                <div class="modal-header border-0 px-4 pt-4 pb-0">
                    <div class="d-flex align-items-center" style="gap: 10px;">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                            <i class="mdi mdi-plus-circle-outline" style="font-size: 20px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark" id="modalTambahSoalLabel" style="font-size: 15px;">Tambah Soal Pilihan Ganda</h5>
                            <small class="text-muted">Isi pertanyaan dan pilihan jawaban</small>
                        </div>
                    </div>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                            style="background: #f0f0f3; border: none; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #858796; cursor: pointer; padding: 0;">
                        <i class="mdi mdi-close"></i>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body px-4 py-3">

                    {{-- Pertanyaan --}}
                    <div class="mb-4">
                        <label style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 6px; display: block;">
                            <i class="mdi mdi-comment-question-outline mr-1"></i> Pertanyaan
                        </label>
                        <textarea name="question_text" required rows="3"
                                  placeholder="Tulis pertanyaan di sini..."
                                  style="width: 100%; padding: 10px 14px; border: 1px solid #d1d3e2; border-radius: 8px; font-size: 13px; color: #3d3d3d; resize: vertical; outline: none; transition: border-color 0.2s; font-family: inherit;"
                                  onfocus="this.style.borderColor='#4e73df';"
                                  onblur="this.style.borderColor='#d1d3e2';"></textarea>
                    </div>

                    {{-- Pilihan Jawaban --}}
                    <div class="mb-4">
                        <label style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 8px; display: block;">
                            <i class="mdi mdi-format-list-bulleted mr-1"></i> Pilihan Jawaban
                        </label>
                        @foreach(['A', 'B', 'C', 'D'] as $opt)
                        <div class="d-flex align-items-center mb-2" style="gap: 8px;">
                            <div style="background: #4e73df; color: #fff; border-radius: 6px; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0;">
                                {{ $opt }}
                            </div>
                            <input type="text" name="options[{{ $opt }}]" required
                                   placeholder="Pilihan {{ $opt }}..."
                                   style="flex: 1; padding: 9px 14px; border: 1px solid #d1d3e2; border-radius: 8px; font-size: 13px; color: #3d3d3d; outline: none; transition: border-color 0.2s;"
                                   onfocus="this.style.borderColor='#4e73df';"
                                   onblur="this.style.borderColor='#d1d3e2';">
                        </div>
                        @endforeach
                    </div>

                    {{-- Kunci Jawaban --}}
                    <div class="mb-2">
                        <label style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; margin-bottom: 6px; display: block;">
                            <i class="mdi mdi-key-outline mr-1"></i> Kunci Jawaban
                        </label>
                        <div style="display: flex; gap: 8px;">
                            @foreach(['A', 'B', 'C', 'D'] as $opt)
                            <label style="flex: 1; cursor: pointer;">
                                <input type="radio" name="correct_answer" value="{{ $opt }}" {{ $opt === 'A' ? 'checked' : '' }} style="display: none;" class="kunci-radio">
                                <div class="kunci-btn" data-opt="{{ $opt }}"
                                     style="padding: 8px; border-radius: 8px; border: 2px solid #d1d3e2; background: #f8f9fc; text-align: center; font-size: 13px; font-weight: 700; color: #858796; transition: all 0.2s; {{ $opt === 'A' ? 'border-color:#1cc88a;background:#e3f9e5;color:#1cc88a;' : '' }}">
                                    {{ $opt }}
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                </div>

                {{-- Modal Footer --}}
                <div class="modal-footer border-0 px-4 pb-4 pt-2 d-flex" style="gap: 8px;">
                    <button type="button" data-bs-dismiss="modal"
                            style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #d1d3e2; background: #fff; color: #858796; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.background='#f0f0f3';"
                            onmouseout="this.style.background='#fff';">
                        <i class="mdi mdi-close mr-1"></i> Batal
                    </button>
                    <button type="submit"
                            style="flex: 2; padding: 10px; border-radius: 8px; border: none; background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; transition: opacity 0.2s;"
                            onmouseover="this.style.opacity='0.9';"
                            onmouseout="this.style.opacity='1';">
                        <i class="mdi mdi-content-save-outline" style="font-size: 16px;"></i> Simpan Soal
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Kunci jawaban radio visual toggle
    document.querySelectorAll('.kunci-radio').forEach(function(radio) {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.kunci-btn').forEach(function(btn) {
                btn.style.borderColor = '#d1d3e2';
                btn.style.background  = '#f8f9fc';
                btn.style.color       = '#858796';
            });
            const activeBtn = document.querySelector('.kunci-btn[data-opt="' + radio.value + '"]');
            if (activeBtn) {
                activeBtn.style.borderColor = '#1cc88a';
                activeBtn.style.background  = '#e3f9e5';
                activeBtn.style.color       = '#1cc88a';
            }
        });
    });
</script>
@endpush

@endsection