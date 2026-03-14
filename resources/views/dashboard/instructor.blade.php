@extends('layouts.skydash')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
            <div class="card-body py-4 px-4">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-8 mb-2 mb-xl-0">
                        <div class="d-flex align-items-center" style="gap: 14px;">
                            <div style="background: rgba(255,255,255,0.2); border-radius: 50%; width: 52px; height: 52px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="mdi mdi-human-male-board text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Selamat Datang, {{ auth()->user()->name }}!</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Kelola mata pelajaran Anda dan lacak kemajuan siswa</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <div style="background: rgba(255,255,255,0.15); border-radius: 8px; padding: 8px 16px; text-align: right;">
                            <p class="text-white-50 mb-0" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Hari ini</p>
                            <p class="text-white mb-0 font-weight-bold" style="font-size: 13px;">{{ now()->translatedFormat('l, d F Y') }}</p>
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
        $istats = [
            ['label'=>'Total Siswa',        'value'=> number_format($totalStudents ?? 0),              'sub'=>'Aktif pembelajaran',                                         'icon'=>'mdi-account-school-outline',  'bg'=>'#e8f0fe','ic'=>'#4e73df'],
            ['label'=>'Mata Pelajaran',      'value'=> number_format($totalCourses ?? 0),               'sub'=> number_format($publishedCourses ?? 0).' dipublikasikan',       'icon'=>'mdi-library-outline',         'bg'=>'#e3f9e5','ic'=>'#1cc88a'],
            ['label'=>'Kehadiran Hari Ini',  'value'=> number_format($todayPresent ?? 0),              'sub'=>'dari '.number_format($todayTotal ?? 0).' total siswa',         'icon'=>'mdi-check-circle-outline',    'bg'=>'#e0f7fa','ic'=>'#17a2b8'],
            ['label'=>'Total Tugas',         'value'=> number_format($totalTasks ?? 0),                'sub'=> number_format($pendingTaskSubmissions ?? 0).' menunggu review', 'icon'=>'mdi-clipboard-check-outline', 'bg'=>'#fff3e8','ic'=>'#f6c23e'],
            ['label'=>'Total Kuis',          'value'=> number_format($totalQuizzes ?? 0),              'sub'=> number_format($totalQuizAttempts ?? 0).' dikerjakan',           'icon'=>'mdi-file-question-outline',   'bg'=>'#fde8e8','ic'=>'#e74a3b'],
            ['label'=>'Performa Tinggi',     'value'=> number_format($highPerformanceCourses ?? 0),    'sub'=>'Mata pelajaran',                                               'icon'=>'mdi-star-outline',            'bg'=>'#e3f9e5','ic'=>'#1cc88a'],
            ['label'=>'Performa Sedang',     'value'=> number_format($mediumPerformanceCourses ?? 0),  'sub'=>'Mata pelajaran',                                               'icon'=>'mdi-star-half-full',          'bg'=>'#fff3e8','ic'=>'#f6c23e'],
            ['label'=>'Perlu Perhatian',     'value'=> number_format($lowPerformanceCourses ?? 0),     'sub'=>'Mata pelajaran',                                               'icon'=>'mdi-alert-circle-outline',    'bg'=>'#fde8e8','ic'=>'#e74a3b'],
        ];
    @endphp
    @foreach($istats as $s)
    <div class="col-6 col-md-3 mb-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div style="flex: 1;">
                        <p class="text-muted mb-1" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">{{ $s['label'] }}</p>
                        <h3 class="font-weight-bold text-dark mb-0" style="font-size: 24px;">{{ $s['value'] }}</h3>
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

{{-- ===== CHARTS ROW 1 ===== --}}
<div class="row mb-4">
    <div class="col-md-8 mb-4 mb-md-0">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-trending-up" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Tren Peningkatan Pembelajaran Siswa</h5>
                        <small class="text-muted">Pola pembelajaran dan keterlibatan siswa</small>
                    </div>
                </div>
                <div style="position: relative; height: 280px;">
                    <canvas id="enrollmentTrendsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div style="background: #e3f9e5; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-chart-pie-outline" style="font-size: 18px; color: #1cc88a;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Performa Mata Pelajaran</h5>
                        <small class="text-muted">Berdasarkan tingkat penyelesaian</small>
                    </div>
                </div>
                <div style="position: relative; height: 180px;">
                    <canvas id="coursePerformanceChart"></canvas>
                </div>
                <div class="mt-3">
                    @foreach(['Performa Tinggi' => ['val' => $highPerformanceCourses ?? 0, 'c' => '#1cc88a', 'bg' => '#e3f9e5'], 'Performa Sedang' => ['val' => $mediumPerformanceCourses ?? 0, 'c' => '#f6c23e', 'bg' => '#fff3e8'], 'Perlu Perhatian' => ['val' => $lowPerformanceCourses ?? 0, 'c' => '#e74a3b', 'bg' => '#fde8e8']] as $lbl => $cfg)
                    <div class="d-flex justify-content-between align-items-center py-1" style="border-bottom: 1px solid #f0f0f3;">
                        <span class="text-muted" style="font-size: 12.5px;">{{ $lbl }}</span>
                        <span style="background: {{ $cfg['bg'] }}; color: {{ $cfg['c'] }}; border-radius: 6px; padding: 2px 9px; font-size: 12px; font-weight: 700;">{{ $cfg['val'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== CHARTS ROW 2 ===== --}}
<div class="row mb-4">
    <div class="col-md-6 mb-4 mb-md-0">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div style="background: #e0f7fa; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-account-check-outline" style="font-size: 18px; color: #17a2b8;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Absensi Siswa Mingguan</h5>
                        <small class="text-muted">Pola absensi siswa berdasarkan hari</small>
                    </div>
                </div>
                <div style="position: relative; height: 220px;">
                    <canvas id="studentActivityChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div style="background: #e3f9e5; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-check-all" style="font-size: 18px; color: #1cc88a;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Penyelesaian Mata Pelajaran</h5>
                        <small class="text-muted">Materi selesai vs belum selesai</small>
                    </div>
                </div>
                <div style="position: relative; height: 220px;">
                    <canvas id="lessonProgressChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== CHARTS ROW 3 ===== --}}
<div class="row mb-4">
    <div class="col-md-6 mb-4 mb-md-0">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-clipboard-check-outline" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Pengumpulan Tugas</h5>
                        <small class="text-muted">Jumlah siswa yang mengumpulkan per tugas</small>
                    </div>
                </div>
                <div style="position: relative; height: 220px;">
                    <canvas id="taskSubmissionChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div style="background: #fff3e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-file-question-outline" style="font-size: 18px; color: #f6c23e;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Pengerjaan Kuis</h5>
                        <small class="text-muted">Jumlah percobaan siswa per kuis</small>
                    </div>
                </div>
                <div style="position: relative; height: 220px;">
                    <canvas id="quizAttemptChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== RECENT COURSES TABLE ===== --}}
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-library-outline" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Mata Pelajaran Terbaru</h5>
                        <small class="text-muted">Pembaruan mata pelajaran Anda</small>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th style="padding: 12px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Mata Pelajaran</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Tingkat</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Modul</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Siswa</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Status</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentCourses ?? [] as $course)
                            <tr style="transition: background 0.15s;" onmouseover="this.style.background='#f8f9fc';" onmouseout="this.style.background='white';">
                                <td style="padding: 13px 20px; border-bottom: 1px solid #f0f0f3; font-size: 13.5px; font-weight: 600; color: #2d3748;">{{ $course->title ?? '—' }}</td>
                                <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3;">
                                    <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">{{ ucfirst($course->level ?? '—') }}</span>
                                </td>
                                <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3; text-align: center; font-size: 13px; font-weight: 600; color: #2d3748;">{{ $course->modules->count() ?? 0 }}</td>
                                <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3; text-align: center; font-size: 13px; font-weight: 600; color: #2d3748;">{{ $course->enrollments->count() ?? 0 }}</td>
                                <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3;">
                                    @if($course->is_published)
                                        <span style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;"><i class="mdi mdi-check-circle mr-1"></i>Dipublikasikan</span>
                                    @else
                                        <span style="background: #fff3e8; color: #f6c23e; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;"><i class="mdi mdi-pencil-outline mr-1"></i>Draf</span>
                                    @endif
                                </td>
                                <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3; font-size: 12.5px; color: #858796;">{{ $course->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="padding: 40px; text-align: center;">
                                    <i class="mdi mdi-library-outline" style="font-size: 36px; color: #d1d3e2;"></i>
                                    <p class="text-muted mt-2 mb-0" style="font-size: 13px;">Belum ada mata pelajaran. <a href="{{ route('courses.create') }}">Buat yang pertama</a></p>
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
    Chart.defaults.font.family = "'Segoe UI', system-ui, sans-serif";
    Chart.defaults.color = '#6c757d';

    const palette = ['#4e73df','#1cc88a','#17a2b8','#f6c23e','#e74a3b','#6610f2','#fd7e14','#20c9a6'];
    const tooltipCfg = { backgroundColor: 'rgba(0,0,0,0.82)', titleColor: '#fff', bodyColor: '#fff', cornerRadius: 8 };

    document.addEventListener('DOMContentLoaded', function() {

        // 1. Enrollment Trends
        const mData = @json($monthlyEnrollmentsData ?? array_fill(0, 12, 0));
        new Chart(document.getElementById('enrollmentTrendsChart'), {
            type: 'line',
            data: {
                labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
                datasets: [{
                    label: 'Siswa Aktif', data: mData,
                    borderColor: '#4e73df', backgroundColor: 'rgba(78,115,223,0.08)',
                    fill: true, tension: 0.4, pointBackgroundColor: '#4e73df',
                    pointBorderColor: '#fff', pointBorderWidth: 2, pointRadius: 5
                }]
            },
            options: { responsive: true, maintainAspectRatio: false,
                plugins: { legend: { position: 'top', labels: { usePointStyle: true, padding: 16 } }, tooltip: tooltipCfg },
                scales: { x: { grid: { display: false }, ticks: { color: '#6c757d' } }, y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { stepSize: 1 } } }
            }
        });

        // 2. Course Performance Doughnut
        new Chart(document.getElementById('coursePerformanceChart'), {
            type: 'doughnut',
            data: {
                labels: ['Performa Tinggi','Performa Sedang','Perlu Perhatian'],
                datasets: [{ data: [{{ $highPerformanceCourses ?? 0 }}, {{ $mediumPerformanceCourses ?? 0 }}, {{ $lowPerformanceCourses ?? 0 }}], backgroundColor: ['rgba(28,200,138,0.85)','rgba(246,194,62,0.85)','rgba(231,74,59,0.85)'], borderColor: ['#1cc88a','#f6c23e','#e74a3b'], borderWidth: 2, hoverOffset: 8 }]
            },
            options: { responsive: true, maintainAspectRatio: false, cutout: '62%', plugins: { legend: { display: false }, tooltip: tooltipCfg } }
        });

        // 3. Weekly Attendance
        const wAtt = @json($weeklyAttendanceChart ?? []);
        new Chart(document.getElementById('studentActivityChart'), {
            type: 'line',
            data: {
                labels: wAtt.map(d => d.day),
                datasets: [
                    { label: 'Hadir', data: wAtt.map(d => d.present), borderColor: '#1cc88a', backgroundColor: 'rgba(28,200,138,0.07)', fill: true, tension: 0.4, pointBackgroundColor: '#1cc88a', pointBorderColor: '#fff', pointBorderWidth: 2, pointRadius: 4 },
                    { label: 'Absen', data: wAtt.map(d => d.absent),  borderColor: '#e74a3b', backgroundColor: 'rgba(231,74,59,0.07)',   fill: true, tension: 0.4, pointBackgroundColor: '#e74a3b', pointBorderColor: '#fff', pointBorderWidth: 2, pointRadius: 4 },
                    { label: 'Sakit', data: wAtt.map(d => d.sick),    borderColor: '#f6c23e', backgroundColor: 'rgba(246,194,62,0.07)',  fill: true, tension: 0.4, pointBackgroundColor: '#f6c23e', pointBorderColor: '#fff', pointBorderWidth: 2, pointRadius: 4 }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false, interaction: { mode: 'index', intersect: false },
                plugins: { legend: { position: 'top', labels: { usePointStyle: true, padding: 12, font: { size: 11 } } }, tooltip: tooltipCfg },
                scales: { x: { grid: { display: false }, ticks: { color: '#6c757d', font: { size: 11 } } }, y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { stepSize: 1 } } }
            }
        });

        // 4. Lesson Progress stacked bar
        const lp = @json($lessonProgressChart ?? []);
        new Chart(document.getElementById('lessonProgressChart'), {
            type: 'bar',
            data: {
                labels: lp.map(d => d.label),
                datasets: [
                    { label: 'Selesai', data: lp.map(d => d.completed), backgroundColor: 'rgba(28,200,138,0.85)', borderRadius: 4 },
                    { label: 'Belum',   data: lp.map(d => d.incomplete), backgroundColor: 'rgba(78,115,223,0.2)',  borderRadius: 4 }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 12, font: { size: 11 } } }, tooltip: tooltipCfg },
                scales: { x: { stacked: true, grid: { display: false }, ticks: { color: '#6c757d', font: { size: 9 } } }, y: { stacked: true, beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });

        // 5. Task submissions
        const taskData = @json($taskSubmissionChart ?? []);
        new Chart(document.getElementById('taskSubmissionChart'), {
            type: 'bar',
            data: { labels: taskData.map(d => d.label), datasets: [{ label: 'Pengumpulan', data: taskData.map(d => d.count), backgroundColor: palette, borderRadius: 6 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false }, tooltip: tooltipCfg }, scales: { x: { grid: { display: false }, ticks: { color: '#6c757d', font: { size: 10 } } }, y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
        });

        // 6. Quiz attempts
        const quizData = @json($quizAttemptChart ?? []);
        new Chart(document.getElementById('quizAttemptChart'), {
            type: 'bar',
            data: { labels: quizData.map(d => d.label), datasets: [{ label: 'Percobaan', data: quizData.map(d => d.count), backgroundColor: palette, borderRadius: 6 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false }, tooltip: tooltipCfg }, scales: { x: { grid: { display: false }, ticks: { color: '#6c757d', font: { size: 10 } } }, y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
        });

    });
</script>
@endpush

@endsection