@extends('layouts.skydash')

@section('content')

{{-- ===== WELCOME HEADER ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
            <div class="card-body py-4 px-4">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-8 mb-3 mb-xl-0">
                        <div class="d-flex align-items-center" style="gap: 14px;">
                            <img src="{{ auth()->user()->avatar_url }}" alt="avatar"
                                 style="width: 56px; height: 56px; border-radius: 50%; object-fit: cover; border: 3px solid rgba(255,255,255,0.4); flex-shrink: 0;">
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Selamat datang, {{ auth()->user()->name }}!</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Lanjutkan perjalanan pembelajaran Anda bersama LMS SMKN 40</p>
                            </div>
                        </div>
                    </div>
                    {{-- Overall Progress --}}
                    <div class="col-12 col-xl-4">
                        <div style="background: rgba(255,255,255,0.15); border-radius: 10px; padding: 14px 16px;">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-white-50" style="font-size: 12px;">Progress Keseluruhan</span>
                                <span class="text-white font-weight-bold" style="font-size: 20px;">{{ $overallProgress ?? 0 }}%</span>
                            </div>
                            <div style="background: rgba(255,255,255,0.2); border-radius: 6px; height: 8px; overflow: hidden;">
                                <div style="height: 100%; width: {{ $overallProgress ?? 0 }}%; background: #fff; border-radius: 6px; transition: width 0.6s ease;"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-white-50">{{ $completedLessonsCount ?? 0 }} selesai</small>
                                <small class="text-white-50">{{ $totalLessons ?? 0 }} total materi</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== STAT CARDS ===== --}}
<div class="row mb-4">
    @php
        $sstats = [
            ['label'=>'Mata Pelajaran',    'value'=> $totalEnrolledCourses ?? 0, 'sub'=> ($activeCourses ?? 0).' aktif',                'icon'=>'mdi-library-outline',          'bg'=>'#e8f0fe','ic'=>'#4e73df'],
            ['label'=>'Materi Selesai',    'value'=> $completedLessonsCount ?? 0,'sub'=> ($inProgressLessons ?? 0).' sedang berjalan',  'icon'=>'mdi-book-check-outline',       'bg'=>'#e3f9e5','ic'=>'#1cc88a'],
            ['label'=>'Kuis Dikerjakan',   'value'=> $totalQuizAttempts ?? 0,    'sub'=> ($passedQuizzes ?? 0).' lulus',                'icon'=>'mdi-file-question-outline',    'bg'=>'#e0f7fa','ic'=>'#17a2b8'],
            ['label'=>'Tugas',             'value'=> $totalTasks ?? 0,           'sub'=>'Tugas tersedia',                               'icon'=>'mdi-clipboard-check-outline',  'bg'=>'#fff3e8','ic'=>'#f6c23e'],
        ];
    @endphp
    @foreach($sstats as $s)
    <div class="col-6 col-md-3 mb-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">{{ $s['label'] }}</p>
                        <h3 class="font-weight-bold text-dark mb-0" style="font-size: 26px;">{{ $s['value'] }}</h3>
                        <p class="text-muted mb-0" style="font-size: 11px; margin-top: 2px;">{{ $s['sub'] }}</p>
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

{{-- ===== CHARTS ===== --}}
<div class="row mb-4">
    <div class="col-lg-8 mb-4 mb-lg-0">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-chart-bar" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Perkembangan Mata Pelajaran</h5>
                        <small class="text-muted">Progress belajar per mata pelajaran</small>
                    </div>
                </div>
                <div style="position: relative; height: 260px;">
                    <canvas id="courseProgressChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div style="background: #e3f9e5; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-calendar-week" style="font-size: 18px; color: #1cc88a;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Aktivitas Mingguan</h5>
                        <small class="text-muted">Materi selesai 7 hari terakhir</small>
                    </div>
                </div>
                <div style="position: relative; height: 260px;">
                    <canvas id="weeklyProgressChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@if(isset($quizPerformance) && $quizPerformance->count() > 0)
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div style="background: #fff3e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-trending-up" style="font-size: 18px; color: #f6c23e;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Performa Kuis</h5>
                        <small class="text-muted">Perkembangan skor kuis dari waktu ke waktu</small>
                    </div>
                </div>
                <div style="position: relative; height: 220px;">
                    <canvas id="quizPerformanceChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ===== MATA PELAJARAN SAYA ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center justify-content-between px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div class="d-flex align-items-center">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-book-open-outline" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <h5 class="mb-0 font-weight-bold text-dark">Mata Pelajaran Saya</h5>
                    </div>
                    <a href="{{ route('courses.index') }}"
                       style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 5px 14px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s;"
                       onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                       onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                        Jelajahi Semua <i class="mdi mdi-arrow-right ml-1"></i>
                    </a>
                </div>

                @if(!empty($enrolledCourses) && count($enrolledCourses) > 0)
                <div class="p-4">
                    <div class="row">
                        @foreach($enrolledCourses as $course)
                        @php $cp = $courseProgress->firstWhere('course', $course->title); @endphp
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card border-0 h-100"
                                 style="border-radius: 10px; border: 1px solid #eaecf4 !important; overflow: hidden; cursor: pointer; transition: all 0.25s ease;"
                                 onclick="window.location.href='{{ $course->url }}'"
                                 onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 24px rgba(78,115,223,0.12)';"
                                 onmouseout="this.style.transform='';this.style.boxShadow='';">
                                {{-- Thumbnail --}}
                                <div style="height: 130px; background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;">
                                    @if($course->thumbnail)
                                        <img src="{{ asset('storage/'.$course->thumbnail) }}" alt="{{ $course->title }}"
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <span style="font-size: 48px; font-weight: 700; color: rgba(255,255,255,0.5);">
                                            {{ strtoupper(substr($course->title, 0, 1)) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="card-body p-3">
                                    <h6 class="font-weight-bold text-dark mb-1" style="font-size: 13.5px; line-height: 1.4;">{{ Str::limit($course->title, 40) }}</h6>
                                    <p class="text-muted mb-3" style="font-size: 12px; line-height: 1.4;">{{ Str::limit($course->description ?? '', 70) }}</p>
                                    @if($cp)
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small class="text-muted" style="font-size: 11px;">Progress</small>
                                            <small class="font-weight-bold" style="font-size: 11px; color: {{ $cp['progress'] >= 100 ? '#1cc88a' : ($cp['progress'] >= 50 ? '#4e73df' : '#f6c23e') }};">{{ $cp['progress'] }}%</small>
                                        </div>
                                        <div style="height: 5px; background: #e3e6f0; border-radius: 4px; overflow: hidden;">
                                            <div style="height: 100%; width: {{ $cp['progress'] }}%; border-radius: 4px; background: {{ $cp['progress'] >= 100 ? '#1cc88a' : ($cp['progress'] >= 50 ? '#4e73df' : '#f6c23e') }}; transition: width 0.4s;"></div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 3px 9px; font-size: 11px; font-weight: 600;">
                                            <i class="mdi mdi-folder-outline mr-1"></i>{{ $course->modules->count() ?? 0 }} Modul
                                        </span>
                                        <a href="{{ $course->url }}"
                                           class="btn btn-sm"
                                           style="background: #4e73df; color: #fff; border-radius: 6px; font-size: 12px; font-weight: 600; padding: 4px 12px; border: none;"
                                           onclick="event.stopPropagation();">
                                            Lanjutkan <i class="mdi mdi-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="text-center py-5">
                    <div style="background: #f0f0f3; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                        <i class="mdi mdi-book-open-outline" style="font-size: 40px; color: #c4c6d0;"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-1">Belum Ada Mata Pelajaran</h5>
                    <p class="text-muted mb-4" style="font-size: 14px;">Mulai belajar dengan mendaftar ke mata pelajaran!</p>
                    <a href="{{ route('courses.index') }}" class="btn btn-primary" style="border-radius: 8px; font-weight: 600; padding: 10px 24px;">
                        <i class="mdi mdi-magnify mr-1"></i> Jelajahi Mata Pelajaran
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ===== ACTIVITY ROWS ===== --}}
<div class="row mb-4">

    {{-- Recent Progress --}}
    <div class="col-lg-6 mb-4 mb-lg-0">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center justify-content-between px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div class="d-flex align-items-center">
                        <div style="background: #e3f9e5; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-clock-outline" style="font-size: 18px; color: #1cc88a;"></i>
                        </div>
                        <h5 class="mb-0 font-weight-bold text-dark">Materi Selesai</h5>
                    </div>
                    <span style="background: #f4f6fb; color: #858796; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">{{ $recentProgress->count() ?? 0 }} item</span>
                </div>
                <div class="p-3">
                    @forelse($recentProgress ?? [] as $progress)
                    <div class="d-flex align-items-start p-3 mb-2"
                         style="background: #f8f9fc; border-radius: 10px; border: 1px solid #eaecf4; transition: all 0.15s;"
                         onmouseover="this.style.transform='translateX(3px)';" onmouseout="this.style.transform='';">
                        <div style="background: {{ $progress->is_completed ? '#e3f9e5' : '#e8f0fe' }}; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-right: 12px;">
                            <i class="mdi {{ $progress->is_completed ? 'mdi-check' : 'mdi-clock-outline' }}" style="font-size: 17px; color: {{ $progress->is_completed ? '#1cc88a' : '#4e73df' }};"></i>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ Str::limit($progress->lesson->title ?? 'Lesson', 38) }}</p>
                            <small class="text-muted">{{ Str::limit($progress->lesson->module->course->title ?? '', 32) }}</small>
                            <small class="text-muted d-block">{{ $progress->updated_at->diffForHumans() }}</small>
                        </div>
                        <span style="background: {{ $progress->is_completed ? '#e3f9e5' : '#e8f0fe' }}; color: {{ $progress->is_completed ? '#1cc88a' : '#4e73df' }}; border-radius: 6px; padding: 3px 9px; font-size: 11px; font-weight: 600; flex-shrink: 0; margin-left: 8px;">
                            {{ $progress->is_completed ? 'Selesai' : 'Berjalan' }}
                        </span>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="mdi mdi-book-open-outline" style="font-size: 36px; color: #d1d3e2;"></i>
                        <p class="text-muted mt-2 mb-0" style="font-size: 13px;">Mulai pelajaran untuk melihat progres</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Quiz Results --}}
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center justify-content-between px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div class="d-flex align-items-center">
                        <div style="background: #fff3e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-help-circle-outline" style="font-size: 18px; color: #f6c23e;"></i>
                        </div>
                        <h5 class="mb-0 font-weight-bold text-dark">Hasil Kuis Terbaru</h5>
                    </div>
                    <span style="background: #f4f6fb; color: #858796; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">{{ $recentQuizAttempts->count() ?? 0 }} percobaan</span>
                </div>
                <div class="p-3">
                    @forelse($recentQuizAttempts ?? [] as $attempt)
                    @php $passed = $attempt->is_passed ?? false; @endphp
                    <div class="d-flex align-items-start p-3 mb-2"
                         style="background: #f8f9fc; border-radius: 10px; border: 1px solid #eaecf4; transition: all 0.15s;"
                         onmouseover="this.style.transform='translateX(3px)';" onmouseout="this.style.transform='';">
                        <div style="background: {{ $passed ? '#e3f9e5' : '#fde8e8' }}; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-right: 12px;">
                            <i class="mdi {{ $passed ? 'mdi-star' : 'mdi-close' }}" style="font-size: 17px; color: {{ $passed ? '#1cc88a' : '#e74a3b' }};"></i>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px;">{{ Str::limit($attempt->quiz->title ?? 'Quiz', 38) }}</p>
                            <div class="d-flex align-items-center" style="gap: 4px;">
                                <span style="font-size: 15px; font-weight: 700; color: #2d3748;">{{ $attempt->score ?? 0 }}</span>
                                <span class="text-muted" style="font-size: 12px;">/ {{ $attempt->total_points ?? '?' }}</span>
                                @if($attempt->total_points > 0)
                                <span style="font-size: 12px; color: {{ $passed ? '#1cc88a' : '#e74a3b' }}; font-weight: 600;">({{ round(($attempt->score / $attempt->total_points) * 100) }}%)</span>
                                @endif
                            </div>
                            <small class="text-muted">{{ $attempt->completed_at ? $attempt->completed_at->diffForHumans() : 'N/A' }}</small>
                        </div>
                        <span style="background: {{ $passed ? '#e3f9e5' : '#fde8e8' }}; color: {{ $passed ? '#1cc88a' : '#e74a3b' }}; border-radius: 6px; padding: 3px 9px; font-size: 11px; font-weight: 600; flex-shrink: 0; margin-left: 8px;">
                            {{ $passed ? 'Berhasil' : 'Gagal' }}
                        </span>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="mdi mdi-help-circle-outline" style="font-size: 36px; color: #d1d3e2;"></i>
                        <p class="text-muted mt-2 mb-0" style="font-size: 13px;">Belum ada hasil kuis</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== TUGAS BELUM DIKERJAKAN ===== --}}
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center justify-content-between px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div class="d-flex align-items-center">
                        <div style="background: #fde8e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-clipboard-text-outline" style="font-size: 18px; color: #e74a3b;"></i>
                        </div>
                        <h5 class="mb-0 font-weight-bold text-dark">Tugas Belum Dikerjakan</h5>
                    </div>
                    <span style="background: {{ ($pendingTasks ?? 0) > 0 ? '#fde8e8' : '#e3f9e5' }}; color: {{ ($pendingTasks ?? 0) > 0 ? '#e74a3b' : '#1cc88a' }}; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">{{ $pendingTasks ?? 0 }} item</span>
                </div>

                @forelse($pendingTaskList ?? [] as $task)
                <div class="px-4 py-3" style="border-bottom: 1px solid #f0f0f3; transition: background 0.15s;"
                     onmouseover="this.style.background='#f8f9fc';" onmouseout="this.style.background='white';">
                    <div class="d-flex align-items-center" style="gap: 12px;">
                        <div style="background: #fff3e8; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="mdi mdi-note-outline" style="font-size: 17px; color: #f6c23e;"></i>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <p class="mb-0 font-weight-bold text-dark" style="font-size: 13.5px;">{{ Str::limit($task->title, 50) }}</p>
                            <div class="d-flex align-items-center flex-wrap" style="gap: 8px; margin-top: 3px;">
                                <small class="text-muted"><i class="mdi mdi-book-outline mr-1"></i>{{ Str::limit($task->lesson->module->course->title ?? '', 30) }}</small>
                                @if($task->due_date)
                                <small style="color: {{ now()->gt($task->due_date) ? '#e74a3b' : '#858796' }};">
                                    <i class="mdi mdi-calendar-outline mr-1"></i>
                                    {{ now()->gt($task->due_date) ? 'Terlambat · ' : 'Deadline · ' }}
                                    {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                                </small>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('tasks.show', $task->slug) }}"
                           style="background: #e8f0fe; color: #4e73df; border-radius: 8px; padding: 7px 14px; font-size: 12.5px; font-weight: 600; text-decoration: none; white-space: nowrap; flex-shrink: 0; transition: all 0.2s;"
                           onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                           onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                            <i class="mdi mdi-arrow-right mr-1"></i> Kerjakan
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <div style="background: #e3f9e5; border-radius: 50%; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                        <i class="mdi mdi-check-all" style="font-size: 30px; color: #1cc88a;"></i>
                    </div>
                    <h6 class="font-weight-bold text-dark mb-1">Semua tugas selesai!</h6>
                    <p class="text-muted mb-0" style="font-size: 13px;">Tidak ada tugas yang menunggu dikerjakan</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    Chart.defaults.font.family = "'Segoe UI', system-ui, sans-serif";
    Chart.defaults.color = '#6c757d';

    const tooltipCfg = { backgroundColor: 'rgba(0,0,0,0.82)', titleColor: '#fff', bodyColor: '#fff', cornerRadius: 8 };

    document.addEventListener('DOMContentLoaded', function() {

        // 1. Course Progress bar
        const cpData = @json($courseProgress ?? []);
        new Chart(document.getElementById('courseProgressChart'), {
            type: 'bar',
            data: {
                labels: cpData.map(d => d.course.length > 18 ? d.course.substring(0,18)+'…' : d.course),
                datasets: [{ label: 'Progress (%)', data: cpData.map(d => d.progress), backgroundColor: 'rgba(78,115,223,0.85)', borderRadius: 6, borderSkipped: false }]
            },
            options: { responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { ...tooltipCfg, callbacks: { label: ctx => ctx.parsed.y + '%' } } },
                scales: { y: { beginAtZero: true, max: 100, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { callback: v => v+'%' } }, x: { grid: { display: false }, ticks: { color: '#6c757d', font: { size: 11 } } } }
            }
        });

        // 2. Weekly Progress line
        const wpData = @json($weeklyProgress ?? []);
        new Chart(document.getElementById('weeklyProgressChart'), {
            type: 'line',
            data: {
                labels: wpData.map(d => d.date),
                datasets: [{ label: 'Materi Selesai', data: wpData.map(d => d.completed), borderColor: '#1cc88a', backgroundColor: 'rgba(28,200,138,0.1)', fill: true, tension: 0.4, pointBackgroundColor: '#1cc88a', pointBorderColor: '#fff', pointBorderWidth: 2, pointRadius: 4 }]
            },
            options: { responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: tooltipCfg },
                scales: { y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { stepSize: 1 } }, x: { grid: { display: false }, ticks: { color: '#6c757d', font: { size: 10 } } } }
            }
        });

        // 3. Quiz Performance line (optional)
        const qpCtx = document.getElementById('quizPerformanceChart');
        if (qpCtx) {
            const qpData = @json($quizPerformance ?? []);
            if (qpData.length > 0) {
                new Chart(qpCtx, {
                    type: 'line',
                    data: {
                        labels: qpData.map(d => d.date),
                        datasets: [{ label: 'Skor Kuis (%)', data: qpData.map(d => d.score), borderColor: '#f6c23e', backgroundColor: 'rgba(246,194,62,0.1)', fill: true, tension: 0.4, pointBackgroundColor: '#f6c23e', pointBorderColor: '#fff', pointBorderWidth: 2, pointRadius: 5, pointHoverRadius: 7 }]
                    },
                    options: { responsive: true, maintainAspectRatio: false,
                        plugins: { legend: { display: true, position: 'top', labels: { usePointStyle: true, padding: 16 } }, tooltip: { ...tooltipCfg, callbacks: { label: ctx => ctx.parsed.y + '%' } } },
                        scales: { y: { beginAtZero: true, max: 100, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { callback: v => v+'%' } }, x: { grid: { display: false }, ticks: { color: '#6c757d', font: { size: 11 } } } }
                    }
                });
            }
        }

    });
</script>
@endpush

@endsection