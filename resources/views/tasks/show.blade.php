@extends('layouts.skydash')

@section('content')

@php $isAdmin = auth()->user()->hasAnyRole(['admin', 'instructor']); @endphp

{{-- ===== PAGE HEADER ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
            <div class="card-body py-4 px-4">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-8 mb-3 mb-xl-0">
                        <div class="d-flex align-items-center">
                            <div style="background: rgba(255,255,255,0.2); border-radius: 10px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; margin-right: 14px; flex-shrink: 0;">
                                <i class="mdi mdi-clipboard-text-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">{{ $task->title }}</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">
                                    <i class="mdi mdi-book-open-outline mr-1"></i>
                                    {{ optional($task->lesson)->title ?? 'Tanpa Materi' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end" style="gap: 8px; flex-wrap: wrap;">
                        @if($isAdmin)
                        <a href="{{ route('tasks.edit', $task->id) }}"
                           class="btn font-weight-bold"
                           style="background: rgba(255,255,255,0.15); color: #fff; border-radius: 8px; font-size: 13px; border: 1px solid rgba(255,255,255,0.3);">
                            <i class="mdi mdi-pencil mr-1"></i> Edit
                        </a>
                        @endif
                        <a href="{{ route('tasks.index') }}"
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

<div class="row">

    {{-- ===== LEFT: DETAIL TUGAS ===== --}}
    <div class="{{ $isAdmin ? 'col-md-12' : 'col-md-8' }} mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">

                {{-- Header --}}
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-text-box-outline" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Detail Tugas</h5>
                        <small class="text-muted">Instruksi dan informasi tugas</small>
                    </div>
                </div>

                <div class="p-4">
                    {{-- Meta info row --}}
                    <div class="d-flex flex-wrap mb-4" style="gap: 10px;">
                        <span style="background: {{ $task->status == 'published' ? '#e3f9e5' : '#fff3e8' }}; color: {{ $task->status == 'published' ? '#1cc88a' : '#f6c23e' }}; border-radius: 6px; padding: 4px 12px; font-size: 12px; font-weight: 700;">
                            <i class="mdi {{ $task->status == 'published' ? 'mdi-check-circle' : 'mdi-pencil' }} mr-1"></i>
                            {{ $task->status == 'published' ? 'Dipublikasikan' : 'Draf' }}
                        </span>
                        @if($task->due_date)
                        @php $overdue = \Carbon\Carbon::parse($task->due_date)->isPast(); @endphp
                        <span style="background: {{ $overdue ? '#fde8e8' : '#f4f6fb' }}; color: {{ $overdue ? '#e74a3b' : '#858796' }}; border-radius: 6px; padding: 4px 12px; font-size: 12px; font-weight: 600;">
                            <i class="mdi mdi-calendar-outline mr-1"></i>
                            Deadline: {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y, H:i') }}
                            @if($overdue) (Terlambat) @endif
                        </span>
                        @endif
                        @if($task->max_score)
                        <span style="background: #e0f7fa; color: #17a2b8; border-radius: 6px; padding: 4px 12px; font-size: 12px; font-weight: 600;">
                            <i class="mdi mdi-counter mr-1"></i> Nilai Maks: {{ $task->max_score }}
                        </span>
                        @endif
                    </div>

                    {{-- Instruksi --}}
                    <div class="p-4" style="background: #f8f9fc; border-radius: 10px; border: 1px solid #eaecf4;">
                        <h6 class="font-weight-bold text-dark mb-3" style="font-size: 13.5px;">
                            <i class="mdi mdi-format-list-bulleted mr-1 text-primary"></i> Instruksi Pengerjaan
                        </h6>
                        <div style="font-size: 13.5px; line-height: 1.7; color: #3d3d3d;">
                            {!! nl2br(e($task->instructions)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== ADMIN: Tabel Pengumpulan ===== --}}
        @if($isAdmin)
        <div class="card border-0 shadow-sm mt-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e3f9e5; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-account-group-outline" style="font-size: 18px; color: #1cc88a;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Daftar Pengumpulan Siswa</h5>
                        <small class="text-muted">{{ $task->submissions->count() }} siswa mengumpulkan</small>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th style="padding: 12px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Siswa</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Tipe</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Konten</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Status Nilai</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($task->submissions as $sub)
                            <tr style="transition: background 0.15s;" onmouseover="this.style.background='#f8f9fc';" onmouseout="this.style.background='white';">

                                {{-- Siswa --}}
                                <td style="padding: 13px 20px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                        <div style="background: linear-gradient(135deg, #4e73df, #224abe); border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <span class="text-white font-weight-bold" style="font-size: 12px;">{{ strtoupper(substr($sub->student->name ?? '?', 0, 1)) }}</span>
                                        </div>
                                        <span style="font-size: 13.5px; font-weight: 600; color: #2d3748;">{{ $sub->student->name }}</span>
                                    </div>
                                </td>

                                {{-- Tipe --}}
                                <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <span style="background: {{ $sub->submission_type == 'file' ? '#e0f7fa' : '#e8f0fe' }}; color: {{ $sub->submission_type == 'file' ? '#17a2b8' : '#4e73df' }}; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">
                                        <i class="mdi {{ $sub->submission_type == 'file' ? 'mdi-file-outline' : 'mdi-link-variant' }} mr-1"></i>
                                        {{ ucfirst($sub->submission_type) }}
                                    </span>
                                </td>

                                {{-- Konten --}}
                                <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    @if($sub->submission_type == 'file')
                                        <a href="{{ asset('storage/'.$sub->file_path) }}" target="_blank"
                                           style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 4px 12px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s;"
                                           onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                           onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                            <i class="mdi mdi-eye mr-1"></i> Lihat File
                                        </a>
                                    @else
                                        <a href="{{ $sub->link_url }}" target="_blank"
                                           style="background: #e0f7fa; color: #17a2b8; border-radius: 6px; padding: 4px 12px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s;"
                                           onmouseover="this.style.background='#17a2b8';this.style.color='#fff';"
                                           onmouseout="this.style.background='#e0f7fa';this.style.color='#17a2b8';">
                                            <i class="mdi mdi-open-in-new mr-1"></i> Buka Link
                                        </a>
                                    @endif
                                </td>

                                {{-- Status Nilai --}}
                                <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    @if($sub->grade)
                                        <span style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 700;">
                                            <i class="mdi mdi-check-circle mr-1"></i> {{ $sub->grade->score }}
                                        </span>
                                    @else
                                        <span style="background: #fff3e8; color: #f6c23e; border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 700;">
                                            <i class="mdi mdi-clock-outline mr-1"></i> Belum Dinilai
                                        </span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                                    <div class="d-flex align-items-center justify-content-center" style="gap: 6px;">
                                        <button type="button"
                                                data-bs-toggle="modal" data-bs-target="#gradeModal{{ $sub->id }}"
                                                style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border: none; border-radius: 8px; padding: 6px 12px; font-size: 12px; font-weight: 600; cursor: pointer; width: auto ; height: 32px;">
                                            <i class="mdi mdi-pencil mr-1"></i> {{ $sub->grade ? 'Edit Nilai' : 'Beri Nilai' }}
                                        </button>
                                        @if($sub->grade)
                                        <form action="{{ route('tasks.grade.destroy', $sub->grade->id) }}" method="POST" class="d-inline m-0"
                                              onsubmit="confirmDelete(event, 'Nilai ini akan dihapus.');">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    style="background: #fde8e8; color: #e74a3b; border: none; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;"
                                                    onmouseover="this.style.background='#e74a3b';this.style.color='#fff';"
                                                    onmouseout="this.style.background='#fde8e8';this.style.color='#e74a3b';">
                                                <i class="mdi mdi-delete" style="font-size: 15px;"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="padding: 40px; text-align: center;">
                                    <i class="mdi mdi-inbox-outline" style="font-size: 36px; color: #d1d3e2;"></i>
                                    <p class="text-muted mt-2 mb-0" style="font-size: 13px;">Belum ada siswa yang mengumpulkan tugas.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 d-flex justify-content-end">
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
                    <a href="{{ route('tasks.export', $task->id) }}" class="m-2"
                        style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; background: #e3f9e5; color: #1cc88a; font-size: 13px; font-weight: 600; text-decoration: none; border: 1px solid #b8efd8; transition: all 0.2s;"
                        onmouseover="this.style.background='#1cc88a';this.style.color='#fff';"
                        onmouseout="this.style.background='#e3f9e5';this.style.color='#1cc88a';">
                            <i class="mdi mdi-microsoft-excel" style="font-size: 16px;"></i> Export Excel
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endif

    </div>

    {{-- ===== RIGHT: FORM SUBMIT (Siswa) ===== --}}
    @if(!$isAdmin)
    <div class="col-md-4 mb-4">
        @php $mySub = $task->submissions->where('user_id', auth()->id())->first(); @endphp
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: {{ $mySub && $mySub->grade ? '#e3f9e5' : '#e8f0fe' }}; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi {{ $mySub && $mySub->grade ? 'mdi-check-circle-outline' : 'mdi-send-outline' }}" style="font-size: 18px; color: {{ $mySub && $mySub->grade ? '#1cc88a' : '#4e73df' }};"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Status Pengumpulan</h5>
                        <small class="text-muted">{{ $mySub ? ($mySub->grade ? 'Sudah dinilai' : 'Sudah dikumpulkan') : 'Belum dikumpulkan' }}</small>
                    </div>
                </div>

                <div class="p-4">

                    {{-- Nilai (jika sudah dinilai) --}}
                    @if($mySub && $mySub->grade)
                    <div class="text-center p-4 mb-4" style="background: #e3f9e5; border-radius: 10px; border: 1px solid #b7ebc8;">
                        <p class="text-muted mb-1" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Nilai Anda</p>
                        <h1 class="font-weight-bold mb-1" style="font-size: 48px; color: #1cc88a; line-height: 1;">{{ $mySub->grade->score }}</h1>
                        <p class="text-muted mb-0" style="font-size: 12px;">dari {{ $task->max_score ?? 100 }}</p>
                        @if($mySub->grade->feedback)
                        <div class="mt-3 p-3 text-left" style="background: #fff; border-radius: 8px; font-size: 12.5px; color: #3d3d3d; border: 1px solid #d1f2dd;">
                            <p class="mb-0 font-weight-bold text-dark" style="font-size: 12px; margin-bottom: 4px !important;">Feedback Guru:</p>
                            <p class="mb-0">{{ $mySub->grade->feedback }}</p>
                        </div>
                        @endif
                    </div>
                    @endif

                    {{-- Form Submit --}}
                    <form action="{{ route('tasks.submit', $task->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Tipe Pengumpulan --}}
                        <div class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">Tipe Pengumpulan</label>
                            <div style="position: relative;">
                                <select name="submission_type" id="sub_type" class="form-control"
                                        style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px; appearance: none; -webkit-appearance: none; padding-right: 36px; cursor: pointer;"
                                        onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                        onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                                    <option value="file">Upload File</option>
                                    <option value="link">Kirim Link</option>
                                </select>
                                <div style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                                    <i class="mdi mdi-chevron-down" style="font-size: 18px; color: #adb5bd;"></i>
                                </div>
                            </div>
                        </div>

                        {{-- File Upload --}}
                        <div id="file_input_group" class="form-group mb-3">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-paperclip mr-1 text-muted"></i> File (PDF/JPG/PNG)
                            </label>
                            <input type="file" name="file" class="form-control"
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13px;"
                                   onfocus="this.style.borderColor='#4e73df';" onblur="this.style.borderColor='#d1d3e2';">
                        </div>

                        {{-- Link Input --}}
                        <div id="link_input_group" class="form-group mb-3" style="display: none;">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-link-variant mr-1 text-muted"></i> URL
                            </label>
                            <input type="url" name="link_url" class="form-control"
                                   placeholder="https://..."
                                   style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; height: 44px;"
                                   onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                   onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                        </div>

                        {{-- Catatan --}}
                        <div class="form-group mb-4">
                            <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                                <i class="mdi mdi-note-outline mr-1 text-muted"></i> Catatan
                            </label>
                            <textarea name="notes" class="form-control" rows="3"
                                      placeholder="Tambahkan catatan opsional..."
                                      style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; resize: none;"
                                      onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                      onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">{{ $mySub->notes ?? '' }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-block"
                                style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 8px; font-weight: 600; font-size: 14px; padding: 11px; border: none; box-shadow: 0 4px 12px rgba(78,115,223,0.3);">
                            <i class="mdi mdi-send-outline mr-1"></i>
                            {{ $mySub ? 'Update Jawaban' : 'Kirim Jawaban' }}
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    @endif

</div>

{{-- ===== GRADING MODALS ===== --}}
@if($isAdmin)
@foreach($task->submissions as $sub)
<div class="modal fade" id="gradeModal{{ $sub->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0" style="border-radius: 16px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">

            {{-- Modal Header --}}
            <div style="background: linear-gradient(135deg, #4e73df, #224abe); padding: 18px 24px; display: flex; align-items: center; justify-content: space-between;">
                <div class="d-flex align-items-center" style="gap: 10px;">
                    <div style="background: rgba(255,255,255,0.2); border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center;">
                        <i class="mdi mdi-pencil text-white" style="font-size: 17px;"></i>
                    </div>
                    <div>
                        <h5 class="text-white mb-0 font-weight-bold" style="font-size: 14px;">Penilaian Tugas</h5>
                        <p class="text-white-50 mb-0" style="font-size: 12px;">{{ $sub->student->name }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" style="filter: brightness(0) invert(1); opacity: 0.8;"></button>
            </div>

            <form action="{{ route('tasks.grade', $sub->id) }}" method="POST">
                @csrf
                <div class="p-4">
                    {{-- File/Link preview --}}
                    <div class="mb-4 p-3" style="background: #f8f9fc; border-radius: 10px; border: 1px solid #eaecf4; text-align: center;">
                        @if($sub->submission_type == 'file')
                            <i class="mdi mdi-file-outline" style="font-size: 20px; color: #17a2b8;"></i>
                            <a href="{{ asset('storage/'.$sub->file_path) }}" target="_blank"
                               style="color: #17a2b8; font-size: 13px; font-weight: 600; text-decoration: none; margin-left: 6px;">
                                Lihat File Jawaban <i class="mdi mdi-open-in-new ml-1"></i>
                            </a>
                        @else
                            <i class="mdi mdi-link-variant" style="font-size: 20px; color: #4e73df;"></i>
                            <a href="{{ $sub->link_url }}" target="_blank"
                               style="color: #4e73df; font-size: 13px; font-weight: 600; text-decoration: none; margin-left: 6px;">
                                Buka Link Jawaban <i class="mdi mdi-open-in-new ml-1"></i>
                            </a>
                        @endif
                    </div>

                    {{-- Skor --}}
                    <div class="form-group mb-3">
                        <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">
                            Skor <span class="text-muted" style="font-weight: 400;">(0–{{ $task->max_score ?? 100 }})</span> <span class="text-danger">*</span>
                        </label>
                        <input type="number" name="score"
                               class="form-control text-center"
                               value="{{ $sub->grade->score ?? '' }}"
                               required min="0" max="{{ $task->max_score ?? 100 }}"
                               style="border-radius: 8px; border-color: #d1d3e2; font-size: 24px; font-weight: 700; height: 56px; color: #2d3748;"
                               onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                               onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                    </div>

                    {{-- Feedback --}}
                    <div class="form-group mb-0">
                        <label class="mb-2" style="font-size: 13px; font-weight: 600; color: #3d3d3d;">Feedback / Catatan</label>
                        <textarea name="feedback" class="form-control" rows="3"
                                  placeholder="Tulis masukan untuk siswa..."
                                  style="border-radius: 8px; border-color: #d1d3e2; font-size: 13.5px; resize: none;"
                                  onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                  onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">{{ $sub->grade->feedback ?? '' }}</textarea>
                    </div>
                </div>

                <div class="px-4 pb-4 d-flex justify-content-end" style="gap: 8px;">
                    <button type="button" data-bs-dismiss="modal"
                            style="background: #f4f6fb; color: #6b7280; border-radius: 8px; font-weight: 600; font-size: 13px; padding: 9px 18px; border: 1px solid #e3e6f0; cursor: pointer;">
                        Batal
                    </button>
                    <button type="submit"
                            style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 8px; font-weight: 600; font-size: 13px; padding: 9px 18px; border: none; box-shadow: 0 4px 12px rgba(78,115,223,0.3); cursor: pointer;">
                        <i class="mdi mdi-content-save-outline mr-1"></i> Simpan Nilai
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endforeach
@endif

@push('scripts')
<script>
    // Toggle file/link input
    document.getElementById('sub_type') && document.getElementById('sub_type').addEventListener('change', function() {
        if (this.value === 'file') {
            document.getElementById('file_input_group').style.display = 'block';
            document.getElementById('link_input_group').style.display = 'none';
        } else {
            document.getElementById('file_input_group').style.display = 'none';
            document.getElementById('link_input_group').style.display = 'block';
        }
    });
</script>
@endpush

@endsection