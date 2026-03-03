@extends('layouts.skydash')
@section('content')
<div class="row">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))
                        <h3 class="font-weight-bold">Daftar Konseling</h3>
                        <p class="text-muted">Kelola semua konseling untuk pelajaran Anda!</p>
                    @else
                        <h3 class="font-weight-bold">Daftar Konseling anda!</h3>
                        <p class="text-muted">Daftar bimbingan konseling anda!</p>
                    @endif
                </div>
                <div class="col-12 col-xl-4">
                    @if(auth()->check() && auth()->user()->hasAnyRole(['student']))
                    <div class="justify-content-end d-flex">
                        <a href="{{ route('counseling.choose') }}" class="btn btn-primary btn">Konseling</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Riwayat Konseling</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Guru</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sessions as $session)
                        <tr>
                            <td>{{ $session->student->name }}</td>
                            <td>{{ $session->instructor->name }}</td>
                            <td>
                                <a href="{{ route('counseling.show', $session->id) }}" class="btn btn-primary btn-sm">Buka Chat</a>
                                <form action="{{ route('counseling.destroy', $session->id) }}" method="POST" class="d-inline" 
                                    onsubmit="event.preventDefault(); confirmDelete(event, 'Apakah Anda yakin ingin menghapus sesi konseling ini?');">
                                    @csrf
                                    @method('DELETE') 
                                    <button type="submit" class="btn btn-danger btn-sm" id="d" >
                                        <i class="ti-trash"></i> Hapus
                                    </button>
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