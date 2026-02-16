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
                    @if(!auth()->check() || !auth()->user()->hasAnyRole(['admin', 'instructor']))
                        <a href="{{ route('courses.index') }}" class="btn btn-primary">
                            <i class="icon-plus"></i> Browse Courses
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="card-title">Daftar Kelas</p>
                        <a href="{{ route('classrooms.create') }}" class="btn btn-primary btn-sm btn-icon-text">
                            <i class="ti-plus btn-icon-prepend"></i> Tambah Kelas
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>Nama Kelas</th>
                                    <th>Instruktur</th>
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
                                        <a href="{{ route('classrooms.edit', $classroom->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('classrooms.destroy', $classroom->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kelas?')">Hapus</button>
                                        </form>
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
@endsection
