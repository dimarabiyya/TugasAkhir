@extends('layouts.skydash')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
            <div class="card-body py-4 px-4">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-8 mb-3 mb-xl-0">
                        <div class="d-flex align-items-center">
                            <div style="background: rgba(255,255,255,0.2); border-radius: 10px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; margin-right: 14px; flex-shrink: 0;">
                                <i class="mdi mdi-chat-processing-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))
                                    <h4 class="font-weight-bold text-white mb-0">Daftar Konseling</h4>
                                    <p class="text-white-50 mb-0" style="font-size: 13px;">Kelola semua sesi konseling siswa</p>
                                @else
                                    <h4 class="font-weight-bold text-white mb-0">Konseling Saya</h4>
                                    <p class="text-white-50 mb-0" style="font-size: 13px;">Daftar bimbingan konseling kamu</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        @if(auth()->check() && auth()->user()->hasRole('student'))
                            <a href="{{ route('counseling.choose') }}" class="btn btn-light font-weight-bold" style="border-radius: 8px; font-size: 13px; color: #4e73df;">
                                <i class="mdi mdi-plus mr-1"></i> Konseling Baru
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== STAT CARDS ===== --}}
<div class="row mb-4">
    @foreach([
        [
            'label' => 'Total Sesi',
            'value' => $sessions->count(),
            'icon'  => 'mdi-chat-outline',
            'bg'    => '#e8f0fe',
            'color' => '#4e73df',
        ],
        [
            'label' => auth()->user()->hasAnyRole(['admin','instructor']) ? 'Konselor Terlibat' : 'Konselor',
            'value' => $sessions->pluck('instructor_id')->unique()->count(),
            'icon'  => 'mdi-account-tie-outline',
            'bg'    => '#e3f9e5',
            'color' => '#1cc88a',
        ],
        [
            'label' => 'Bulan Ini',
            'value' => $sessions->where('created_at', '>=', now()->startOfMonth())->count(),
            'icon'  => 'mdi-calendar-month-outline',
            'bg'    => '#fff3cd',
            'color' => '#f6c23e',
        ],
    ] as $stat)
    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-3 d-flex align-items-center" style="gap: 14px;">
                <div style="background: {{ $stat['bg'] }}; border-radius: 10px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="mdi {{ $stat['icon'] }}" style="font-size: 24px; color: {{ $stat['color'] }};"></i>
                </div>
                <div>
                    <p class="mb-0 text-muted" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">{{ $stat['label'] }}</p>
                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 26px; line-height: 1.1;">{{ $stat['value'] }}</p>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ===== SESSION TABLE ===== --}}
<div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">

    {{-- Section header --}}
    <div class="card-body border-bottom py-3 px-4" style="background: #f8f9fc;">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                    <i class="mdi mdi-format-list-bulleted" style="font-size: 18px; color: #4e73df;"></i>
                </div>
                <div>
                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">Riwayat Konseling</p>
                    <small class="text-muted">{{ $sessions->count() }} sesi tercatat</small>
                </div>
            </div>
            <span style="background: #e8f0fe; color: #4e73df; border-radius: 20px; padding: 4px 12px; font-size: 12px; font-weight: 600;">
                {{ $sessions->count() }} Sesi
            </span>
        </div>
    </div>

    {{-- Table --}}
    <div class="card-body p-0">
        @if($sessions->count() > 0)
        <div class="table-responsive">
            <table class="table mb-0" style="border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr style="background: #f8f9fc;">
                        <th style="padding: 12px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; width: 40px;">#</th>
                        <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Siswa</th>
                        <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Konselor</th>
                        <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Dimulai</th>
                        <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sessions as $i => $session)
                    <tr style="transition: background 0.15s;"
                        onmouseover="this.style.background='#f8f9fc';"
                        onmouseout="this.style.background='white';">

                        {{-- No --}}
                        <td style="padding: 14px 20px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                            <span style="font-size: 12px; color: #adb5bd; font-weight: 600;">{{ $i + 1 }}</span>
                        </td>

                        {{-- Siswa --}}
                        <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                            <div class="d-flex align-items-center" style="gap: 10px;">
                                <div style="background: linear-gradient(135deg, #4e73df, #224abe); border-radius: 50%; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <img src="{{ $session->student->avatar_url }}">
                                </div>
                                <div>
                                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px;">{{ $session->student->name }}</p>
                                    <p class="mb-0 text-muted" style="font-size: 11px;">{{ $session->student->email ?? '' }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Konselor --}}
                        <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                            <div class="d-flex align-items-center" style="gap: 10px;">
                                <div style="background: linear-gradient(135deg, #1cc88a, #17a673); border-radius: 50%; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <img src=" {{ $session->instructor->avatar_url }} " />
                                </div>
                                <div>
                                    <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px;">{{ $session->instructor->name }}</p>
                                    <p class="mb-0 text-muted" style="font-size: 11px;">{{ $session->instructor->email ?? '' }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Tanggal --}}
                        <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                            <p class="mb-0" style="font-size: 12px; color: #3d3d3d;">
                                <i class="mdi mdi-calendar-outline mr-1" style="color: #4e73df;"></i>
                                {{ $session->created_at->format('d M Y') }}
                            </p>
                            <p class="mb-0" style="font-size: 11px; color: #adb5bd;">
                                <i class="mdi mdi-clock-outline mr-1"></i>
                                {{ $session->created_at->format('H:i') }}
                            </p>
                        </td>

                        {{-- Aksi --}}
                        <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                            <div class="d-flex align-items-center justify-content-center" style="gap: 6px;">

                                {{-- Chat --}}
                                <a href="{{ route('counseling.show', $session->id) }}" title="Buka Chat"
                                   style="display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; border-radius: 8px; background: #e8f0fe; color: #4e73df; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s;"
                                   onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                   onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                    <i class="mdi mdi-forum-outline" style="font-size: 15px;"></i> Chat
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('counseling.destroy', $session->id) }}" method="POST" style="display: inline; margin: 0;">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirmDelete(event, 'Sesi konseling ini akan dihapus permanen!')"
                                            title="Hapus Sesi"
                                            style="width: 32px; height: 32px; border-radius: 8px; background: #fde8e8; color: #e74a3b; border: none; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; font-size: 15px; padding: 0;"
                                            onmouseover="this.style.background='#e74a3b';this.style.color='#fff';"
                                            onmouseout="this.style.background='#fde8e8';this.style.color='#e74a3b';">
                                        <i class="mdi mdi-delete-outline"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @else

        {{-- Empty state --}}
        <div class="text-center py-5">
            <div style="background: #f0f0f3; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <i class="mdi mdi-chat-sleep-outline" style="font-size: 40px; color: #c4c6d0;"></i>
            </div>
            <h5 class="font-weight-bold text-dark mb-1">Belum Ada Sesi Konseling</h5>
            @if(auth()->user()->hasRole('student'))
                <p class="text-muted mb-3" style="font-size: 13px;">Mulai sesi konseling baru dengan guru pilihanmu.</p>
                <a href="{{ route('counseling.choose') }}" class="btn btn-primary" style="border-radius: 8px; font-size: 13px; font-weight: 600; padding: 9px 20px;">
                    <i class="mdi mdi-plus mr-1"></i> Mulai Konseling
                </a>
            @else
                <p class="text-muted mb-0" style="font-size: 13px;">Belum ada siswa yang memulai sesi konseling.</p>
            @endif
        </div>

        @endif
    </div>

    {{-- Pagination --}}
    @if(method_exists($sessions, 'links') && $sessions->hasPages())
    <div class="card-body py-3 px-4 border-top d-flex justify-content-between align-items-center" style="background: #f8f9fc;">
        <small class="text-muted">Menampilkan {{ $sessions->firstItem() }}–{{ $sessions->lastItem() }} dari {{ $sessions->total() }} sesi</small>
        {{ $sessions->links() }}
    </div>
    @endif

</div>

@endsection