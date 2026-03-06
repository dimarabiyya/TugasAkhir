@extends('layouts.skydash')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Selamat Datang {{ auth()->user()->name }}</h3>
                <h6 class="font-weight-normal mb-0">Kelola Mata Pelajaran Anda dan lacak kemajuan siswa Anda!</h6>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards - Row 1 -->
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card tale-bg">
            <div class="card-people mt-auto">
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
            <div class="col-md-6 mb-4 stretch-card transparent">
                <div class="card card-tale interactive-card">
                    <div class="card-body position-relative">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-2">Total Mata Pelajaran</p>
                                <p class="fs-30 mb-2">{{ number_format($totalCourses ?? 0) }}</p>
                                <p class="text-white mb-0">{{ number_format($publishedCourses ?? 0) }} dipublikasikan</p>
                            </div>
                            <div class="card-icon-circle">
                                <i class="mdi mdi-school"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4 stretch-card transparent">
                <div class="card card-dark-blue interactive-card">
                    <div class="card-body position-relative">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-2">Kehadiran Hari Ini</p>
                                <p class="fs-30 mb-2"> {{ $todayPresent }}</p>
                                <p class="text-white mb-0">dari {{ $todayTotal }} total siswa</p>
                            </div>
                            <div class="card-icon-circle">
                                <i class="mdi mdi-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4 stretch-card transparent">
                <div class="card card-light-blue interactive-card">
                    <div class="card-body position-relative">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                            <p class="mb-2">Total Tugas</p>
                            <p class="fs-30 mb-2">{{ number_format($totalTasks ?? 0) }}</p>
                            <p class="text-white mb-0">{{ number_format($pendingTaskSubmissions ?? 0) }} menunggu</p>
                        </div>
                        <div class="card-icon-circle">
                            <i class="mdi mdi-file-check"></i>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4 stretch-card transparent">
                <div class="card card-light-danger interactive-card">
                    <div class="card-body position-relative">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-2">Total Kuis</p>
                                <p class="fs-30 mb-2">{{ number_format($totalQuizzes ?? 0) }}</p>
                                <p class="text-white mb-0">{{ number_format($totalQuizAttempts ?? 0) }} Dikumpulkan</p>
                            </div>
                            <div class="card-icon-circle">
                                <i class="mdi mdi-clipboard-text"></i>
                            </div>
                        </div>
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
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-1">Tren Peningkatan Pembelajaran Siswa</h4>
                </div>
                <p class="text-muted mb-3">Lacak pola pembelajaran Mata Pelajaran dan keterlibatan siswa</p>
                <div class="chart-container">
                    <canvas id="enrollmentTrendsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Course Performance -->
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-1">Performa Mata Pelajaran</h4>
                <p class="text-muted mb-3text-muted mb-3">Mata Pelajaran Anda berdasarkan tingkat penyelesaian</p>
                <div class="chart-container-small">
                    <canvas id="coursePerformanceChart"></canvas>
                </div>
                <div class="mt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Performa Tinggi</span>
                        <span class="font-weight-bold text-success">{{ $highPerformanceCourses ?? 0 }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Performa Sedang</span>
                        <span class="font-weight-bold text-warning">{{ $mediumPerformanceCourses ?? 0 }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Perlu Perhatian</span>
                        <span class="font-weight-bold text-danger">{{ $lowPerformanceCourses ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section - Row 2 -->
<div class="row">
    <!-- Student Activity -->
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-1">Absensi Siswa Mingguan</h4>
                <p class="text-muted mb-3">Pola Absensi siswa berdasarkan hari</p>
                <div class="chart-container-small">
                    <canvas id="studentActivityChart"></canvas>
                </div>
            </div>
        </div>
    </div>

     <!-- Course Completion Rates -->
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-1">Penyelesaian Mata Pelajaran</h4>
                <p class="text-muted mb-3">Tingkat penyelesaian berdasarkan Mata Pelajaran</p>
                <div class="chart-container-small">
                    <canvas id="lessonProgressChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Charts Section - Row 3 -->
<div class="row">
    <!-- Task Submission Chart -->
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-1">Pengumpulan Tugas</h4>
                <p class="text-muted mb-3" style="font-size:13px">Jumlah siswa yang mengumpulkan per tugas</p>
                <div class="chart-container-small">
                    <canvas id="taskSubmissionChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Quiz Attempt Chart -->
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-1">Pengerjaan Kuis</h4>
                <p class="text-muted mb-3" style="font-size:13px">Jumlah percobaan siswa per kuis</p>
                <div class="chart-container-small">
                    <canvas id="quizAttemptChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Recent Courses Table -->
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Mata Pelajaran Terbaru</h4>
                <p class="font-weight-500 mb-0">Pembaruan Mata Pelajaran terbaru Anda</p>
                <div class="table-responsive mt-3">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Mata Pelajaran</th>
                                <th>Tingkat</th>
                                <th>Modul</th>
                                <th>Siswa</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentCourses ?? [] as $course)
                            <tr>
                                <td>{{ $course->title ?? 'Course Title' }}</td>
                                <td>{{ $course->level ?? 'N/A' }}</td>
                                <td>{{ $course->modules->count() ?? 0 }}</td>
                                <td>{{ $course->enrollments->count() ?? 0 }}</td>
                                <td>
                                    <label class="badge {{ $course->is_published ? 'badge-success' : 'badge-warning' }}">
                                        {{ $course->is_published ? 'Dipublikasikan' : 'Draf' }}
                                    </label>
                                </td>
                                <td>{{ $course->created_at->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada Mata Pelajaran. <a href="{{ route('courses.create') }}">Buat Mata Pelajaran pertama Anda</a></td>
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

    /* Stagger Animation Delay for Multiple Cards */
    .interactive-card:nth-child(1) {
        animation-delay: 0.05s;
    }

    .interactive-card:nth-child(2) {
        animation-delay: 0.1s;
    }

    .interactive-card:nth-child(3) {
        animation-delay: 0.15s;
    }

    .interactive-card:nth-child(4) {
        animation-delay: 0.2s;
    }

    /* Pulse Effect for Numbers */
    .fs-30 {
        transition: all 0.3s ease;
    }

    .interactive-card:hover .fs-30 {
        transform: scale(1.05);
        font-weight: 700;
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
    
    let enrollmentTrendsChart, coursePerformanceChart, studentActivityChart, completionRatesChart;
    
    // Initialize all charts
    document.addEventListener('DOMContentLoaded', function() {
        initEnrollmentTrendsChart();
        initCoursePerformanceChart();
        initStudentActivityChart();
        initCompletionRatesChart();
    });
    
    // Enrollment Trends Chart - with real data from controller
    function initEnrollmentTrendsChart() {
        const ctx = document.getElementById('enrollmentTrendsChart').getContext('2d');
        
        // Monthly enrollments data from controller
        const monthlyData = @json($monthlyEnrollmentsData ?? array_fill(0, 12, 0));
        
        enrollmentTrendsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Materi Selesai',
                        data: lessonProgressData.map(d => d.completed),
                        backgroundColor: 'rgba(0, 210, 91, 0.85)',
                        borderRadius: 6,
                        borderSkipped: false,
                    },
                    {
                        label: 'Belum Selesai',
                        data: lessonProgressData.map(d => d.incomplete),
                        backgroundColor: 'rgba(102, 126, 234, 0.25)',
                        borderRadius: 6,
                        borderSkipped: false,
                    }
                ]
            },
            options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: {
                    position: 'top',
                    labels: { usePointStyle: true, padding: 20 }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#667eea',
                    borderWidth: 1,
                    cornerRadius: 8,
                    callbacks: {
                        afterBody: function(items) {
                            const i = items[0].dataIndex;
                            const total = lessonProgressData[i].completed + lessonProgressData[i].incomplete;
                            const pct = total > 0 
                                ? Math.round((lessonProgressData[i].completed / total) * 100) 
                                : 0;
                            return `Progress: ${pct}%`;
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

    // Course Performance Chart - with real data from controller
    function initCoursePerformanceChart() {
        const ctx = document.getElementById('coursePerformanceChart').getContext('2d');
        
        // Course performance data from controller
        const highPerf = {{ $highPerformanceCourses ?? 0 }};
        const mediumPerf = {{ $mediumPerformanceCourses ?? 0 }};
        const lowPerf = {{ $lowPerformanceCourses ?? 0 }};
        
        coursePerformanceChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Performa Tinggi', 'Performa Sedang', 'Perlu Perhatian'],
                datasets: [{
                    data: [highPerf, mediumPerf, lowPerf],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(220, 53, 69, 0.8)'
                    ],
                    borderColor: [
                        '#28a745',
                        '#ffc107',
                        '#dc3545'
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
    
    // Student Activity Chart - with real data from controller
    function initStudentActivityChart() {
        const ctx = document.getElementById('studentActivityChart').getContext('2d');

        const weeklyAttendance = @json($weeklyAttendanceChart ?? []);

        studentActivityChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: weeklyAttendance.map(d => d.day),
                datasets: [
                    {
                        label: 'Hadir',
                        data: weeklyAttendance.map(d => d.present),
                        borderColor: '#00d25b',
                        backgroundColor: 'rgba(0, 210, 91, 0.08)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#00d25b',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    },
                    {
                        label: 'Absen',
                        data: weeklyAttendance.map(d => d.absent),
                        borderColor: '#fc424a',
                        backgroundColor: 'rgba(252, 66, 74, 0.08)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#fc424a',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    },
                    {
                        label: 'Sakit',
                        data: weeklyAttendance.map(d => d.sick),
                        borderColor: '#ffab00',
                        backgroundColor: 'rgba(255, 171, 0, 0.08)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#ffab00',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { intersect: false, mode: 'index' },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { usePointStyle: true, padding: 16, font: { size: 12 } }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        cornerRadius: 8,
                        borderColor: '#667eea',
                        borderWidth: 1,
                        callbacks: {
                            footer: function(items) {
                                const total = items.reduce((s, i) => s + i.parsed.y, 0);
                                return `Total: ${total} siswa`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#6c757d' }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        ticks: { color: '#6c757d', stepSize: 1 }
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

    // ── Data dari controller ──────────────────────────────────
    const taskSubmissionData  = @json($taskSubmissionChart);
    const quizAttemptData     = @json($quizAttemptChart);
    const lessonProgressData  = @json($lessonProgressChart);

    // ── Warna palette ────────────────────────────────────────
    const palette = [
        '#695ced','#00d25b','#ffab00','#fc424a',
        '#0090e7','#e4a951','#58d8a3','#f17e5d'
    ];

    // 1. Task Submission — Bar horizontal
    new Chart(document.getElementById('taskSubmissionChart'), {
        type: 'bar',
        data: {
            labels: taskSubmissionData.map(d => d.label),
            datasets: [{
                label: 'Pengumpulan',
                data: taskSubmissionData.map(d => d.count),
                backgroundColor: palette,
                borderRadius: 6,
            }]
        },
        options: {
            indexAxis: 'x',
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, ticks: { stepSize: 1 } },
                y: { ticks: { font: { size: 11 } } }
            }
        }
    });

    // 2. Quiz Attempt — Bar horizontal
    new Chart(document.getElementById('quizAttemptChart'), {
        type: 'bar',
        data: {
            labels: quizAttemptData.map(d => d.label),
            datasets: [{
                label: 'Percobaan',
                data: quizAttemptData.map(d => d.count),
                backgroundColor: palette,
                borderRadius: 6,
            }]
        },
        options: {
            indexAxis: 'x',
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, ticks: { stepSize: 1 } },
                y: { ticks: { font: { size: 11 } } }
            }
        }
    });

    // 3. Lesson Progress — Stacked bar per course
    new Chart(document.getElementById('lessonProgressChart'), {
        type: 'bar',
        data: {
            labels: lessonProgressData.map(d => d.label),
            datasets: [
                {
                    label: 'Selesai',
                    data: lessonProgressData.map(d => d.completed),
                    backgroundColor: [
                        "#4CAF50",
                        "#009688",
                        "#F57C00",
                        "#2E7D32",
                        "#455A64",
                    ],
                    borderRadius: 8,
                },
                {
                    label: 'Belum',
                    data: lessonProgressData.map(d => d.incomplete),
                    backgroundColor: [
                        "#8BC34A",
                        "#4DB6AC",
                        "#FFB300",
                        "#A5D6A7",
                        "#90A4AE",  
                    ],
                    borderRadius: 8,
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                x: { stacked: true, ticks: { font: { size: 8 } } },
                y: { stacked: true, beginAtZero: true, ticks: { stepSize: 1 } }
            },
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 12 } } }
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
                    },
        }
    });
</script>
@endpush
@endsection