@extends('layouts.skydash')

@php use Illuminate\Support\Facades\Storage; @endphp

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
            <div class="card-body py-4 px-4">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-8">
                        <div class="d-flex align-items-center">
                            <div style="background: rgba(255,255,255,0.2); border-radius: 10px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; margin-right: 14px; flex-shrink: 0;">
                                @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))
                                    <i class="mdi mdi-chart-bar text-white" style="font-size: 26px;"></i>
                                @else
                                    <i class="mdi mdi-trending-up text-white" style="font-size: 26px;"></i>
                                @endif
                            </div>
                            <div>
                                @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))
                                    <h4 class="font-weight-bold text-white mb-0">Semua Progress Siswa</h4>
                                    <p class="text-white-50 mb-0" style="font-size: 14px;">Lihat dan kelola progress belajar seluruh siswa</p>
                                @else
                                    <h4 class="font-weight-bold text-white mb-0">Progress Saya</h4>
                                    <p class="text-white-50 mb-0" style="font-size: 14px;">Lacak kemajuan pembelajaran Anda</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== STATS CARDS ===== --}}
@php
    $total      = $enrollments->count();
    $selesai    = $enrollments->filter(fn($e) => $e->completed_at)->count();
    $belumSelesai = $total - $selesai;
    $avgProgress = $total > 0 ? round($enrollments->avg('progress_percentage')) : 0;
@endphp
<div class="row mb-4">
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body d-flex align-items-center p-3">
                <div style="background: #e8f0fe; border-radius: 10px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                    <i class="mdi mdi-account-multiple-outline" style="font-size: 22px; color: #4e73df;"></i>
                </div>
                <div>
                    <p class="mb-0 text-muted" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Total</p>
                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 22px;">{{ $total }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body d-flex align-items-center p-3">
                <div style="background: #e3f9e5; border-radius: 10px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                    <i class="mdi mdi-check-circle-outline" style="font-size: 22px; color: #1cc88a;"></i>
                </div>
                <div>
                    <p class="mb-0 text-muted" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Selesai</p>
                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 22px;">{{ $selesai }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body d-flex align-items-center p-3">
                <div style="background: #fff3cd; border-radius: 10px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                    <i class="mdi mdi-clock-outline" style="font-size: 22px; color: #f6c23e;"></i>
                </div>
                <div>
                    <p class="mb-0 text-muted" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Berlangsung</p>
                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 22px;">{{ $belumSelesai }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body d-flex align-items-center p-3">
                <div style="background: #fde8e8; border-radius: 10px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                    <i class="mdi mdi-trending-up" style="font-size: 22px; color: #e74a3b;"></i>
                </div>
                <div>
                    <p class="mb-0 text-muted" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Rata-rata</p>
                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 22px;">{{ $avgProgress }}<span style="font-size: 14px;">%</span></p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== TABLE ===== --}}
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-4">

                {{-- Card Header --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-table" style="font-size: 20px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Daftar Progress</h5>
                            <small class="text-muted">{{ $total }} data siswa</small>
                        </div>
                    </div>
                </div>

                @if($enrollments->count() > 0)
                <div class="table-responsive">
                    <table id="enrollmentsTable" class="table table-hover" style="border-collapse: separate; border-spacing: 0;">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th style="border: none; padding: 12px 16px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; font-weight: 700; border-radius: 8px 0 0 8px;">No</th>
                                <th style="border: none; padding: 12px 16px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; font-weight: 700;">Pengguna</th>
                                <th style="border: none; padding: 12px 16px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; font-weight: 700;">Mata Pelajaran</th>
                                <th style="border: none; padding: 12px 16px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; font-weight: 700; text-align: center;">Status</th>
                                <th style="border: none; padding: 12px 16px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; font-weight: 700; text-align: center;">Kemajuan</th>
                                <th style="border: none; padding: 12px 16px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; font-weight: 700; text-align: center; border-radius: 0 8px 8px 0;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enrollments as $index => $enroll)
                            @php $pct = $enroll->progress_percentage ?? 0; @endphp
                            <tr style="border-bottom: 1px solid #f0f0f3;">

                                {{-- No --}}
                                <td style="padding: 14px 16px; vertical-align: middle;">
                                    <div style="background: #f0f0f3; color: #858796; border-radius: 6px; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700;">
                                        {{ $index + 1 }}
                                    </div>
                                </td>

                                {{-- Pengguna --}}
                                <td style="padding: 14px 16px; vertical-align: middle;">
                                    <div class="d-flex align-items-center">
                                        <div style="background: linear-gradient(135deg, #4e73df, #224abe); border-radius: 50%; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                            <img src="{{ $enroll->user->avatar_url }}" 
                                                 alt="Avatar" 
                                                 class="table-avatar">
                                        </div>
                                        <span class="font-weight-bold text-dark" style="font-size: 14px;">{{ $enroll->user->name }}</span>
                                    </div>
                                </td>

                                {{-- Mata Pelajaran --}}
                                <td style="padding: 14px 16px; vertical-align: middle;">
                                    <div class="d-flex align-items-center">
                                        <div style="background: #e8f0fe; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; margin-right: 8px; flex-shrink: 0;">
                                            <i class="mdi mdi-book-open-outline" style="font-size: 16px; color: #4e73df;"></i>
                                        </div>
                                        <span style="font-size: 14px; color: #3d3d3d;">{{ $enroll->course->title }}</span>
                                    </div>
                                </td>

                                {{-- Status --}}
                                <td style="padding: 14px 16px; vertical-align: middle; text-align: center;">
                                    @if($enroll->completed_at)
                                        <span style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 4px 12px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap;">
                                            <i class="mdi mdi-check-circle" style="font-size: 13px;"></i> Selesai
                                        </span>
                                    @else
                                        <span style="background: #fff3cd; color: #b8860b; border-radius: 6px; padding: 4px 12px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap;">
                                            <i class="mdi mdi-clock-outline" style="font-size: 13px;"></i> Berlangsung
                                        </span>
                                    @endif
                                </td>

                                {{-- Kemajuan --}}
                                <td style="padding: 14px 16px; vertical-align: middle; text-align: center; min-width: 140px;">
                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                        <div style="flex: 1; background: #f0f0f3; border-radius: 10px; height: 8px; overflow: hidden;">
                                            <div style="height: 100%; width: {{ $pct }}%; border-radius: 10px; background: {{ $pct >= 100 ? '#1cc88a' : ($pct >= 50 ? '#4e73df' : '#f6c23e') }}; transition: width 0.4s ease;"></div>
                                        </div>
                                        <span style="font-size: 13px; font-weight: 700; color: {{ $pct >= 100 ? '#1cc88a' : ($pct >= 50 ? '#4e73df' : '#b8860b') }}; min-width: 36px; text-align: right;">{{ $pct }}%</span>
                                    </div>
                                </td>

                                {{-- Aksi --}}
                                <td style="padding: 14px 16px; vertical-align: middle; text-align: center;">
                                    <a href="{{ route('enrollments.show', $enroll) }}"
                                       title="Lihat Detail"
                                       style="background: #e8f0fe; color: #4e73df; border-radius: 8px; padding: 7px 14px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; transition: all 0.2s;"
                                       onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                       onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                        <i class="mdi mdi-eye-outline" style="font-size: 15px;"></i> Detail
                                    </a>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @else
                {{-- Empty State --}}
                <div class="text-center py-5">
                    <div style="background: #f0f0f3; border-radius: 50%; width: 100px; height: 100px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="mdi mdi-chart-bar" style="font-size: 52px; color: #c4c6d0;"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-1">Belum ada data kemajuan siswa</h5>
                    <p class="text-muted mb-0" style="font-size: 14px;">Belum ada siswa yang terdaftar di mata pelajaran manapun.</p>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<style>
    .table-hover tbody tr:hover {
        background-color: #f8f9fc !important;
        transition: background-color 0.15s ease;
    }

    .table thead th { border-bottom: none !important; }
    .table td { border-top: none !important; vertical-align: middle; }

    #enrollmentsTable_wrapper .dataTables_filter input {
        border-radius: 8px;
        padding: 8px 12px;
        border: 1px solid #d1d3e2;
        margin-left: 8px;
        font-size: 13px;
    }

    #enrollmentsTable_wrapper .dataTables_filter input:focus {
        border-color: #4e73df;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(78,115,223,0.15);
    }

    #enrollmentsTable_wrapper .dataTables_length select {
        border-radius: 8px;
        padding: 6px 10px;
        border: 1px solid #d1d3e2;
        margin: 0 4px;
        font-size: 13px;
    }

    #enrollmentsTable_wrapper .dataTables_info {
        font-size: 13px;
        color: #858796;
    }

    table.dataTable.dtr-inline.collapsed > tbody > tr > td:first-child:before,
    table.dataTable.dtr-inline.collapsed > tbody > tr > th:first-child:before {
        background-color: #4e73df;
        border: 2px solid white;
        box-shadow: 0 0 3px rgba(0,0,0,0.2);
        top: 50%;
        transform: translateY(-50%);
    }

    table.dataTable.dtr-inline.collapsed > tbody > tr.parent > td:first-child:before {
        background-color: #1cc88a;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
<script>
    (function ($) {
        'use strict';
        $(document).ready(function () {
            $.fn.dataTable.ext.errMode = 'none';

            $('#enrollmentsTable').DataTable({
                responsive: { details: { type: 'column', target: 'tr' } },
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Semua']],
                order: [[4, 'desc']],
                language: {
                    search: '_INPUT_',
                    searchPlaceholder: 'Cari pendaftaran...',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_–_END_ dari _TOTAL_ pendaftaran',
                    infoEmpty: 'Tidak ada data',
                    infoFiltered: '(dari _MAX_ total)',
                    paginate: { first: 'Pertama', last: 'Terakhir', next: '>', previous: '<' },
                    emptyTable: 'Tidak ada pendaftaran ditemukan'
                },
                columnDefs: [
                    { targets: -1, orderable: false, searchable: false, responsivePriority: 1 },
                    { targets: 0, responsivePriority: 10000 }
                ],
                autoWidth: false
            });

            // Style DataTables controls
            var search_input = $('#enrollmentsTable').closest('.dataTables_wrapper').find('div[id$=_filter] input');
            search_input.attr('placeholder', 'Cari pendaftaran...');
            search_input.removeClass('form-control-sm');
        });
    })(jQuery);
</script>
@endpush

@endsection