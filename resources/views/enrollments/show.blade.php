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
                                <i class="mdi mdi-book-open-variant text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">{{ $enrollment->course->title }}</h4>
                                @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']) && isset($enrollment->user))
                                    <p class="text-white-50 mb-0" style="font-size: 14px;">
                                        <i class="mdi mdi-account-outline mr-1"></i> Siswa: <strong class="text-white">{{ $enrollment->user->name }}</strong>
                                    </p>
                                @else
                                    <p class="text-white-50 mb-0" style="font-size: 14px;">{{ Str::limit($enrollment->course->description, 80) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('enrollments.index') }}" class="btn btn-light font-weight-bold" style="border-radius: 8px; font-size: 13px;">
                            <i class="mdi mdi-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    {{-- ===== LEFT: Course Content ===== --}}
    <div class="col-md-8 mb-4">

        {{-- Progress Card --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-trending-up" style="font-size: 20px; color: #4e73df;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Kemajuan Keseluruhan</h5>
                        <small class="text-muted">Progress belajar saat ini</small>
                    </div>
                    <div class="ml-auto">
                        @php $pct = $enrollment->progress_percentage ?? 0; @endphp
                        <span style="font-size: 22px; font-weight: 700; color: {{ $pct >= 100 ? '#1cc88a' : ($pct >= 50 ? '#4e73df' : '#f6c23e') }};">{{ $pct }}%</span>
                    </div>
                </div>
                <div style="background: #f0f0f3; border-radius: 10px; height: 12px; overflow: hidden;">
                    <div style="height: 100%; width: {{ $pct }}%; border-radius: 10px; background: {{ $pct >= 100 ? 'linear-gradient(90deg,#1cc88a,#17a673)' : ($pct >= 50 ? 'linear-gradient(90deg,#4e73df,#224abe)' : 'linear-gradient(90deg,#f6c23e,#e0a800)') }}; transition: width 0.6s ease;"></div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <small class="text-muted">0%</small>
                    <small class="text-muted">{{ $pct }}% selesai</small>
                    <small class="text-muted">100%</small>
                </div>
            </div>
        </div>

        {{-- Modules List --}}
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-view-list-outline" style="font-size: 20px; color: #4e73df;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Konten Mata Pelajaran</h5>
                        <small class="text-muted">{{ $enrollment->course->modules->count() }} modul tersedia</small>
                    </div>
                </div>

                @forelse($enrollment->course->modules as $module)
                @php $totalLessons = $enrollment->course->modules->sum(fn($m) => $m->lessons->count()); @endphp
                <div class="mb-3" style="border: 1px solid #e3e6f0; border-radius: 10px; overflow: hidden; transition: box-shadow 0.2s ease;"
                     onmouseover="this.style.boxShadow='0 4px 12px rgba(78,115,223,0.1)';"
                     onmouseout="this.style.boxShadow='';">

                    {{-- Module Header --}}
                    <div class="d-flex align-items-center justify-content-between p-3" style="background: #f8f9fc; border-bottom: 1px solid #e3e6f0;">
                        <div class="d-flex align-items-center">
                            <div style="background: #4e73df; color: white; border-radius: 8px; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; margin-right: 10px; flex-shrink: 0;">
                                {{ $module->order }}
                            </div>
                            <div>
                                <p class="mb-0 font-weight-bold text-dark" style="font-size: 14px;">{{ $module->title }}</p>
                                <small class="text-muted"><i class="mdi mdi-play-circle-outline mr-1"></i>{{ $module->lessons->count() }} pelajaran</small>
                            </div>
                        </div>
                        <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">
                            Modul {{ $module->order }}
                        </span>
                    </div>

                    {{-- Lessons --}}
                    @if($module->lessons->isNotEmpty())
                    <div class="accordion" id="lessons{{ $module->id }}">
                        @foreach($module->lessons as $lesson)
                        <div style="border-bottom: 1px solid #f0f0f3;">
                            {{-- Lesson Row (toggle) --}}
                            <div class="d-flex align-items-center px-3 py-2"
                                 style="cursor: pointer; transition: background 0.15s ease;"
                                 data-toggle="collapse"
                                 data-target="#collapse{{ $lesson->id }}"
                                 aria-expanded="false"
                                 onmouseover="this.style.background='#f8f9fc';"
                                 onmouseout="this.style.background='white';">
                                <div style="background: #e3f9e5; border-radius: 6px; width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                    <i class="mdi mdi-play-outline" style="font-size: 13px; color: #1cc88a;"></i>
                                </div>
                                <span style="font-size: 13px; color: #3d3d3d; flex: 1;">{{ $lesson->title }}</span>
                                @if($pct >= ($loop->iteration / max($totalLessons, 1) * 100))
                                    <span style="background: #e3f9e5; color: #1cc88a; border-radius: 50%; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; margin-left: 8px; flex-shrink: 0;">
                                        <i class="mdi mdi-check" style="font-size: 12px;"></i>
                                    </span>
                                @endif
                                <i class="mdi mdi-chevron-down text-muted ml-2" style="font-size: 16px;"></i>
                            </div>
                            {{-- Lesson Detail --}}
                            <div id="collapse{{ $lesson->id }}" class="collapse" data-parent="#lessons{{ $module->id }}">
                                <div class="px-4 py-3" style="background: #fdfdff; border-top: 1px solid #f0f0f3;">
                                    <p class="text-muted mb-2" style="font-size: 13px;">{{ $lesson->description ?? 'Tidak ada deskripsi.' }}</p>
                                    <div class="d-flex align-items-center" style="gap: 10px;">
                                        <span style="display: inline-flex; align-items: center; gap: 4px; font-size: 12px; color: #858796;">
                                            <i class="mdi mdi-clock-outline" style="font-size: 14px;"></i>
                                            {{ $lesson->duration_minutes ?? 'N/A' }} menit
                                        </span>
                                        @if($lesson->type)
                                        <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 2px 8px; font-size: 11px; font-weight: 600;">
                                            {{ ucfirst($lesson->type) }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @empty
                <div class="text-center py-4">
                    <div style="background: #f0f0f3; border-radius: 50%; width: 70px; height: 70px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                        <i class="mdi mdi-folder-open-outline" style="font-size: 36px; color: #c4c6d0;"></i>
                    </div>
                    <p class="text-muted mb-0" style="font-size: 14px;">Tidak ada modul yang tersedia.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ===== RIGHT: Sidebar ===== --}}
    <div class="col-md-4 mb-4">

        {{-- Progress Circle Card --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
            <div class="card-body p-4 text-center">
                <div style="background: rgba(255,255,255,0.15); border-radius: 50%; width: 90px; height: 90px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                    <div>
                        <p class="text-white mb-0 font-weight-bold" style="font-size: 26px; line-height: 1;">{{ $pct }}%</p>
                        <p class="text-white-50 mb-0" style="font-size: 11px;">Selesai</p>
                    </div>
                </div>
                @if($pct >= 100)
                    <span style="background: rgba(255,255,255,0.2); color: white; border-radius: 20px; padding: 4px 14px; font-size: 12px; font-weight: 600;">
                        <i class="mdi mdi-check-circle mr-1"></i> Mata Pelajaran Selesai!
                    </span>
                @else
                    <span style="background: rgba(255,255,255,0.2); color: white; border-radius: 20px; padding: 4px 14px; font-size: 12px; font-weight: 600;">
                        <i class="mdi mdi-clock-outline mr-1"></i> Sedang Berlangsung
                    </span>
                @endif
            </div>
        </div>

        {{-- Info Card --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-information-outline" style="font-size: 20px; color: #4e73df;"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">Informasi Siswa</h5>
                </div>

                {{-- Siswa (admin/instructor only) --}}
                @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']) && isset($enrollment->user))
                <div class="mb-3 p-3" style="background: #f8f9fc; border-radius: 10px;">
                    <p class="text-muted mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Siswa</p>
                    <div class="d-flex align-items-center mt-1">
                        <div style="background: linear-gradient(135deg, #4e73df, #224abe); border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; margin-right: 8px; flex-shrink: 0;">
                           <img src="{{ $enrollment->user->avatar_url }}" alt="Avatar" class="table-avatar" style="width: 32px; height: 32px; display: flex;">
                        </div>
                        <div>
                            <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px;">{{ $enrollment->user->name }}</p>
                            <p class="mb-0 text-muted" style="font-size: 12px;">{{ $enrollment->user->email }}</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Status --}}
                <div class="d-flex align-items-center justify-content-between mb-3 py-2" style="border-bottom: 1px solid #f0f0f3;">
                    <span class="text-muted" style="font-size: 13px;"><i class="mdi mdi-toggle-switch-outline mr-1"></i>Status</span>
                    @if($enrollment->completed_at)
                        <span style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 600;">
                            <i class="mdi mdi-check-circle mr-1"></i>Selesai
                        </span>
                    @elseif($pct > 0)
                        <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 600;">
                            <i class="mdi mdi-clock-outline mr-1"></i>Berlangsung
                        </span>
                    @else
                        <span style="background: #fff3cd; color: #b8860b; border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 600;">
                            <i class="mdi mdi-minus-circle-outline mr-1"></i>Belum Dimulai
                        </span>
                    @endif
                </div>

                {{-- Tanggal Pendaftaran --}}
                <div class="d-flex align-items-center justify-content-between mb-3 py-2" style="border-bottom: 1px solid #f0f0f3;">
                    <span class="text-muted" style="font-size: 13px;"><i class="mdi mdi-calendar-outline mr-1"></i>Didaftarkan</span>
                    <span class="font-weight-bold text-dark" style="font-size: 13px;">{{ $enrollment->enrolled_at->format('d M Y') }}</span>
                </div>

                {{-- Tanggal Selesai --}}
                @if($enrollment->completed_at)
                <div class="d-flex align-items-center justify-content-between mb-3 py-2" style="border-bottom: 1px solid #f0f0f3;">
                    <span class="text-muted" style="font-size: 13px;"><i class="mdi mdi-calendar-check-outline mr-1"></i>Diselesaikan</span>
                    <span class="font-weight-bold text-dark" style="font-size: 13px;">{{ $enrollment->completed_at->format('d M Y') }}</span>
                </div>
                @endif

                {{-- Level --}}
                <div class="d-flex align-items-center justify-content-between mb-3 py-2" style="border-bottom: 1px solid #f0f0f3;">
                    <span class="text-muted" style="font-size: 13px;"><i class="mdi mdi-signal-cellular-outline mr-1"></i>Level</span>
                    <span style="background: #e0f7fa; color: #17a2b8; border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 600;">
                        {{ ucfirst($enrollment->course->level) }}
                    </span>
                </div>

                {{-- Durasi --}}
                <div class="d-flex align-items-center justify-content-between py-2">
                    <span class="text-muted" style="font-size: 13px;"><i class="mdi mdi-clock-outline mr-1"></i>Durasi</span>
                    <span class="font-weight-bold text-dark" style="font-size: 13px;">{{ $enrollment->course->duration_hours }} jam</span>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-4">
                @if(!auth()->check() || !auth()->user()->hasAnyRole(['admin', 'instructor']))
                    @if(!$enrollment->completed_at && $pct < 100)
                    <form action="{{ route('enrollments.complete', $enrollment) }}" method="POST" class="mb-3"
                          onsubmit="return confirm('Tandai Mata Pelajaran ini sebagai selesai?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-block"
                                style="background: #e3f9e5; color: #1cc88a; border-radius: 8px; font-weight: 600; font-size: 14px; padding: 10px; border: none; transition: all 0.2s;"
                                onmouseover="this.style.background='#1cc88a';this.style.color='#fff';"
                                onmouseout="this.style.background='#e3f9e5';this.style.color='#1cc88a';">
                            <i class="mdi mdi-check-circle-outline mr-1"></i> Tandai sebagai Selesai
                        </button>
                    </form>
                    @endif
                    <a href="{{ $enrollment->course->url }}" class="btn btn-primary btn-block"
                       style="border-radius: 8px; font-weight: 600; font-size: 14px; padding: 10px;">
                        <i class="mdi mdi-play-circle-outline mr-1"></i> Lanjutkan Pembelajaran
                    </a>
                @else
                    <a href="{{ $enrollment->course->url }}" class="btn btn-primary btn-block"
                       style="border-radius: 8px; font-weight: 600; font-size: 14px; padding: 10px;">
                        <i class="mdi mdi-eye-outline mr-1"></i> Lihat Mata Pelajaran
                    </a>
                @endif
            </div>
        </div>

    </div>
</div>

@push('styles')
<style>
    .collapse.show + div,
    [data-toggle="collapse"][aria-expanded="true"] .mdi-chevron-down {
        transform: rotate(180deg);
    }

    .mdi-chevron-down {
        transition: transform 0.2s ease;
    }
</style>
@endpush

@endsection