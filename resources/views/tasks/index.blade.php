@extends('layouts.skydash')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))
                        <h3 class="font-weight-bold">Manajemen Tugas</h3>
                        <p class="text-muted">Kelola semua Tugas untuk pelajaran Anda!</p>
                    @else
                        <h3 class="font-weight-bold">Daftar Tugas yang Tersedia</h3>
                        <p class="text-muted">Selesaikan tugas tugas yang telah di berikan!</p>
                    @endif
                </div>
                <div class="col-12 col-xl-4">
                    @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))
                    <div class="justify-content-end d-flex">
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary btn">+ Tambah Tugas</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->

<div class="row mb-4">
    @php
       
    @endphp
    
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="mdi mdi-clipboard-check-outline" style="font-size: 40px; color: #667eea;"></i>
                <h3 class="mt-3 mb-0">{{ $totalTasks }}</h3>
                <p class="text-muted mb-0">Total Tugas</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="mdi mdi-calendar-check" style="font-size: 40px; color:  #06beb6;"></i>
                <h3 class="mt-3 mb-0">{{ $totalSubmitted }}</h3>
                <p class="text-muted mb-0">Tugas terkumpul</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="mdi mdi-check" style="font-size: 40px; color: #f5576c;"></i>
                <h3 class="mt-3 mb-0">{{ $totalGraded }}</h3>
                <p class="text-muted mb-0">Tugas selesai</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="mdi mdi-clock-outline" style="font-size: 40px; color: #4facfe;"></i>
                <h3 class="mt-3 mb-0">{{ $totalPending }}</h3>
                <p class="text-muted mb-0">Tugas menunggu</p>
            </div>
        </div>
    </div>
</div>

    <div class="row">
        {{-- Gunakan forelse untuk menangani jika data kosong --}}
        @forelse($tasks as $task)
        <div class="col-md-4 grid-margin">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        {{-- Gunakan optional agar tidak error jika relasi null --}}
                        <p class="text-muted small">{{ optional($task->lesson)->title }}</p>
                        <span class="badge {{ $task->status == 'published' ? 'badge-success' : 'badge-warning' }}">
                            {{ ucfirst($task->status) }}
                        </span>
                    </div>
                    <h4 class="card-title">{{ $task->title }}</h4>
                    <p class="text-small text-muted">
                        Deadline: {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : 'Tidak ada' }}
                    </p>
                    
                    
                        <div class="d-flex mt-2 gap-2 btn-group btn-group-sm">
                            <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-primary btn-sm flex-grow-1" title="Lihat"> <i class="pt-2 mdi mdi-eye"></i> Buka Tugas</a>
                            @if(auth()->user()->hasAnyRole(['admin', 'instructor']))
                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-light btn-sm flex-grow-1" title="Edit"><i class="pt-2 mdi mdi-pencil"></i> Edit</a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="btn-sm btn-danger" 
                                    onsubmit="event.preventDefault(); confirmDelete(event, 'Kamu yakin menghapus Tugas ini?');">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" style="border-radius:0px 12px 12px 0px;" title="Hapus">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-warning text-center">
                Belum ada tugas yang tersedia untuk saat ini.
            </div>
        </div>
        @endforelse
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

@push('style')
<style>
    .stats-card {
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
        height: 100%;
    }
    
    .stats-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
</style>
    
@endpush

@endsection