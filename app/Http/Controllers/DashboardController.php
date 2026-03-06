<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use App\Models\QuizAttempt;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\Attendance;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Display the dashboard for students
     */
    public function student()
    {
        $user = Auth::user();
        
        // 1. Ambil semua ID kelas yang di-assign ke student
        $classroomIds = $user->classrooms()->pluck('classrooms.id');
        
        // 2. Ambil course/modules HANYA yang ada di dalam kelas-kelas tersebut
        $enrolledCourses = Course::whereIn('classroom_id', $classroomIds)
            ->with(['modules.lessons'])
            ->get();

        // Simpan ID semua course yang relevan untuk filter query selanjutnya
        $courseIds = $enrolledCourses->pluck('id');

        // 3. Ambil progress pelajaran TERBARU (Hanya dari course kelas yang di-assign)
        $recentProgress = $user->lessonProgress()
            ->whereHas('lesson.module.course', function($q) use ($classroomIds) {
                $q->whereIn('classroom_id', $classroomIds);
            })
            ->with('lesson.module.course')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        // 4. Ambil history kuis TERBARU (Hanya dari kuis milik course kelas yang di-assign)
        $recentQuizAttempts = $user->quizAttempts()
            ->whereHas('quiz.lesson.module', function($q) use ($courseIds) {
                $q->whereIn('course_id', $courseIds);
            })
            ->with('quiz.lesson.module.course')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // --- KALKULASI STATISTIK (DIBATASI KELAS) ---

        $totalEnrolledCourses = $enrolledCourses->count();
        
        // Statistik enrollment dibatasi hanya course yang ada di kelas student
        $completedCourses = $user->enrollments()
            ->whereIn('course_id', $courseIds)
            ->whereNotNull('completed_at')
            ->count();

        $activeCourses = $user->enrollments()
            ->whereIn('course_id', $courseIds)
            ->whereNull('completed_at')
            ->count();

        // Total semua lesson yang ada di kelas student
        $totalLessons = $enrolledCourses->sum(function($course) {
            return $course->modules->sum(fn($module) => $module->lessons->count());
        });
        
        // Hitung lesson yang sudah selesai (Dibatasi lesson di dalam kelas student)
        $completedLessonsCount = $user->lessonProgress()
            ->where('is_completed', true)
            ->whereHas('lesson.module', function($q) use ($courseIds) {
                $q->whereIn('course_id', $courseIds);
            })->count();

        $overallProgress = $totalLessons > 0 ? round(($completedLessonsCount / $totalLessons) * 100, 2) : 0;
        
        // --- STATISTIK KUIS (DIBATASI KELAS) ---
        
        $submittedAttempts = $user->quizAttempts()
            ->where('submitted', true)
            ->whereHas('quiz.lesson.module', function($q) use ($courseIds) {
                $q->whereIn('course_id', $courseIds);
            })
            ->with('quiz')
            ->get();
        
        $totalQuizAttempts = $submittedAttempts->count();
        $passedQuizzes = 0;
        $failedQuizzes = 0;
        $totalScorePercentage = 0;
        
        foreach ($submittedAttempts as $attempt) {
            $totalScorePercentage += $attempt->score_percentage ?? 0;
            
            // Cek kelulusan
            if (isset($attempt->is_passed)) {
                $attempt->is_passed ? $passedQuizzes++ : $failedQuizzes++;
            } elseif ($attempt->quiz) {
                $percentage = $attempt->score_percentage ?? 0;
                $percentage >= ($attempt->quiz->passing_score ?? 70) ? $passedQuizzes++ : $failedQuizzes++;
            }
        }
        
        $averageScore = $totalQuizAttempts > 0 ? $totalScorePercentage / $totalQuizAttempts : 0;
        
        // --- DATA CHART ---

        // Progress per course
        $courseProgress = $enrolledCourses->map(function($course) use ($user) {
            $lessonsInCourse = $course->modules->flatMap(fn($m) => $m->lessons);
            $totalCourseLessons = $lessonsInCourse->count();
            
            $completedCourseLessons = $user->lessonProgress()
                ->whereIn('lesson_id', $lessonsInCourse->pluck('id'))
                ->where('is_completed', true)
                ->count();
                
            return [
                'course' => $course->title,
                'progress' => $totalCourseLessons > 0 ? round(($completedCourseLessons / $totalCourseLessons) * 100, 1) : 0,
                'completed' => $completedCourseLessons,
                'total' => $totalCourseLessons,
            ];
        })->values();

        // Weekly progress (tetap global atau bisa difilter ke kelas juga)
        $weeklyProgress = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $completedOnDate = $user->lessonProgress()
                ->where('is_completed', true)
                ->whereDate('updated_at', $date->toDateString())
                ->whereHas('lesson.module', fn($q) => $q->whereIn('course_id', $courseIds))
                ->count();
            $weeklyProgress[] = [
                'date' => $date->format('D'),
                'completed' => $completedOnDate,
            ];
        }

        // --- STATISTIK TASK (DIBATASI KELAS) ---

        // Ambil semua task yang ada di lesson → module → course yang di-assign ke student
        $totalTasks = Task::whereHas('lesson.module', function($q) use ($courseIds) {
            $q->whereIn('course_id', $courseIds);
        })->count();

        // Task yang sudah dikumpulkan oleh student ini
        $submittedTasks = TaskSubmission::where('user_id', $user->id)
            ->whereHas('task.lesson.module', function($q) use ($courseIds) {
                $q->whereIn('course_id', $courseIds);
            })->distinct('task_id')->count('task_id');

        // Task yang belum dikumpulkan
        $pendingTasks = $totalTasks - $submittedTasks;

        // Daftar task yang BELUM dikumpulkan (untuk ditampilkan di dashboard)
        $submittedTaskIds = TaskSubmission::where('user_id', $user->id)
            ->pluck('task_id');

        $pendingTaskList = Task::whereHas('lesson.module', function($q) use ($courseIds) {
                $q->whereIn('course_id', $courseIds);
            })
            ->whereNotIn('id', $submittedTaskIds)
            ->with('lesson.module.course')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.student', compact(
            'enrolledCourses', 'recentProgress', 'recentQuizAttempts', 'overallProgress',
            'totalEnrolledCourses', 'completedCourses', 'activeCourses', 'totalLessons',
            'completedLessonsCount', 'totalQuizAttempts', 'passedQuizzes', 'failedQuizzes',
            'averageScore', 'courseProgress', 'weeklyProgress','totalTasks', 'submittedTasks', 'pendingTasks',
            'pendingTaskList',
        ));
    }

    /**
     * Display the dashboard for instructors
     */
    public function instructor()
    {
        $user = Auth::user();
        
        $classroomIds = Course::where('instructor_id', $user->id)
        ->pluck('classroom_id')
        ->unique();
        
        $query = Course::where('instructor_id', $user->id);
        
        $totalCourses = $query->count();
        $publishedCourses = $query->where('is_published', true)->count();
        
        // Get enrollments for all courses (or instructor's courses if instructor_id exists)
        $courseIds = $query->pluck('id');
        $totalEnrollments = Enrollment::whereIn('course_id', $courseIds)->count();
        $activeEnrollments = Enrollment::whereIn('course_id', $courseIds)->whereNull('completed_at')->count();
        
        // Get modules and quizzes statistics
        $totalModules = Module::whereIn('course_id', $courseIds)->count();
        
        // Get quizzes count - need to join through lessons and modules
        $totalQuizzes = Quiz::whereHas('lesson.module', function($q) use ($courseIds) {
            $q->whereIn('course_id', $courseIds);
        })->count();
        
        $totalStudents = User::whereHas('classrooms', function($q) use ($classroomIds) {
            $q->whereIn('classrooms.id', $classroomIds);
        })->count();

        $recentCourses = Course::where('instructor_id', $user->id)
            ->with('modules.lessons')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get enrollment statistics by level
        $enrollmentsByLevel = Course::selectRaw('courses.level, COUNT(enrollments.id) as enrollment_count')
            ->leftJoin('enrollments', 'courses.id', '=', 'enrollments.course_id')
            ->groupBy('courses.level')
            ->get();

        // Calculate course performance metrics
        $baseQuery = Course::query();
        $highPerformanceCourses = $baseQuery->whereHas('enrollments', function($q) {
            $q->whereRaw('(SELECT COUNT(*) FROM enrollments e2 WHERE e2.course_id = enrollments.course_id AND e2.completed_at IS NOT NULL) / (SELECT COUNT(*) FROM enrollments e3 WHERE e3.course_id = enrollments.course_id) >= 0.8');
        })->count();
        
        $mediumPerformanceCourses = Course::whereHas('enrollments', function($q) {
            $q->whereRaw('(SELECT COUNT(*) FROM enrollments e2 WHERE e2.course_id = enrollments.course_id AND e2.completed_at IS NOT NULL) / (SELECT COUNT(*) FROM enrollments e3 WHERE e3.course_id = enrollments.course_id) BETWEEN 0.5 AND 0.79');
        })->count();
        
        $lowPerformanceCourses = Course::whereHas('enrollments', function($q) {
            $q->whereRaw('(SELECT COUNT(*) FROM enrollments e2 WHERE e2.course_id = enrollments.course_id AND e2.completed_at IS NOT NULL) / (SELECT COUNT(*) FROM enrollments e3 WHERE e3.course_id = enrollments.course_id) < 0.5');
        })->count();

        $totalTasks = Task::whereHas('lesson.module.course', function($q) use ($courseIds) {
            $q->whereIn('id', $courseIds);
        })->count();

        // --- ABSENSI HARI INI ---
        $today = now()->toDateString();

        // Absensi hari ini dari semua course milik instructor ini
        $todayAttendances = Attendance::where('instructor_id', $user->id)
            ->whereDate('attendance_date', $today)
            ->with(['student', 'course', 'classroom'])
            ->get();

        $todayPresent = $todayAttendances->where('status', 'present')->count();
        $todayAbsent  = $todayAttendances->where('status', 'absent')->count();
        $todaySick    = $todayAttendances->where('status', 'sick')->count();
        $todayTotal   = $todayAttendances->count();

        // Grup per kelas untuk ditampilkan di tabel
        $attendanceByClassroom = $todayAttendances
            ->groupBy('classroom_id')
            ->map(function($records) {
                $classroom = $records->first()->classroom;
                return [
                    'classroom'  => $classroom->name ?? '-',
                    'course'     => $records->first()->course->title ?? '-',
                    'present'    => $records->where('status', 'Present')->count(),
                    'absent'     => $records->where('status', 'Absent')->count(),
                    'sick'       => $records->where('status', 'Sick')->count(),
                    'total'      => $records->count(),
                    'students'   => $records, // detail per siswa
                ];
            })->values();

        // Absensi mingguan (7 hari terakhir) - untuk chart
        $weeklyAttendanceChart = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayAttendances = Attendance::where('instructor_id', $user->id)
                ->whereDate('attendance_date', $date->toDateString())
                ->get();

            $weeklyAttendanceChart->push([
                'day'     => $date->translatedFormat('D'), // Sen, Sel, dst
                'present' => $dayAttendances->where('status', 'present')->count(),
                'absent'  => $dayAttendances->where('status', 'absent')->count(),
                'sick'    => $dayAttendances->where('status', 'sick')->count(),
            ]);
        }

        // --- DATA GRAFIK TAMBAHAN ---

        // 1. GRAFIK TASK SUBMISSION per task (top 8)
        $taskSubmissionChart = Task::whereHas('lesson.module.course', function($q) use ($courseIds) {
                $q->whereIn('id', $courseIds);
            })
            ->withCount('submissions')
            ->orderBy('submissions_count', 'desc')
            ->limit(8)
            ->get()
            ->map(fn($task) => [
                'label'  => Str::limit($task->title, 25),
                'count'  => $task->submissions_count,
            ]);

        // 2. GRAFIK QUIZ ATTEMPTS per quiz (top 8)
        $quizAttemptChart = Quiz::whereHas('lesson.module', function($q) use ($courseIds) {
                $q->whereIn('course_id', $courseIds);
            })
            ->withCount('attempts')
            ->orderBy('attempts_count', 'desc')
            ->limit(8)
            ->get()
            ->map(fn($quiz) => [
                'label' => Str::limit($quiz->title, 25),
                'count' => $quiz->attempts_count,
            ]);

        // 3. GRAFIK LESSON PROGRESS — completed vs not per course
        $lessonProgressChart = Course::where('instructor_id', $user->id)
            ->with(['modules.lessons'])
            ->get()
            ->map(function($course) {
                $lessonIds = $course->modules->flatMap(fn($m) => $m->lessons)->pluck('id');
                $completed = LessonProgress::whereIn('lesson_id', $lessonIds)
                    ->where('is_completed', true)->count();
                $total = $lessonIds->count();
                return [
                    'label'       => Str::limit($course->title, 20),
                    'completed'   => $completed,
                    'incomplete'  => max(0, $total - $completed),
                ];
            })->filter(fn($c) => $c['completed'] + $c['incomplete'] > 0)->values();

        return view('dashboard.instructor', compact(
            'totalCourses',
            'publishedCourses',
            'totalEnrollments',
            'activeEnrollments',
            'totalModules',
            'totalQuizzes',
            'totalStudents',
            'recentCourses',
            'enrollmentsByLevel',
            'highPerformanceCourses',
            'mediumPerformanceCourses',
            'lowPerformanceCourses',
            'totalTasks',
            'todayAttendances', 'todayPresent', 'todayAbsent', 'todaySick',
            'todayTotal', 'attendanceByClassroom','taskSubmissionChart', 'quizAttemptChart', 'lessonProgressChart',
            'weeklyAttendanceChart',
        ));
    }

    /**
     * Display the dashboard for admins
     */
    public function admin()
    {
        // === STATISTIK EXISTING ===
        $totalCourses      = Course::count();
        $publishedCourses  = Course::where('is_published', true)->count();
        $totalEnrollments  = Enrollment::count();
        $activeEnrollments = Enrollment::whereNull('completed_at')->count();
        $totalModules      = Module::count();
        $totalQuizzes      = Quiz::count();
        $totalStudents     = User::whereHas('roles', fn($q) => $q->where('name', 'student'))->count();
        $totalInstructors  = User::whereHas('roles', fn($q) => $q->where('name', 'instructor'))->count();
        $totalClassrooms   = Classroom::count();
        $totalTasks        = Task::count();
        $totalTaskSubmissions = TaskSubmission::count();

        $coursesByLevel = Course::selectRaw('level, COUNT(*) as count')
            ->groupBy('level')->pluck('count', 'level')->toArray();

        $recentEnrollments = Enrollment::with(['user', 'course'])
            ->orderBy('created_at', 'desc')->limit(10)->get()
            ->map(fn($e) => [
                'description'  => 'Siswa dalam pelajaran',
                'user_name'    => $e->user->name,
                'course_title' => $e->course->title,
                'type'         => 'Proses',
                'created_at'   => $e->created_at->format('M d, Y'),
            ]);

        $recentActivity = collect($recentEnrollments);

        // === CHART 1: Enrollment per bulan (12 bulan terakhir) ===
        $monthlyEnrollments = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyEnrollments->push([
                'month' => $date->translatedFormat('M Y'),
                'count' => Enrollment::whereYear('created_at', $date->year)
                            ->whereMonth('created_at', $date->month)->count(),
            ]);
        }

        // === CHART 2: User growth — siswa baru per bulan ===
        $monthlyNewStudents = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyNewStudents->push([
                'month' => $date->translatedFormat('M Y'),
                'count' => User::whereHas('roles', fn($q) => $q->where('name', 'student'))
                            ->whereYear('created_at', $date->year)
                            ->whereMonth('created_at', $date->month)->count(),
            ]);
        }

        // === CHART 3: Task submission per bulan ===
        $monthlyTaskSubmissions = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyTaskSubmissions->push([
                'month' => $date->translatedFormat('M Y'),
                'count' => TaskSubmission::whereYear('created_at', $date->year)
                            ->whereMonth('created_at', $date->month)->count(),
            ]);
        }

        // === CHART 4: Quiz attempts per bulan ===
        $monthlyQuizAttempts = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyQuizAttempts->push([
                'month' => $date->translatedFormat('M Y'),
                'count' => QuizAttempt::whereYear('created_at', $date->year)
                            ->whereMonth('created_at', $date->month)->count(),
            ]);
        }

        // === CHART 5: Lesson progress — completed vs total per course (top 10) ===
        $lessonProgressChart = Course::with(['modules.lessons'])->limit(10)->get()
            ->map(function($course) {
                $lessonIds  = $course->modules->flatMap(fn($m) => $m->lessons)->pluck('id');
                $completed  = LessonProgress::whereIn('lesson_id', $lessonIds)->where('is_completed', true)->count();
                $total      = $lessonIds->count();
                return [
                    'label'      => Str::limit($course->title, 20),
                    'completed'  => $completed,
                    'incomplete' => max(0, $total - $completed),
                ];
            })->filter(fn($c) => $c['completed'] + $c['incomplete'] > 0)->values();

        // === CHART 6: Absensi platform-wide mingguan ===
        $weeklyAttendanceChart = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayAtt = Attendance::whereDate('attendance_date', $date->toDateString())->get();
            $weeklyAttendanceChart->push([
                'day'     => $date->translatedFormat('D'),
                'present' => $dayAtt->where('status', 'present')->count(),
                'absent'  => $dayAtt->where('status', 'absent')->count(),
                'sick'    => $dayAtt->where('status', 'sick')->count(),
            ]);
        }

        // === CHART 7: Top 8 course by enrollment ===
        $topCoursesByEnrollment = Course::withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->limit(8)->get()
            ->map(fn($c) => [
                'label' => Str::limit($c->title, 22),
                'count' => $c->enrollments_count,
            ]);

        // === CHART 8: Top 8 task by submission ===
        $taskSubmissionChart = Task::withCount('submissions')
            ->orderBy('submissions_count', 'desc')
            ->limit(8)->get()
            ->map(fn($t) => [
                'label' => Str::limit($t->title, 25),
                'count' => $t->submissions_count,
            ]);

        // === CHART 9: Quiz attempts per quiz (top 8) ===
        $quizAttemptChart = Quiz::withCount('attempts')
            ->orderBy('attempts_count', 'desc')
            ->limit(8)->get()
            ->map(fn($q) => [
                'label' => Str::limit($q->title, 25),
                'count' => $q->attempts_count,
            ]);

        // CHART 1: Progress pembelajaran per bulan (completed vs aktif)
        $monthlyEnrollments = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyEnrollments->push([
                'month'     => $date->translatedFormat('M Y'),
                'completed' => Enrollment::whereYear('completed_at', $date->year)
                                    ->whereMonth('completed_at', $date->month)->count(),
                'active'    => Enrollment::whereYear('created_at', $date->year)
                                    ->whereMonth('created_at', $date->month)
                                    ->whereNull('completed_at')->count(),
            ]);
        }

        // === SUMMARY ABSENSI HARI INI (platform-wide) ===
        $today          = now()->toDateString();
        $todayPresent   = Attendance::whereDate('attendance_date', $today)->where('status', 'present')->count();
        $todayAbsent    = Attendance::whereDate('attendance_date', $today)->where('status', 'absent')->count();
        $todaySick      = Attendance::whereDate('attendance_date', $today)->where('status', 'sick')->count();
        $todayTotal     = Attendance::whereDate('attendance_date', $today)->count();

        return view('dashboard.admin', compact(
            'totalCourses', 'publishedCourses', 'totalEnrollments', 'activeEnrollments',
            'totalModules', 'totalQuizzes', 'totalStudents', 'totalInstructors',
            'totalClassrooms', 'totalTasks', 'totalTaskSubmissions',
            'coursesByLevel', 'recentActivity',
            'monthlyEnrollments', 'monthlyNewStudents', 'monthlyTaskSubmissions',
            'monthlyQuizAttempts', 'lessonProgressChart', 'weeklyAttendanceChart',
            'topCoursesByEnrollment', 'taskSubmissionChart', 'quizAttemptChart',
            'todayPresent', 'todayAbsent', 'todaySick', 'todayTotal',
        ));
    }

    /**
     * Display the main dashboard based on user role
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->hasRole('admin')) {
            return $this->admin();
        } elseif ($user->hasRole('instructor')) {
            return $this->instructor();
        }
        
        return $this->student();
    }
}