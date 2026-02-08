@extends('layouts.skydash')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="card-title">Daftar Guru / Instructor</p>
                        <a href="{{ route('instructors.create') }}" class="btn btn-primary btn-icon-text">
                            <i class="ti-plus btn-icon-prepend"></i> Tambah Guru
                        </a>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Dibuat Pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($instructors as $instructor)
                                    <tr>
                                        <td>{{ $instructor->name }}</td>
                                        <td class="font-weight-bold">{{ $instructor->email }}</td>
                                        <td>{{ $instructor->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('instructors.edit', $instructor->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('instructors.destroy', $instructor->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus guru ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada data guru.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $instructors->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection