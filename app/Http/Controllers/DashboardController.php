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

        return view('dashboard.student', compact(
            'enrolledCourses', 'recentProgress', 'recentQuizAttempts', 'overallProgress',
            'totalEnrolledCourses', 'completedCourses', 'activeCourses', 'totalLessons',
            'completedLessonsCount', 'totalQuizAttempts', 'passedQuizzes', 'failedQuizzes',
            'averageScore', 'courseProgress', 'weeklyProgress'
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
            'lowPerformanceCourses'
        ));
    }

    /**
     * Display the dashboard for admins
     */
    public function admin()
    {
        // Get platform-wide statistics
        $totalCourses = Course::count();
        $publishedCourses = Course::where('is_published', true)->count();
        $totalEnrollments = Enrollment::count();
        $activeEnrollments = Enrollment::whereNull('completed_at')->count();
        
        // Get modules and quizzes statistics
        $totalModules = Module::count();
        $totalQuizzes = Quiz::count();
        $totalStudents = User::whereHas('roles', function($query) {
            $query->where('name', 'student');
        })->count();

        // Get courses by level
        $coursesByLevel = Course::selectRaw('level, COUNT(*) as count')
            ->groupBy('level')
            ->pluck('count', 'level')
            ->toArray();

        // Get recent platform activity
        $recentActivity = collect();
        
        // Recent enrollments
        $recentEnrollments = Enrollment::with(['user', 'course'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function($enrollment) {
                return [
                    'description' => 'Enrolled in course',
                    'user_name' => $enrollment->user->name,
                    'course_title' => $enrollment->course->title,
                    'type' => 'enrollment',
                    'created_at' => $enrollment->created_at->format('M d, Y')
                ];
            });
        
        $recentActivity = $recentActivity->merge($recentEnrollments);

        return view('dashboard.admin', compact(
            'totalCourses',
            'publishedCourses',
            'totalEnrollments',
            'activeEnrollments',
            'totalModules',
            'totalQuizzes',
            'totalStudents',
            'coursesByLevel',
            'recentActivity'
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
