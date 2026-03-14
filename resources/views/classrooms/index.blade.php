@extends('layouts.skydash')

@php use Illuminate\Support\Facades\Storage; @endphp

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
                                <i class="mdi mdi-google-classroom text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Daftar Kelas</h4>
                                <p class="text-white-50 mb-0" style="font-size: 14px;">Daftar dan kelola semua kelas yang tersedia</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))
                        <a href="{{ route('classrooms.create') }}" class="btn font-weight-bold"
                           style="background: #fff; color: #4e73df; border-radius: 8px; font-size: 13px; border: none; white-space: nowrap;">
                            <i class="mdi mdi-plus mr-1"></i> Tambah Kelas
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== SEARCH / FILTER ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-4">
                <form action="{{ route('classrooms.index') }}" method="GET" id="searchForm">
                    <div class="row align-items-end" style="gap: 0;">
                        <div class="col-md-10 mb-3 mb-md-0">
                            <label class="text-dark font-weight-600 mb-1" style="font-size: 13px;">
                                <i class="mdi mdi-magnify mr-1 text-muted"></i> Cari Kelas
                            </label>
                            <div style="position: relative;">
                                <i class="mdi mdi-magnify" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #adb5bd; font-size: 18px; pointer-events: none;"></i>
                                <input type="text"
                                       class="form-control"
                                       name="search"
                                       id="search"
                                       placeholder="Ketik nama kelas untuk mencari..."
                                       value="{{ request('search') }}"
                                       autocomplete="off"
                                       style="border-radius: 8px; padding: 10px 14px 10px 38px; font-size: 14px; border-color: #d1d3e2;">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex" style="gap: 8px;">
                                <button type="submit"
                                        class="btn btn-primary flex-grow-1"
                                        style="border-radius: 8px; font-size: 13px; font-weight: 600; padding: 10px 0;">
                                    <i class="mdi mdi-magnify mr-1"></i> Cari
                                </button>
                                <a href="{{ route('classrooms.index') }}"
                                   title="Reset pencarian"
                                   style="background: #f0f0f3; color: #858796; border-radius: 8px; width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; text-decoration: none; flex-shrink: 0; transition: all 0.2s;"
                                   onmouseover="this.style.background='#e3e6f0';this.style.color='#5a5c69';"
                                   onmouseout="this.style.background='#f0f0f3';this.style.color='#858796';">
                                    <i class="mdi mdi-refresh" style="font-size: 18px;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
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
                            <h5 class="mb-0 font-weight-bold text-dark">Semua Kelas</h5>
                            <small class="text-muted">{{ $classrooms->count() }} kelas ditemukan</small>
                        </div>
                    </div>
                </div>

                @if($classrooms->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" style="border-collapse: separate; border-spacing: 0;">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th style="border: none; padding: 12px 16px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; font-weight: 700; border-radius: 8px 0 0 8px;">#</th>
                                <th style="border: none; padding: 12px 16px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; font-weight: 700;">Nama Kelas</th>
                                <th style="border: none; padding: 12px 16px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; font-weight: 700;">Wali Kelas</th>
                                <th style="border: none; padding: 12px 16px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; font-weight: 700; text-align: center;">Jumlah Siswa</th>
                                <th style="border: none; padding: 12px 16px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; font-weight: 700; text-align: center; border-radius: 0 8px 8px 0;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classrooms as $index => $classroom)
                            <tr style="border-bottom: 1px solid #f0f0f3;">

                                {{-- No --}}
                                <td style="padding: 14px 20px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; width:5vh">
                                    <div style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 2px 9px;  font-weight: 700; ">
                                        <p style="font-weight: 700; font-size: 12px; margin:1px">{{ $loop->iteration }}</p>
                                    </div>
                                </td>

                                {{-- Nama Kelas --}}
                                <td style="padding: 14px 16px; vertical-align: middle;">
                                    <div class="d-flex align-items-center">
                                        <div style="background: #e8f0fe; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                            <i class="mdi mdi-google-classroom" style="font-size: 18px; color: #4e73df;"></i>
                                        </div>
                                        <span class="font-weight-bold text-dark" style="font-size: 14px;">{{ $classroom->name }}</span>
                                    </div>
                                </td>

                                {{-- Wali Kelas --}}
                                <td style="padding: 14px 16px; vertical-align: middle;">
                                    <div class="d-flex align-items-center">
                                        @if($classroom->instructor->avatar)
                                            <img src="{{ $classroom->instructor->avatar_url }}" 
                                                alt="{{ $classroom->instructor->name }}" 
                                                style="border-radius: 50%; width: 32px; height: 32px; object-fit: cover; margin-right: 8px; flex-shrink: 0;">
                                        @else
                                            <div style="background: #e3f9e5; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; margin-right: 8px; flex-shrink: 0;">
                                                <i class="mdi mdi-account-tie" style="font-size: 16px; color: #1cc88a;"></i>
                                            </div>
                                        @endif
                                        <span style="font-size: 14px; color: #3d3d3d;">{{ $classroom->instructor->name }}</span>
                                    </div>
                                </td>

                                {{-- Jumlah Siswa --}}
                                <td style="padding: 14px 16px; vertical-align: middle; text-align: center;">
                                    <div style="display: inline-flex; align-items: center; background: #fff3cd; border-radius: 6px; padding: 4px 12px; gap: 5px;">
                                        <i class="mdi mdi-account-multiple" style="color: #f6c23e; font-size: 15px;"></i>
                                        <span style="color: #b8860b; font-weight: 700; font-size: 14px;">{{ $classroom->students_count }}</span>
                                        <span style="color: #b8860b; font-size: 13px;">Siswa</span>
                                    </div>
                                </td>

                                {{-- Aksi --}}
                                <td style="padding: 14px 16px; vertical-align: middle; text-align: center;">
                                    <div class="d-flex justify-content-center" style="gap: 6px;">
                                        <a href="{{ route('classrooms.edit', $classroom->id) }}"
                                           title="Edit Kelas"
                                           style="background: #e8f0fe; color: #4e73df; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;"
                                           onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                           onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                            <i class="mdi mdi-pencil-outline" style="font-size: 16px;"></i>
                                        </a>
                                        <form action="{{ route('classrooms.destroy', $classroom->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas {{ $classroom->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    title="Hapus Kelas"
                                                    style="background: #fde8e8; color: #e74a3b; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.2s;"
                                                    onmouseover="this.style.background='#e74a3b';this.style.color='#fff';"
                                                    onmouseout="this.style.background='#fde8e8';this.style.color='#e74a3b';">
                                                <i class="mdi mdi-delete-outline" style="font-size: 16px;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($classrooms instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="d-flex justify-content-end mt-3">
                    {{ $classrooms->withQueryString()->links() }}
                </div>
                @endif

                @else
                {{-- Empty State --}}
                <div class="text-center py-5">
                    <div style="background: #f0f0f3; border-radius: 50%; width: 100px; height: 100px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="mdi mdi-google-classroom" style="font-size: 52px; color: #c4c6d0;"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-1">Belum ada kelas</h5>
                    <p class="text-muted mb-4" style="font-size: 14px;">
                        @if(request('search'))
                            Tidak ditemukan kelas dengan kata kunci <strong>"{{ request('search') }}"</strong>.
                        @else
                            Belum ada kelas yang dibuat. Mulai dengan menambahkan kelas baru.
                        @endif
                    </p>
                    @if(request('search'))
                        <a href="{{ route('classrooms.index') }}" class="btn btn-outline-secondary mr-2" style="border-radius: 8px; font-weight: 600;">
                            <i class="mdi mdi-refresh mr-1"></i> Reset Pencarian
                        </a>
                    @endif
                    @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))
                    <a href="{{ route('classrooms.create') }}" class="btn btn-primary" class="btn font-weight-bold"
                        style="background: #fff; color: #4e73df; border-radius: 8px; font-size: 13px; border: none; white-space: nowrap;">
                        <i class="mdi mdi-plus mr-1"></i> Tambah Kelas
                    </a>
                    @endif
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .table-hover tbody tr:hover {
        background-color: #f8f9fc !important;
        transition: background-color 0.15s ease;
    }

    .table thead th {
        border-bottom: none !important;
    }

    .table td {
        border-top: none !important;
    }

    .form-control:focus {
        border-color: #4e73df !important;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15) !important;
    }

    .card {
        transition: box-shadow 0.2s ease;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        let timeout = null;
        $('#search').on('keyup', function () {
            clearTimeout(timeout);
            timeout = setTimeout(function () {
                const val = $('#search').val();
                if (val.length >= 3 || val.length === 0) {
                    $('#searchForm').submit();
                }
            }, 500);
        });
    });
</script>
@endpush

@endsection