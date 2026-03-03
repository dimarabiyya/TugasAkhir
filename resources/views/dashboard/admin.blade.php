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
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card card-tale interactive-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-2">Total Siswa</p>
                        <p class="fs-30 mb-2">{{ number_format($totalStudents ?? 0) }}</p>
                        <p class="text-muted mb-0">Pembelajar Aktif</p>
                    </div>
                    <div class="card-icon-circle">
                        <i class="mdi mdi-account-group"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Total Courses Card -->
    <div class="col-md-3 grid-margin stretch-card">
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
    
    <!-- Total Enrollments Card -->
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card card-light-blue interactive-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-2">Total Pendaftaran</p>
                        <p class="fs-30 mb-2">{{ number_format($totalEnrollments ?? 0) }}</p>
                        <p class="text-muted mb-0">{{ number_format($activeEnrollments ?? 0) }} aktif</p>
                    </div>
                    <div class="card-icon-circle">
                        <i class="mdi mdi-account-plus"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Total Revenue Card -->
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card card-light-danger interactive-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-2">Total Pendapatan</p>
                        <p class="fs-30 mb-2">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
                        <p class="text-muted mb-0">{{ number_format($totalTransactions ?? 0) }} transaksi</p>
                    </div>
                    <div class="card-icon-circle">
                        <i class="mdi mdi-currency-usd"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards - Row 2 -->
<div class="row">
    <!-- Total Modules Card -->
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card card-tale interactive-card">
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
    
    <!-- Total Quizzes Card -->
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card card-dark-blue interactive-card">
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
    
    <!-- Tasks Card -->
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card card-light-blue interactive-card">
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
    
    <!-- Attendance Card -->
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card card-light-danger interactive-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-2">Kehadiran Hari Ini</p>
                        <p class="fs-30 mb-2">{{ number_format($presentToday ?? 0) }}</p>
                        <p class="text-muted mb-0">dari {{ number_format($totalAttendances ?? 0) }} total</p>
                    </div>
                    <div class="card-icon-circle">
                        <i class="mdi mdi-check-circle"></i>
                    </div>
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
                <h4 class="card-title mb-4">Aktivitas Siswa Mingguan</h4>
                <p class="font-weight-500 mb-3">Pola aktivitas berdasarkan hari</p>
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
    });
    
    // Enrollment Trends Chart - with real data from controller
    function initEnrollmentTrendsChart() {
        const ctx = document.getElementById('enrollmentTrendsChart').getContext('2d');
        
        // Monthly enrollments data from controller
        const monthlyData = @json($monthlyEnrollmentsData ?? array_fill(0, 12, 0));
        
        enrollmentTrendsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Pendaftaran Siswa',
                    data: monthlyData,
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#667eea',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#667eea',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: true
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6c757d'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            color: '#6c757d'
                        }
                    }
                },
                elements: {
                    line: {
                        borderWidth: 3
                    }
                }
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
    
    // Activity Heatmap Chart - with real data from controller
    function initActivityHeatmapChart() {
        const ctx = document.getElementById('activityHeatmapChart').getContext('2d');
        
        // Weekly activity data from controller
        const weeklyData = @json($weeklyActivity ?? []);
        const days = weeklyData.map(w => w.day);
        const enrollments = weeklyData.map(w => w.enrollments);
        
        activityHeatmapChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: days.length > 0 ? days : ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Pendaftaran',
                    data: enrollments.length > 0 ? enrollments : [0, 0, 0, 0, 0, 0, 0],
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(118, 75, 162, 0.6)',
                        'rgba(118, 75, 162, 0.6)'
                    ],
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        cornerRadius: 8
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6c757d'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            color: '#6c757d'
                        }
                    }
                }
            }
        });
    }
    
    // Course Completion Rates Chart - with real data from controller
    function initCompletionRatesChart() {
        const ctx = document.getElementById('completionRatesChart').getContext('2d');
        
        // Course completion data from controller
        const completionData = @json($courseCompletionRates ?? []);
        const courseLabels = completionData.length > 0 ? completionData.map(c => c.title) : ['Course A', 'Course B', 'Course C', 'Course D', 'Course E'];
        const completionRates = completionData.length > 0 ? completionData.map(c => c.rate) : [85, 92, 78, 88, 95];
        
        completionRatesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: courseLabels,
                datasets: [{
                    label: 'Tingkat Penyelesaian (%)',
                    data: completionRates,
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(118, 75, 162, 0.8)',
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(255, 193, 7, 0.8)'
                    ],
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + '%';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6c757d'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            color: '#6c757d',
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
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

