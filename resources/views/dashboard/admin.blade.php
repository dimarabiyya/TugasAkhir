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
                                <i class="mdi mdi-view-dashboard-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Dashboard Admin</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">
                                    Halo, <strong class="text-white">{{ auth()->user()->name }}</strong>! Pantau performa platform Anda.
                                </p>
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

{{-- ===== STAT CARDS ROW 1 ===== --}}
<div class="row mb-4">
    @php
        $stats1 = [
            ['label'=>'Total Siswa',       'value'=> number_format($totalStudents ?? 0),     'sub'=>'Aktif pembelajaran',                       'icon'=>'mdi-account-school-outline',       'bg'=>'#e8f0fe','ic'=>'#4e73df'],
            ['label'=>'Mata Pelajaran',     'value'=> number_format($totalCourses ?? 0),      'sub'=> number_format($publishedCourses ?? 0).' dipublikasikan', 'icon'=>'mdi-library-outline',  'bg'=>'#e3f9e5','ic'=>'#1cc88a'],
            ['label'=>'Total Modul',        'value'=> number_format($totalModules ?? 0),      'sub'=>'Di seluruh mata pelajaran',                 'icon'=>'mdi-folder-outline',               'bg'=>'#e0f7fa','ic'=>'#17a2b8'],
            ['label'=>'Total Kuis',         'value'=> number_format($totalQuizzes ?? 0),      'sub'=>'Tersedia',                                  'icon'=>'mdi-file-question-outline',        'bg'=>'#fde8e8','ic'=>'#e74a3b'],
            ['label'=>'Total Tugas',        'value'=> number_format($totalTasks ?? 0),        'sub'=> number_format($pendingTaskSubmissions ?? 0).' menunggu', 'icon'=>'mdi-clipboard-check-outline', 'bg'=>'#fff3e8','ic'=>'#f6c23e'],
            ['label'=>'Total Guru',         'value'=> number_format($totalInstructors ?? 0),  'sub'=>'Aktif mengajar',                            'icon'=>'mdi-human-male-board',             'bg'=>'#e8f0fe','ic'=>'#4e73df'],
            ['label'=>'Total Kelas',        'value'=> number_format($totalClassrooms ?? 0),   'sub'=>'Terdaftar di platform',                     'icon'=>'mdi-google-classroom',             'bg'=>'#e3f9e5','ic'=>'#1cc88a'],
            ['label'=>'Pengumpulan Tugas',  'value'=> number_format($totalTaskSubmissions ?? 0), 'sub'=>'Di seluruh mata pelajaran',              'icon'=>'mdi-send-check-outline',           'bg'=>'#e0f7fa','ic'=>'#17a2b8'],
        ];
    @endphp

    @foreach($stats1 as $s)
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

{{-- ===== ABSENSI HARI INI ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body px-4 py-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 10px;">
                    <div class="d-flex align-items-center" style="gap: 10px;">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="mdi mdi-clipboard-account-outline" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Absensi Platform Hari Ini</h5>
                            <small class="text-muted">{{ now()->translatedFormat('l, d F Y') }}</small>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap" style="gap: 8px;">
                        <span style="background: #e3f9e5; color: #1cc88a; border-radius: 20px; padding: 5px 14px; font-size: 12px; font-weight: 700;">
                            <i class="mdi mdi-check-circle mr-1"></i> Hadir: {{ $todayPresent ?? 0 }}
                        </span>
                        <span style="background: #fde8e8; color: #e74a3b; border-radius: 20px; padding: 5px 14px; font-size: 12px; font-weight: 700;">
                            <i class="mdi mdi-close-circle mr-1"></i> Absen: {{ $todayAbsent ?? 0 }}
                        </span>
                        <span style="background: #fff3e8; color: #f6c23e; border-radius: 20px; padding: 5px 14px; font-size: 12px; font-weight: 700;">
                            <i class="mdi mdi-emoticon-sick-outline mr-1"></i> Sakit: {{ $todaySick ?? 0 }}
                        </span>
                        <span style="background: #f4f6fb; color: #858796; border-radius: 20px; padding: 5px 14px; font-size: 12px; font-weight: 700;">
                            Total: {{ $todayTotal ?? 0 }} catatan
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== CHARTS ROW 1 ===== --}}
<div class="row mb-4">
    {{-- Enrollment Trends --}}
    <div class="col-md-8 mb-4 mb-md-0">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-trending-up" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Tren Perkembangan Siswa</h5>
                            <small class="text-muted">Pola pembelajaran dari waktu ke waktu</small>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm" data-bs-toggle="dropdown"
                                style="background: #f4f6fb; color: #6b7280; border-radius: 6px; font-size: 12px; border: 1px solid #e3e6f0;">
                            <i class="mdi mdi-calendar-outline mr-1"></i> 12 Bulan
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" style="border-radius: 10px; border: none; box-shadow: 0 8px 24px rgba(0,0,0,0.1); font-size: 13px;">
                            <a class="dropdown-item" href="#" onclick="updateEnrollmentChart('6months')">6 Bulan Terakhir</a>
                            <a class="dropdown-item" href="#" onclick="updateEnrollmentChart('12months')">12 Bulan Terakhir</a>
                        </div>
                    </div>
                </div>
                <div style="position: relative; height: 280px;">
                    <canvas id="enrollmentTrendsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Course Level Distribution --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div style="background: #e3f9e5; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-chart-pie-outline" style="font-size: 18px; color: #1cc88a;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Distribusi Mata Pelajaran</h5>
                        <small class="text-muted">Berdasarkan tingkat kesulitan</small>
                    </div>
                </div>
                <div style="position: relative; height: 180px;">
                    <canvas id="courseLevelChart"></canvas>
                </div>
                <div class="mt-3">
                    @foreach(['Pemula' => $coursesByLevel['beginner'] ?? $coursesByLevel['Beginner'] ?? 0, 'Menengah' => $coursesByLevel['intermediate'] ?? $coursesByLevel['Intermediate'] ?? 0, 'Lanjutan' => $coursesByLevel['advanced'] ?? $coursesByLevel['Advanced'] ?? 0] as $lbl => $val)
                    <div class="d-flex justify-content-between align-items-center py-1" style="border-bottom: 1px solid #f0f0f3;">
                        <span class="text-muted" style="font-size: 12.5px;">{{ $lbl }}</span>
                        <span class="font-weight-bold text-dark" style="font-size: 13px;">{{ $val }}</span>
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
                        <h5 class="mb-0 font-weight-bold text-dark">Kehadiran Siswa Mingguan</h5>
                        <small class="text-muted">Pola kehadiran 7 hari terakhir</small>
                    </div>
                </div>
                <div style="position: relative; height: 220px;">
                    <canvas id="activityHeatmapChart"></canvas>
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
                    <canvas id="completionRatesChart"></canvas>
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
                        <i class="mdi mdi-chart-bar" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Aktivitas Tugas & Kuis</h5>
                        <small class="text-muted">Pengumpulan tugas vs percobaan kuis per bulan</small>
                    </div>
                </div>
                <div style="position: relative; height: 220px;">
                    <canvas id="adminTaskQuizChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div style="background: #fff3e8; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-fire" style="font-size: 18px; color: #f6c23e;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Mata Pelajaran Terpopuler</h5>
                        <small class="text-muted">Berdasarkan jumlah siswa terdaftar</small>
                    </div>
                </div>
                <div style="position: relative; height: 220px;">
                    <canvas id="adminTopCoursesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== RECENT ACTIVITY TABLE ===== --}}
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="d-flex align-items-center px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                        <i class="mdi mdi-history" style="font-size: 18px; color: #4e73df;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Aktivitas Platform Terbaru</h5>
                        <small class="text-muted">Perkembangan siswa dan pembaruan mata pelajaran</small>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th style="padding: 12px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Aktivitas</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Pengguna</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Mata Pelajaran</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Jenis</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivity ?? [] as $activity)
                            <tr style="transition: background 0.15s;" onmouseover="this.style.background='#f8f9fc';" onmouseout="this.style.background='white';">
                                <td style="padding: 13px 20px; border-bottom: 1px solid #f0f0f3; font-size: 13px; color: #3d3d3d;">{{ $activity['description'] ?? '—' }}</td>
                                <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3; font-size: 13px; color: #3d3d3d; font-weight: 500;">{{ $activity['user_name'] ?? '—' }}</td>
                                <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3; font-size: 13px; color: #3d3d3d;">{{ $activity['course_title'] ?? '—' }}</td>
                                <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3;">
                                    @php $t = $activity['type'] ?? 'enrollment'; @endphp
                                    <span style="background: {{ $t === 'enrollment' ? '#e3f9e5' : '#e8f0fe' }}; color: {{ $t === 'enrollment' ? '#1cc88a' : '#4e73df' }}; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">
                                        {{ ucfirst($t) }}
                                    </span>
                                </td>
                                <td style="padding: 13px 16px; border-bottom: 1px solid #f0f0f3; font-size: 12.5px; color: #858796;">{{ $activity['created_at'] ?? now()->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="padding: 40px; text-align: center;">
                                    <i class="mdi mdi-history" style="font-size: 36px; color: #d1d3e2;"></i>
                                    <p class="text-muted mt-2 mb-0" style="font-size: 13px;">Tidak ada aktivitas terbaru</p>
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

    const tooltipDefaults = {
        backgroundColor: 'rgba(0,0,0,0.82)',
        titleColor: '#fff', bodyColor: '#fff',
        cornerRadius: 8, borderWidth: 0
    };

    document.addEventListener('DOMContentLoaded', function() {

        // 1. Enrollment Trends
        const monthlyData = @json($monthlyEnrollments ?? []);
        window.enrollmentChart = new Chart(document.getElementById('enrollmentTrendsChart'), {
            type: 'line',
            data: {
                labels: monthlyData.map(d => d.month),
                datasets: [
                    { label: 'Selesai', data: monthlyData.map(d => d.completed), borderColor: '#1cc88a', backgroundColor: 'rgba(28,200,138,0.08)', fill: true, tension: 0.4, pointBackgroundColor: '#1cc88a', pointBorderColor: '#fff', pointBorderWidth: 2, pointRadius: 5 },
                    { label: 'Berlangsung', data: monthlyData.map(d => d.active), borderColor: '#4e73df', backgroundColor: 'rgba(78,115,223,0.08)', fill: true, tension: 0.4, pointBackgroundColor: '#4e73df', pointBorderColor: '#fff', pointBorderWidth: 2, pointRadius: 5 }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false, interaction: { mode: 'index', intersect: false },
                plugins: { legend: { position: 'top', labels: { usePointStyle: true, padding: 16 } }, tooltip: tooltipDefaults },
                scales: { x: { grid: { display: false }, ticks: { color: '#6c757d' } }, y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { color: '#6c757d', stepSize: 1 } } }
            }
        });

        // 2. Course Level Doughnut
        const beg = {{ $coursesByLevel['beginner'] ?? $coursesByLevel['Beginner'] ?? 0 }};
        const mid = {{ $coursesByLevel['intermediate'] ?? $coursesByLevel['Intermediate'] ?? 0 }};
        const adv = {{ $coursesByLevel['advanced'] ?? $coursesByLevel['Advanced'] ?? 0 }};
        new Chart(document.getElementById('courseLevelChart'), {
            type: 'doughnut',
            data: { labels: ['Pemula','Menengah','Lanjutan'], datasets: [{ data: [beg,mid,adv], backgroundColor: ['rgba(78,115,223,0.85)','rgba(28,200,138,0.85)','rgba(231,74,59,0.85)'], borderColor: ['#4e73df','#1cc88a','#e74a3b'], borderWidth: 2, hoverOffset: 8 }] },
            options: { responsive: true, maintainAspectRatio: false, cutout: '62%', plugins: { legend: { display: false }, tooltip: tooltipDefaults } }
        });

        // 3. Attendance weekly
        const weeklyAtt = @json($weeklyAttendanceChart ?? []);
        new Chart(document.getElementById('activityHeatmapChart'), {
            type: 'line',
            data: {
                labels: weeklyAtt.map(d => d.day),
                datasets: [
                    { label: 'Hadir',  data: weeklyAtt.map(d => d.present), borderColor: '#1cc88a', backgroundColor: 'rgba(28,200,138,0.07)', fill: true, tension: 0.4, pointBackgroundColor: '#1cc88a', pointBorderColor: '#fff', pointBorderWidth: 2, pointRadius: 4 },
                    { label: 'Absen',  data: weeklyAtt.map(d => d.absent),  borderColor: '#e74a3b', backgroundColor: 'rgba(231,74,59,0.07)',   fill: true, tension: 0.4, pointBackgroundColor: '#e74a3b', pointBorderColor: '#fff', pointBorderWidth: 2, pointRadius: 4 },
                    { label: 'Sakit',  data: weeklyAtt.map(d => d.sick),    borderColor: '#f6c23e', backgroundColor: 'rgba(246,194,62,0.07)',  fill: true, tension: 0.4, pointBackgroundColor: '#f6c23e', pointBorderColor: '#fff', pointBorderWidth: 2, pointRadius: 4 }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false, interaction: { mode: 'index', intersect: false },
                plugins: { legend: { position: 'top', labels: { usePointStyle: true, padding: 12, font: { size: 11 } } }, tooltip: tooltipDefaults },
                scales: { x: { grid: { display: false }, ticks: { color: '#6c757d', font: { size: 11 } } }, y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { color: '#6c757d', stepSize: 1 } } }
            }
        });

        // 4. Completion rates
        const lessonProg = @json($lessonProgressChart ?? []);
        new Chart(document.getElementById('completionRatesChart'), {
            type: 'bar',
            data: {
                labels: lessonProg.map(d => d.label),
                datasets: [
                    { label: 'Selesai',       data: lessonProg.map(d => d.completed),  backgroundColor: 'rgba(28,200,138,0.85)', borderRadius: 4 },
                    { label: 'Belum Selesai', data: lessonProg.map(d => d.incomplete), backgroundColor: 'rgba(78,115,223,0.2)',  borderRadius: 4 }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false, interaction: { mode: 'index', intersect: false },
                plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 12, font: { size: 11 } } }, tooltip: tooltipDefaults },
                scales: { x: { stacked: true, grid: { display: false }, ticks: { color: '#6c757d', font: { size: 10 } } }, y: { stacked: true, beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { stepSize: 1 } } }
            }
        });

        // 5. Task & Quiz monthly
        const mTasks = @json($monthlyTaskSubmissions ?? []);
        const mQuiz  = @json($monthlyQuizAttempts ?? []);
        new Chart(document.getElementById('adminTaskQuizChart'), {
            type: 'bar',
            data: {
                labels: mTasks.map(d => d.month),
                datasets: [
                    { label: 'Pengumpulan Tugas', data: mTasks.map(d => d.count), backgroundColor: 'rgba(78,115,223,0.85)', borderRadius: 4 },
                    { label: 'Percobaan Kuis',    data: mQuiz.map(d => d.count),  backgroundColor: 'rgba(23,162,184,0.85)',  borderRadius: 4 }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false, interaction: { mode: 'index', intersect: false },
                plugins: { legend: { position: 'top', labels: { usePointStyle: true, padding: 12, font: { size: 11 } } }, tooltip: tooltipDefaults },
                scales: { x: { grid: { display: false }, ticks: { color: '#6c757d', maxRotation: 45, font: { size: 10 } } }, y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { stepSize: 1 } } }
            }
        });

        // 6. Top courses
        const topC = @json($topCoursesByEnrollment ?? []);
        new Chart(document.getElementById('adminTopCoursesChart'), {
            type: 'bar',
            data: {
                labels: topC.map(d => d.label),
                datasets: [{ label: 'Siswa', data: topC.map(d => d.count), backgroundColor: palette, borderRadius: 6 }]
            },
            options: { responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: tooltipDefaults },
                scales: { x: { grid: { display: false }, ticks: { color: '#6c757d', font: { size: 10 } } }, y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });

    });

    function updateEnrollmentChart(period) {
        const periods = {
            '6months': ['Jul','Agu','Sep','Okt','Nov','Des'],
            '12months': ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des']
        };
        window.enrollmentChart.data.labels = periods[period] || periods['12months'];
        window.enrollmentChart.update();
    }
</script>
@endpush

@endsection