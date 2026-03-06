@extends('layouts.skydash')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Dashboard Admin</h3>
                <h6 class="font-weight-normal mb-0">Halo {{ auth()->user()->name }}! Pantau performa dan analitik platform Anda.</h6>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards - Row 1 -->
<div class="row">
    <!-- Total Students Card -->
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card tale-bg" >
            <div class="card-people mt-auto" >
                <img src="{{ asset('skydash/images/dashboard/people.svg') }}" alt="people">
                <div class="weather-info">
                    <div class="d-flex">
                        <div>
                            <h2 class="mb-0 font-weight-normal"><i class="mdi mdi-school me-2"></i>{{ $totalStudents ?? 0 }}</h2>
                        </div>
                        <div class="ms-2">
                            <h4 class="location font-weight-normal">Total Siswa</h4>
                            <h6 class="font-weight-normal">Aktif pembelajaran</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 grid-margin transparent">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card card-dark-blue interactive-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-2">Total Mata Pelajaran</p>
                                <p class="fs-30 mb-2">{{ number_format($totalCourses ?? 0) }}</p>
                                <p class="text-muted mb-0">{{ number_format($publishedCourses ?? 0) }} dipublikasikan</p>
                            </div>
                            <div class="card-icon-circle">
                                <i class="mdi mdi-school"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card card-light-blue interactive-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-2">Total Modul</p>
                                <p class="fs-30 mb-2">{{ number_format($totalModules ?? 0) }}</p>
                                <p class="text-muted mb-0">Di seluruh Mata Pelajaran</p>
                            </div>
                            <div class="card-icon-circle">
                                <i class="mdi mdi-file-document"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card card-light-danger interactive-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-2">Total Kuis</p>
                                <p class="fs-30 mb-2">{{ number_format($totalQuizzes ?? 0) }}</p>
                                <p class="text-muted mb-0">Tersedia</p>
                            </div>
                            <div class="card-icon-circle">
                                <i class="mdi mdi-clipboard-text"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card card-tale interactive-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-2">Total Tugas</p>
                                <p class="fs-30 mb-2">{{ number_format($totalTasks ?? 0) }}</p>
                                <p class="text-muted mb-0">{{ number_format($pendingTaskSubmissions ?? 0) }} menunggu</p>
                            </div>
                            <div class="card-icon-circle">
                                <i class="mdi mdi-file-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
{{-- Stats tambahan: Guru, Kelas, Pengumpulan Tugas --}}
<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card card-dark-blue interactive-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-2">Total Guru</p>
                        <p class="fs-30 mb-2">{{ number_format($totalInstructors ?? 0) }}</p>
                        <p class="text-muted mb-0">Aktif mengajar</p>
                    </div>
                    <div class="card-icon-circle">
                        <i class="mdi mdi-account-tie"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card card-light-blue interactive-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-2">Total Kelas</p>
                        <p class="fs-30 mb-2">{{ number_format($totalClassrooms ?? 0) }}</p>
                        <p class="text-muted mb-0">Terdaftar di platform</p>
                    </div>
                    <div class="card-icon-circle">
                        <i class="mdi mdi-domain"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card card-tale interactive-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-2">Total Pengumpulan Tugas</p>
                        <p class="fs-30 mb-2">{{ number_format($totalTaskSubmissions ?? 0) }}</p>
                        <p class="text-muted mb-0">Di seluruh mata pelajaran</p>
                    </div>
                    <div class="card-icon-circle">
                        <i class="mdi mdi-send-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Absensi hari ini --}}
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <h4 class="card-title mb-0">
                        <i class="mdi mdi-clipboard-account text-primary mr-2"></i>
                        Absensi Platform Hari Ini
                    </h4>
                    <span class="text-muted" style="font-size:13px">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </span>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge badge-pill badge-success px-3 py-2">
                        <i class="mdi mdi-check-circle mr-1"></i> Hadir: {{ $todayPresent ?? 0 }}
                    </span>
                    <span class="badge badge-pill badge-danger px-3 py-2">
                        <i class="mdi mdi-close-circle mr-1"></i> Absen: {{ $todayAbsent ?? 0 }}
                    </span>
                    <span class="badge badge-pill badge-warning px-3 py-2">
                        <i class="mdi mdi-emoticon-sick mr-1"></i> Sakit: {{ $todaySick ?? 0 }}
                    </span>
                    <span class="badge badge-pill badge-secondary px-3 py-2 ml-auto">
                        Total: {{ $todayTotal ?? 0 }} catatan
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section - Row 1 -->
<div class="row">
    <!-- Enrollment Trends Chart -->
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">Tren Perkembangan Siswa</h4>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="enrollmentChartDropdown" data-bs-toggle="dropdown">
                            <i class="mdi mdi-calendar"></i> 12 Bulan Terakhir
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" onclick="updateEnrollmentChart('6months')">6 Bulan Terakhir</a>
                            <a class="dropdown-item" href="#" onclick="updateEnrollmentChart('12months')">12 Bulan Terakhir</a>
                            <a class="dropdown-item" href="#" onclick="updateEnrollmentChart('year')">Tahun Ini</a>
                        </div>
                    </div>
                </div>
                <p class="font-weight-500 mb-3">Pola Perkembangan Siswa dari waktu ke waktu</p>
                <div class="chart-container">
                    <canvas id="enrollmentTrendsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Course Level Distribution -->
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Distribusi Mata Pelajaran</h4>
                <p class="font-weight-500 mb-3">Mata Pelajaran berdasarkan tingkat kesulitan</p>
                <div class="chart-container-small">
                    <canvas id="courseLevelChart"></canvas>
                </div>
                <div class="mt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Pemula</span>
                        <span class="font-weight-bold">{{ $coursesByLevel['beginner'] ?? $coursesByLevel['Beginner'] ?? 0 }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Menengah</span>
                        <span class="font-weight-bold">{{ $coursesByLevel['intermediate'] ?? $coursesByLevel['Intermediate'] ?? 0 }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Lanjutan</span>
                        <span class="font-weight-bold">{{ $coursesByLevel['advanced'] ?? $coursesByLevel['Advanced'] ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section - Row 2 -->
<div class="row">
    <!-- Student Activity Heatmap -->
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Kehadiran siswa</h4>
                <p class="font-weight-500 mb-3">Kehadiran siswa mingguan</p>
                <div class="chart-container-small">
                    <canvas id="activityHeatmapChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Course Completion Rates -->
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Penyelesaian Mata Pelajaran</h4>
                <p class="font-weight-500 mb-3">Tingkat penyelesaian berdasarkan Mata Pelajaran</p>
                <div class="chart-container-small">
                    <canvas id="completionRatesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Charts Row 3: Task + Quiz submission --}}
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-1">Aktivitas Tugas & Kuis per Bulan</h4>
                <p class="font-weight-500 mb-3">Pengumpulan tugas vs percobaan kuis</p>
                <div class="chart-container-small">
                    <canvas id="adminTaskQuizChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-1">Mata Pelajaran Terpopuler</h4>
                <p class="font-weight-500 mb-3">Berdasarkan jumlah siswa terbanyak</p>
                <div class="chart-container-small">
                    <canvas id="adminTopCoursesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Table -->
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Aktivitas Platform Terbaru</h4>
                <p class="font-weight-500 mb-0">Perkembangan siswa terbaru dan pembaruan Mata Pelajaran</p>
                <div class="table-responsive mt-3">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Aktivitas</th>
                                <th>Pengguna</th>
                                <th>Mata Pelajaran</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivity ?? [] as $activity)
                            <tr>
                                <td>{{ $activity['description'] ?? 'Course enrollment' }}</td>
                                <td>{{ $activity['user_name'] ?? 'Student' }}</td>
                                <td>{{ $activity['course_title'] ?? 'Course Title' }}</td>
                                <td>
                                    <label class="badge {{ $activity['type'] === 'enrollment' ? 'badge-success' : 'badge-info' }}">
                                        {{ ucfirst($activity['type'] ?? 'enrollment') }}
                                    </label>
                                </td>
                                <td>{{ $activity['created_at'] ?? now()->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada aktivitas terbaru</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Interactive Cards Hover Effect */
    .interactive-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .interactive-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1;
    }

    .interactive-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .interactive-card:hover::before {
        opacity: 1;
    }

    /* Icon Circle Styling */
    .card-icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .card-icon-circle i {
        font-size: 28px;
        color: rgba(255, 255, 255, 0.95);
        transition: all 0.3s ease;
    }

    .interactive-card:hover .card-icon-circle {
        background: rgba(255, 255, 255, 0.35);
        transform: scale(1.1) rotate(5deg);
    }

    .interactive-card:hover .card-icon-circle i {
        transform: scale(1.1);
    }

    /* Chart container styling */
    .card canvas {
        border-radius: 8px;
        max-height: 400px;
    }
    
    /* Responsive chart containers */
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
    
    .chart-container-small {
        position: relative;
        height: 250px;
        width: 100%;
    }
    
    /* Mobile chart adjustments */
    @media (max-width: 768px) {
        .chart-container {
            height: 250px;
        }
        
        .chart-container-small {
            height: 200px;
        }
        
        .card canvas {
            max-height: 250px;
        }
        
        .card-icon-circle {
            width: 50px;
            height: 50px;
        }

        .card-icon-circle i {
            font-size: 24px;
        }

        .interactive-card:hover {
            transform: translateY(-5px);
        }
    }
    
    @media (max-width: 576px) {
        .chart-container {
            height: 200px;
        }
        
        .chart-container-small {
            height: 180px;
        }
        
        .card canvas {
            max-height: 200px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Chart.js configuration
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#6c757d';
    
    let enrollmentTrendsChart, courseLevelChart, activityHeatmapChart, completionRatesChart;
    
    // Initialize all charts
    document.addEventListener('DOMContentLoaded', function() {
        initEnrollmentTrendsChart();
        initCourseLevelChart();
        initActivityHeatmapChart();
        initCompletionRatesChart();
        initTaskQuizChart();     
        initTopCoursesChart();    
    });
    
    // Enrollment Trends Chart - with real data from controller
    function initEnrollmentTrendsChart() {
        const ctx = document.getElementById('enrollmentTrendsChart').getContext('2d');
        
        const monthlyData = @json($monthlyEnrollments ?? []);
        
        enrollmentTrendsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: monthlyData.map(d => d.month),
                datasets: [
                    {
                        label: 'Pembelajaran Selesai',
                        data: monthlyData.map(d => d.completed),
                        borderColor: '#00d25b',
                        backgroundColor: 'rgba(0, 210, 91, 0.1)',
                        fill: true, tension: 0.4,
                        pointBackgroundColor: '#00d25b', pointBorderColor: '#fff',
                        pointBorderWidth: 2, pointRadius: 6, pointHoverRadius: 8
                    },
                    {
                        label: 'Sedang Belajar',
                        data: monthlyData.map(d => d.active),
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        fill: true, tension: 0.4,
                        pointBackgroundColor: '#667eea', pointBorderColor: '#fff',
                        pointBorderWidth: 2, pointRadius: 6, pointHoverRadius: 8
                    }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                interaction: { intersect: false, mode: 'index' },
                plugins: {
                    legend: { position: 'top', labels: { usePointStyle: true, padding: 20 } },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)', titleColor: '#fff',
                        bodyColor: '#fff', borderColor: '#667eea',
                        borderWidth: 1, cornerRadius: 8
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { color: '#6c757d' } },
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { color: '#6c757d', stepSize: 1 } }
                },
                elements: { line: { borderWidth: 3 } }
            }
        });
    }
    
    // Course Level Distribution Chart - with real data from controller
    function initCourseLevelChart() {
        const ctx = document.getElementById('courseLevelChart').getContext('2d');
        
        // Course level data from controller
        const beginnerCount = {{ $coursesByLevel['beginner'] ?? $coursesByLevel['Beginner'] ?? 0 }};
        const intermediateCount = {{ $coursesByLevel['intermediate'] ?? $coursesByLevel['Intermediate'] ?? 0 }};
        const advancedCount = {{ $coursesByLevel['advanced'] ?? $coursesByLevel['Advanced'] ?? 0 }};
        
        courseLevelChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pemula', 'Menengah', 'Lanjutan'],
                datasets: [{
                    data: [beginnerCount, intermediateCount, advancedCount],
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(118, 75, 162, 0.8)',
                        'rgba(255, 99, 132, 0.8)'
                    ],
                    borderColor: [
                        '#667eea',
                        '#764ba2',
                        '#ff6384'
                    ],
                    borderWidth: 2,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        cornerRadius: 8
                    }
                },
                cutout: '60%'
            }
        });
    }
    
    function initActivityHeatmapChart() {
        const ctx = document.getElementById('activityHeatmapChart').getContext('2d');
        
        const weeklyAttendance = @json($weeklyAttendanceChart ?? []);
        
        activityHeatmapChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: weeklyAttendance.map(d => d.day),
                datasets: [
                    {
                        label: 'Hadir',
                        data: weeklyAttendance.map(d => d.present),
                        borderColor: '#00d25b', backgroundColor: 'rgba(0,210,91,0.08)',
                        fill: true, tension: 0.4,
                        pointBackgroundColor: '#00d25b', pointBorderColor: '#fff',
                        pointBorderWidth: 2, pointRadius: 5, pointHoverRadius: 7
                    },
                    {
                        label: 'Absen',
                        data: weeklyAttendance.map(d => d.absent),
                        borderColor: '#fc424a', backgroundColor: 'rgba(252,66,74,0.08)',
                        fill: true, tension: 0.4,
                        pointBackgroundColor: '#fc424a', pointBorderColor: '#fff',
                        pointBorderWidth: 2, pointRadius: 5, pointHoverRadius: 7
                    },
                    {
                        label: 'Sakit',
                        data: weeklyAttendance.map(d => d.sick),
                        borderColor: '#ffab00', backgroundColor: 'rgba(255,171,0,0.08)',
                        fill: true, tension: 0.4,
                        pointBackgroundColor: '#ffab00', pointBorderColor: '#fff',
                        pointBorderWidth: 2, pointRadius: 5, pointHoverRadius: 7
                    }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                interaction: { intersect: false, mode: 'index' },
                plugins: {
                    legend: { position: 'top', labels: { usePointStyle: true, padding: 16 } },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)', cornerRadius: 8,
                        callbacks: {
                            footer: items => 'Total: ' + items.reduce((s, i) => s + i.parsed.y, 0) + ' siswa'
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { color: '#6c757d' } },
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { color: '#6c757d', stepSize: 1 } }
                }
            }
        });
    }
        
    // Course Completion Rates Chart - with real data from controller
    function initCompletionRatesChart() {
        const ctx = document.getElementById('completionRatesChart').getContext('2d');
        
        const lessonProgress = @json($lessonProgressChart ?? []);
        
        completionRatesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: lessonProgress.map(d => d.label),
                datasets: [
                    {
                        label: 'Materi Selesai',
                        data: lessonProgress.map(d => d.completed),
                        backgroundColor: 'rgba(0, 210, 91, 0.85)',
                        borderRadius: 4
                    },
                    {
                        label: 'Belum Selesai',
                        data: lessonProgress.map(d => d.incomplete),
                        backgroundColor: 'rgba(102, 126, 234, 0.2)',
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                interaction: { intersect: false, mode: 'index' },
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 16 } },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)', cornerRadius: 8,
                        callbacks: {
                            afterBody: function(items) {
                                const i = items[0].dataIndex;
                                const total = lessonProgress[i].completed + lessonProgress[i].incomplete;
                                const pct = total > 0 ? Math.round((lessonProgress[i].completed / total) * 100) : 0;
                                return 'Progress: ' + pct + '%';
                            }
                        }
                    }
                },
                scales: {
                    x: { stacked: true, grid: { display: false }, ticks: { color: '#6c757d', font: { size: 11 } } },
                    y: { stacked: true, beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { color: '#6c757d', stepSize: 1 } }
                }
            }
        });
    }

    function initTaskQuizChart() {
        const ctx = document.getElementById('adminTaskQuizChart').getContext('2d');
        const monthlyTasks = @json($monthlyTaskSubmissions ?? []);
        const monthlyQuiz  = @json($monthlyQuizAttempts ?? []);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: monthlyTasks.map(d => d.month),
                datasets: [
                    {
                        label: 'Pengumpulan Tugas',
                        data: monthlyTasks.map(d => d.count),
                        backgroundColor: 'rgba(102,126,234,0.8)', borderRadius: 4
                    },
                    {
                        label: 'Percobaan Kuis',
                        data: monthlyQuiz.map(d => d.count),
                        backgroundColor: 'rgba(0,144,231,0.8)', borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                interaction: { intersect: false, mode: 'index' },
                plugins: {
                    legend: { position: 'top', labels: { usePointStyle: true, padding: 12 } },
                    tooltip: { backgroundColor: 'rgba(0,0,0,0.8)', cornerRadius: 8 }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { color: '#6c757d', maxRotation: 45, font: { size: 11 } } },
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { stepSize: 1 } }
                }
            }
        });
    }

    function initTopCoursesChart() {
        const ctx = document.getElementById('adminTopCoursesChart').getContext('2d');
        const topCourses = @json($topCoursesByEnrollment ?? []);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: topCourses.map(d => d.label),
                datasets: [{
                    label: 'Siswa',
                    data: topCourses.map(d => d.count),
                    backgroundColor: [
                        'rgba(102,126,234,0.8)','rgba(0,210,91,0.8)','rgba(255,171,0,0.8)',
                        'rgba(252,66,74,0.8)','rgba(0,144,231,0.8)','rgba(228,169,81,0.8)',
                        'rgba(88,216,163,0.8)','rgba(241,126,93,0.8)'
                    ],
                    borderRadius: 6
                }]
            },
            options: {
                indexAxis: 'x',
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { backgroundColor: 'rgba(0,0,0,0.8)', cornerRadius: 8 } },
                scales: {
                    x: { beginAtZero: true, ticks: { stepSize: 1 } },
                    y: { ticks: { font: { size: 11 } } }
                }
            }
        });
    }
    
    // Chart update functions
    function updateEnrollmentChart(period) {
        // Simulate data update based on period
        const periods = {
            '6months': ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            '12months': ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'year': ['Q1', 'Q2', 'Q3', 'Q4']
        };
        
        enrollmentTrendsChart.data.labels = periods[period] || periods['12months'];
        enrollmentTrendsChart.update();
    }
    
    function updateCharts(period) {
        // Update all charts based on selected period
        console.log('Updating charts for period:', period);
    }
</script>
@endpush
@endsection

