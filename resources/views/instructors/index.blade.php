@extends('layouts.skydash')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-md-6  mb-4 mb-xl-0">
                @if(auth()->check() && auth()->user()->hasAnyRole(['admin']))
                    <h3 class="font-weight-bold">Manajemen Guru</h3>
                    <p class="text-muted mb-0">Daftar dan Kelola users role guru</p>    
                @endif
            </div>
            <div class="col-md-6 text-end mb-4 mb-xl-0">
                @if(auth()->check() && auth()->user()->hasAnyRole(['admin']))
                    <a href="{{ route('instructors.create') }}" class="btn btn-primary btn-icon-text">
                        <i class="ti-plus btn-icon-prepend"></i> Tambah Guru
                    </a>
                @endif
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
                        <p class="card-title">Daftar Guru</p>
                        
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
                                            <div class="btn-group">
                                                <a href="{{ route('instructors.edit', $instructor->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="mdi mdi-pencil"></i> Edit
                                                </a>
                                                <form action="{{ route('instructors.destroy', $instructor->id) }}" method="POST" class="d-inline"
                                                    onsubmit="event.preventDefault(); confirmDelete(event, 'Yakin ingin menghapus guru ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" style="border-radius:0px 12px 12px 0px">
                                                        <i class="mdi mdi-delete"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
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

@push('scripts')
<script>
function confirmDelete(event, message) {
    if (confirm(message)) {
        event.target.closest('form').submit();
    }
}

</script>
@endpush

@endsection

