@extends('layouts.skydash')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))
                    <h3 class="font-weight-bold">Daftar Kelas</h3>
                    <p class="text-muted mb-0">Daftar dan kelola kelas yang ada</p>
                @endif
            </div>
            <div class="col-12 col-xl-4">
                <div class="justify-content-end d-flex">
                    <a href="{{ route('classrooms.create') }}" class="btn btn-primary btn btn-icon-text">
                        <i class="mdi mdi-plus"></i> Tambah Kelas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-md-12 grid-margin">
                <div class="card-body">
                    <div class="filter-card">
                        <form action="{{ route('classrooms.index') }}" method="GET" id="searchForm">
                            <div class="row align-items-end g-3">

                                <div class="col-md-10">
                                    <label class="filter-label" for="search">Cari Kelas</label>
                                    <div class="search-input-wrapper">
                                    <i class="mdi mdi-magnify search-icon"></i>
                                    <input type="text" class="form-control" name="search" id="search"
                                        placeholder="Ketik kata kunci..." value="{{ request('search') }}" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-sm btn-primary flex-grow-1">
                                            <i class="mdi mdi-magnify"></i> Cari
                                        </button>
                                        <a href="{{ route('classrooms.index') }}" class="btn-reset" title="Reset">
                                            <i class="mdi mdi-refresh"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>  
        </div>
    </div>

<div class="">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>Nama Kelas</th>
                                    <th>Wali Kelas</th>
                                    <th>Jumlah Siswa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($classrooms as $classroom)
                                <tr>
                                    <td>{{ $classroom->name }}</td>
                                    <td>{{ $classroom->instructor->name }}</td>
                                    <td>{{ $classroom->students_count }} Siswa</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('classrooms.edit', $classroom->id) }}" class="btn btn-primary btn-sm"><i class="mdi mdi-pencil"></i></a>
                                            <form action="{{ route('classrooms.destroy', $classroom->id) }}" method="POST" class="d-inline btn-sm">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kelas?')" style="border-radius: 0px 12px 12px 0px">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<style>
  .filter-card {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #ffffff;
    border-radius: 16px;
    padding: 20px 24px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06), 0 1px 3px rgba(0,0,0,0.04);
    border: 1px solid #f0f0f0;
  }
  .filter-label {
    font-size: 11px; font-weight: 600; letter-spacing: 0.6px;
    text-transform: uppercase; color: #9ca3af; margin-bottom: 6px; display: block;
  }
  .filter-card .form-control {
    font-size: 14px; font-weight: 500; color: #111827;
    background: #f9fafb; border: 1.5px solid #e5e7eb;
    border-radius: 10px; padding: 9px 14px; height: auto;
    transition: all 0.2s; box-shadow: none;
  }
  .filter-card .form-control:focus {
    background: #fff; border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
  }
  .search-input-wrapper { position: relative; }
  .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 17px; pointer-events: none; }
  .search-input-wrapper .form-control { padding-left: 38px; }
    select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239ca3af' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; cursor: pointer; }
  .btn-search { font-size: 13px; font-weight: 600; background: linear-gradient(135deg,#6366f1,#4f46e5); color: #fff; border: none; border-radius: 10px; padding: 9px 20px; display: flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(99,102,241,0.3); transition: all 0.2s; cursor: pointer; }
  .btn-search:hover { background: linear-gradient(135deg,#4f46e5,#4338ca); transform: translateY(-1px); box-shadow: 0 4px 14px rgba(99,102,241,0.4); color:#fff; }
  .btn-reset { font-size: 13px; font-weight: 600; background: #f3f4f6; color: #6b7280; border: 1.5px solid #e5e7eb; border-radius: 10px; padding: 9px 14px; display: flex; align-items: center; gap: 6px; transition: all 0.2s; cursor: pointer; text-decoration: none; }
  .btn-reset:hover { background: #e5e7eb; color: #374151; }

</style>
@endpush

@push('script')
   <script>
    $(document).ready(function() {
        let timeout = null;
        $('#search').on('keyup', function() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                if ($('#search').val().length >= 3 || $('#search').val().length == 0) {
                    $('#searchForm').submit();
                }
            }, 500); // Tunggu 0.5 detik setelah berhenti mengetik
        });
    });
</script> 
@endpush

@endsection
