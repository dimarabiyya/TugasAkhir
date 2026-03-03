@extends('layouts.skydash')
@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row align-items-center">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))
                    <h3 class="font-weight-bold">Daftar Konseling</h3>
                    <p class="text-muted mb-0">Kelola semua konseling untuk pelajaran Anda!</p>
                @else
                    <h3 class="font-weight-bold">Daftar Konseling Anda</h3>
                    <p class="text-muted mb-0">Daftar bimbingan konseling anda!</p>
                @endif
            </div>
            <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                @if(auth()->check() && auth()->user()->hasAnyRole(['student']))
                    <a href="{{ route('counseling.choose') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus me-1"></i> Konseling Baru
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Stats chips --}}
    <div class="row mb-4">
        <div class=col-md-4>
            <div class="card">
                <div class="card-body d-flex align-items-center gap-4">
                    <div class="icon-wrap"><i class="mdi mdi-chat-processing-outline"></i></div>
                    <div class="stat-num">{{ $sessions->count() }}</div>
                    <div class="stat-label">Total Sesi</div>
                </div>
            </div>
        </div>

        <div class=col-md-4>
            <div class="card">
                <div class="card-body d-flex align-items-center gap-4">
                    <div class="icon-wrap"><i class="mdi mdi-chat-processing-outline"></i></div>
                    <div class="stat-num">{{ $sessions->pluck('instructor_id')->unique()->count() }}</div>
                    <div class="stat-label">Konseling</div>
                </div>
            </div>
        </div>

        <div class=col-md-4>
            <div class="card">
                <div class="card-body d-flex align-items-center gap-4">
                    <div class="icon-wrap"><i class="mdi mdi-chat-processing-outline"></i></div>
                    <div class="stat-num">{{ $sessions->where('created_at', '>=', now()->startOfMonth())->count() }}</div>
                    <div class="stat-label">Konseling bulan ini</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Riwayat Konseling</h4>
                    <span class="badge bg-primary rounded-pill">{{ $sessions->count() }} Sesi</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">#</th>
                                <th class="border-0">Siswa</th>
                                <th class="border-0">Guru</th>
                                <th class="border-0 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sessions as $i => $session)
                            <tr>
                                <td class="text-muted" style="width:40px">{{ $i + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-initial rounded-circle bg-primary bg-opacity-10 text-primary fw-bold d-flex align-items-center justify-content-center" style="width:32px;height:32px;font-size:13px;flex-shrink:0">
                                            {{ strtoupper(substr($session->student->name, 0, 1)) }}
                                        </div>
                                        <span>{{ $session->student->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-initial rounded-circle bg-success bg-opacity-10 text-success fw-bold d-flex align-items-center justify-content-center" style="width:32px;height:32px;font-size:13px;flex-shrink:0">
                                            {{ strtoupper(substr($session->instructor->name, 0, 1)) }}
                                        </div>
                                        <span>{{ $session->instructor->name }}</span>
                                    </div>
                                </td>
                                <td class="text-center" style="width:160px">
                                    <a href="{{ route('counseling.show', $session->id) }}" class="btn btn-primary btn-sm">
                                        <i class="mdi mdi-forum-outline"></i> Chat
                                    </a>
                                    <form action="{{ route('counseling.destroy', $session->id) }}" method="POST" class="d-inline"
                                        onsubmit="event.preventDefault(); confirmDelete(event, 'Apakah Anda yakin ingin menghapus sesi konseling ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="ti-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <i class="mdi mdi-chat-sleep-outline d-block mb-2" style="font-size:36px;opacity:0.3"></i>
                                    Belum ada sesi konseling
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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