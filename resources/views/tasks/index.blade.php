@extends('layouts.skydash')

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
                                <i class="mdi mdi-clipboard-check-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))
                                    <h4 class="font-weight-bold text-white mb-0">Manajemen Tugas</h4>
                                    <p class="text-white-50 mb-0" style="font-size: 13px;">Kelola semua tugas untuk pelajaran Anda</p>
                                @else
                                    <h4 class="font-weight-bold text-white mb-0">Daftar Tugas</h4>
                                    <p class="text-white-50 mb-0" style="font-size: 13px;">Selesaikan tugas-tugas yang telah diberikan</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('tasks.create') }}"
                           class="btn font-weight-bold"
                           style="background: #fff; color: #4e73df; border-radius: 8px; font-size: 13px; border: none;">
                            <i class="mdi mdi-plus mr-1"></i> Tambah Tugas
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== STAT CARDS ===== --}}
<div class="row mb-4">
    @php
        $taskStats = [
            ['label' => 'Total Tugas',      'value' => $totalTasks,     'icon' => 'mdi-clipboard-check-outline', 'bg' => '#e8f0fe', 'ic' => '#4e73df'],
            ['label' => 'Tugas Terkumpul',  'value' => $totalSubmitted, 'icon' => 'mdi-send-check-outline',      'bg' => '#e0f7fa', 'ic' => '#17a2b8'],
            ['label' => 'Sudah Dinilai',    'value' => $totalGraded,    'icon' => 'mdi-check-circle-outline',    'bg' => '#e3f9e5', 'ic' => '#1cc88a'],
            ['label' => 'Menunggu Review',  'value' => $totalPending,   'icon' => 'mdi-clock-outline',           'bg' => '#fff3e8', 'ic' => '#f6c23e'],
        ];
    @endphp
    @foreach($taskStats as $s)
    <div class="col-6 col-md-3 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">{{ $s['label'] }}</p>
                        <h3 class="font-weight-bold text-dark mb-0" style="font-size: 26px;">{{ $s['value'] }}</h3>
                    </div>
                    <div style="background: {{ $s['bg'] }}; border-radius: 10px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="mdi {{ $s['icon'] }}" style="font-size: 22px; color: {{ $s['ic'] }};"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ===== TASK CARDS GRID ===== --}}
<div class="row">
    @forelse($tasks as $task)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card border-0 shadow-sm h-100"
             style="border-radius: 12px; border: 1px solid #eaecf4 !important; transition: all 0.22s ease;"
             onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 24px rgba(78,115,223,0.12)';"
             onmouseout="this.style.transform='';this.style.boxShadow='';">
            <div class="card-body p-4 d-flex flex-column">

                {{-- Top row: Lesson + Status badge --}}
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center" style="gap: 6px; flex: 1; min-width: 0;">
                        <i class="mdi mdi-book-open-outline text-muted" style="font-size: 14px; flex-shrink: 0;"></i>
                        <span class="text-muted" style="font-size: 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ optional($task->lesson)->title ?? 'Tanpa Materi' }}
                        </span>
                    </div>
                    <span style="flex-shrink: 0; margin-left: 8px;
                        background: {{ $task->status == 'published' ? '#e3f9e5' : '#fff3e8' }};
                        color: {{ $task->status == 'published' ? '#1cc88a' : '#f6c23e' }};
                        border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">
                        {{ $task->status == 'published' ? 'Dipublikasikan' : 'Draf' }}
                    </span>
                </div>

                {{-- Title --}}
                <h5 class="font-weight-bold text-dark mb-2" style="font-size: 14.5px; line-height: 1.4;">{{ $task->title }}</h5>

                {{-- Deadline --}}
                <div class="d-flex align-items-center mb-3" style="gap: 6px;">
                    @php
                        $overdue = $task->due_date && \Carbon\Carbon::parse($task->due_date)->isPast();
                    @endphp
                    <i class="mdi mdi-calendar-outline" style="font-size: 14px; color: {{ $overdue ? '#e74a3b' : '#adb5bd' }};"></i>
                    <span style="font-size: 12.5px; color: {{ $overdue ? '#e74a3b' : '#858796' }}; font-weight: {{ $overdue ? '600' : '400' }};">
                        Deadline: {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : 'Tidak ada' }}
                        @if($overdue) <span style="font-size: 10px;">(Terlambat)</span> @endif
                    </span>
                </div>

                {{-- Spacer --}}
                <div class="mt-auto">
                    <div class="d-flex" style="gap: 6px;">
                        <a href="{{ route('tasks.show', $task->id) }}"
                           class="btn flex-fill btn-sm"
                           style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 8px; font-size: 13px; font-weight: 600; padding: 8px; border: none;">
                            <i class="mdi mdi-eye mr-1"></i> Buka Tugas
                        </a>
                        @if(auth()->user()->hasAnyRole(['admin', 'instructor']))
                        <a href="{{ route('tasks.edit', $task->id) }}"
                           title="Edit"
                           style="background: #e8f0fe; color: #4e73df; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s; flex-shrink: 0;"
                           onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                           onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                            <i class="mdi mdi-pencil" style="font-size: 15px;"></i>
                        </a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline m-0"
                              onsubmit="confirmDelete(event, 'Tugas ini akan dihapus permanen.');">
                            @csrf @method('DELETE')
                            <button type="submit" title="Hapus"
                                    style="background: #fde8e8; color: #e74a3b; border: none; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; flex-shrink: 0;"
                                    onmouseover="this.style.background='#e74a3b';this.style.color='#fff';"
                                    onmouseout="this.style.background='#fde8e8';this.style.color='#e74a3b';">
                                <i class="mdi mdi-delete" style="font-size: 15px;"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body text-center py-5">
                <div style="background: #f0f0f3; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="mdi mdi-clipboard-text-outline" style="font-size: 40px; color: #c4c6d0;"></i>
                </div>
                <h5 class="font-weight-bold text-dark mb-1">Belum Ada Tugas</h5>
                <p class="text-muted mb-4" style="font-size: 14px;">Belum ada tugas yang tersedia untuk saat ini.</p>
                @if(auth()->user()->hasAnyRole(['admin', 'instructor']))
                <a href="{{ route('tasks.create') }}" class="btn btn-primary" style="border-radius: 8px; font-weight: 600; padding: 10px 24px;">
                    <i class="mdi mdi-plus mr-1"></i> Buat Tugas Pertama
                </a>
                @endif
            </div>
        </div>
    </div>
    @endforelse
</div>

@endsection