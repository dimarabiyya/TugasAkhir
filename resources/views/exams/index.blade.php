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
                                <h4 class="font-weight-bold text-white mb-0">Manajemen Ujian</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Kelola semua ujian dan jadwal pelaksanaannya</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('exams.create') }}" class="btn btn-light font-weight-bold" style="border-radius: 8px; font-size: 13px; color: #4e73df;">
                            <i class="mdi mdi-plus mr-1"></i> Tambah Ujian
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== STAT CARDS ===== --}}
@php
    $total      = $exams->count();
    $selesai    = $exams->filter(fn($e) => now() > $e->end_time)->count();
    $berlangsung = $exams->filter(fn($e) => now() >= $e->start_time && now() <= $e->end_time)->count();
    $mendatang  = $exams->filter(fn($e) => now() < $e->start_time)->count();
@endphp

<div class="row mb-4">
    @foreach([
        ['label' => 'Total Ujian',    'value' => $total,       'icon' => 'mdi-file-document-multiple-outline', 'bg' => '#e8f0fe', 'color' => '#4e73df'],
        ['label' => 'Berlangsung',    'value' => $berlangsung, 'icon' => 'mdi-play-circle-outline',            'bg' => '#e3f9e5', 'color' => '#1cc88a'],
        ['label' => 'Mendatang',      'value' => $mendatang,   'icon' => 'mdi-clock-outline',                 'bg' => '#fff3cd', 'color' => '#f6c23e'],
        ['label' => 'Selesai',        'value' => $selesai,     'icon' => 'mdi-check-circle-outline',          'bg' => '#f0f0f3', 'color' => '#858796'],
    ] as $stat)
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-3 d-flex align-items-center" style="gap: 12px;">
                <div style="background: {{ $stat['bg'] }}; border-radius: 10px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="mdi {{ $stat['icon'] }}" style="font-size: 22px; color: {{ $stat['color'] }};"></i>
                </div>
                <div>
                    <p class="mb-0 text-muted" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">{{ $stat['label'] }}</p>
                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 22px; line-height: 1.2;">{{ $stat['value'] }}</p>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ===== TABLE CARD ===== --}}
<div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">

    {{-- Section Header --}}
    <div class="card-body border-bottom py-3 px-4" style="background: #f8f9fc;">
        <div class="d-flex align-items-center">
            <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                <i class="mdi mdi-format-list-bulleted" style="font-size: 18px; color: #4e73df;"></i>
            </div>
            <div>
                <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">Daftar Ujian</p>
                <small class="text-muted">{{ $total }} ujian terdaftar</small>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card-body p-0">
        @if($exams->count() > 0)
        <div class="table-responsive">
            <table class="table mb-0" style="border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr style="background: #f8f9fc;">
                        <th style="padding: 12px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Ujian</th>
                        <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Mata Pelajaran</th>
                        <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Kelas</th>
                        <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Jadwal</th>
                        <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Status</th>
                        <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exams as $exam)
                    @php
                        $isPast    = now() > $exam->end_time;
                        $isActive  = now() >= $exam->start_time && now() <= $exam->end_time;
                        $isFuture  = now() < $exam->start_time;
                    @endphp
                    <tr style="transition: background 0.15s ease;"
                        onmouseover="this.style.background='#f8f9fc';"
                        onmouseout="this.style.background='white';">

                        {{-- Ujian --}}
                        <td style="padding: 14px 20px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                            <div class="d-flex align-items-center">
                                <div style="background: #e8f0fe; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                    <i class="mdi mdi-file-document-outline" style="font-size: 18px; color: #4e73df;"></i>
                                </div>
                                <div>
                                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px;">{{ $exam->title }}</p>
                                    <small class="text-muted">
                                        <i class="mdi mdi-help-circle-outline mr-1"></i>{{ $exam->questions->count() }} soal
                                    </small>
                                </div>
                            </div>
                        </td>

                        {{-- Mata Pelajaran --}}
                        <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                            <p class="mb-0 text-dark" style="font-size: 13px;">{{ $exam->course->title }}</p>
                        </td>

                        {{-- Kelas --}}
                        <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                            <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                                @foreach($exam->classrooms as $class)
                                <span style="background: #e0f7fa; color: #17a2b8; border-radius: 6px; padding: 2px 8px; font-size: 11px; font-weight: 600;">
                                    {{ $class->name }}
                                </span>
                                @endforeach
                            </div>
                        </td>

                        {{-- Jadwal --}}
                        <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                            <p class="mb-0" style="font-size: 12px; color: #3d3d3d;">
                                <i class="mdi mdi-calendar-outline mr-1" style="color: #4e73df;"></i>
                                {{ $exam->start_time->format('d M Y, H:i') }}
                            </p>
                            <p class="mb-0 mt-1" style="font-size: 12px; color: #858796;">
                                <i class="mdi mdi-timer-outline mr-1"></i>
                                {{ $exam->duration }} menit
                            </p>
                        </td>

                        {{-- Status --}}
                        <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                            @if($isPast)
                                <span style="background: #f0f0f3; color: #858796; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 600;">
                                    <i class="mdi mdi-check-circle mr-1"></i>Selesai
                                </span>
                            @elseif($isActive)
                                <span style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 600;">
                                    <i class="mdi mdi-play-circle mr-1"></i>Berlangsung
                                </span>
                            @else
                                <span style="background: #fff3cd; color: #b8860b; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 600;">
                                    <i class="mdi mdi-clock-outline mr-1"></i>Mendatang
                                </span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                            <div class="d-flex align-items-center justify-content-center" style="gap: 6px;">

                                {{-- Lihat Hasil --}}
                                <a href="{{ route('exams.report', $exam->id) }}" title="Lihat Hasil"
                                   style="width: 32px; height: 32px; border-radius: 8px; background: #e0f7fa; color: #17a2b8; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s; font-size: 15px;"
                                   onmouseover="this.style.background='#17a2b8';this.style.color='#fff';"
                                   onmouseout="this.style.background='#e0f7fa';this.style.color='#17a2b8';">
                                    <i class="mdi mdi-eye-outline"></i>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('exams.edit', $exam->id) }}" title="Edit Ujian"
                                   style="width: 32px; height: 32px; border-radius: 8px; background: #e8f0fe; color: #4e73df; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s; font-size: 15px;"
                                   onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                   onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                    <i class="mdi mdi-pencil-outline"></i>
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('exams.destroy', $exam->id) }}" method="POST" style="display: inline; margin: 0;">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirmDelete(event, 'Ujian \'{{ addslashes($exam->title) }}\' akan dihapus permanen!')"
                                            title="Hapus Ujian"
                                            style="width: 32px; height: 32px; border-radius: 8px; background: #fde8e8; color: #e74a3b; border: none; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; font-size: 15px; padding: 0;"
                                            onmouseover="this.style.background='#e74a3b';this.style.color='#fff';"
                                            onmouseout="this.style.background='#fde8e8';this.style.color='#e74a3b';">
                                        <i class="mdi mdi-delete-outline"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        {{-- Empty State --}}
        <div class="text-center py-5">
            <div style="background: #f0f0f3; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <i class="mdi mdi-file-document-edit-outline" style="font-size: 40px; color: #c4c6d0;"></i>
            </div>
            <h5 class="font-weight-bold text-dark mb-1">Belum Ada Ujian</h5>
            <p class="text-muted mb-3" style="font-size: 13px;">Buat ujian pertama untuk mulai mengelola penilaian siswa.</p>
            <a href="{{ route('exams.create') }}" class="btn btn-primary" style="border-radius: 8px; font-size: 13px; font-weight: 600; padding: 8px 20px;">
                <i class="mdi mdi-plus mr-1"></i> Tambah Ujian
            </a>
        </div>
        @endif
    </div>

    {{-- Pagination --}}
    @if(method_exists($exams, 'links') && $exams->hasPages())
    <div class="card-body py-3 px-4 border-top d-flex justify-content-between align-items-center" style="background: #f8f9fc;">
        <small class="text-muted">Menampilkan {{ $exams->firstItem() }}–{{ $exams->lastItem() }} dari {{ $exams->total() }} ujian</small>
        {{ $exams->links() }}
    </div>
    @endif

</div>

@endsection