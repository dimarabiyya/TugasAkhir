<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Classroom;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        // Jika admin, tunjukkan grup absensi (group by course + date)
        if (Auth::user()->hasRole('admin')) {
            $groups = Attendance::select('course_id', 'attendance_date', 'classroom_id', 'instructor_id')
                ->with(['course', 'classroom', 'instructor'])
                ->groupBy('course_id', 'attendance_date', 'classroom_id', 'instructor_id')
                ->orderBy('attendance_date', 'desc')
                ->get();

            return view('attendance.index', compact('groups'));
        }

        // Untuk instruktur, tunjukkan grup absensi untuk mata pelajaran miliknya
        $groups = Attendance::select('course_id', 'attendance_date', 'classroom_id', 'instructor_id')
            ->with(['course', 'classroom', 'instructor'])
            ->where('instructor_id', Auth::id())
            ->groupBy('course_id', 'attendance_date', 'classroom_id', 'instructor_id')
            ->orderBy('attendance_date', 'desc')
            ->get();

        // Juga berikan daftar courses milik instruktur agar view tidak error ketika tidak ada grup
        $courses = Course::where('instructor_id', Auth::id())->with('classroom')->get();

        return view('attendance.index', compact('groups', 'courses'));
    }

    public function create(Request $request)
    {
        // Jika tidak ada course_id, tampilkan form pemilihan course (admin atau instructor)
        if (!$request->has('course_id')) {
            if (Auth::user()->hasRole('admin')) {
                $courses = Course::with('classroom')->get();
            } else {
                $courses = Course::where('instructor_id', Auth::id())->with('classroom')->get();
            }

            return view('attendance.select', compact('courses'));
        }

        $courseId = $request->course_id;
        $course = Course::findOrFail($courseId);

        // Ambil siswa yang terdaftar di kelas tersebut
        $classroom = Classroom::where('id', $course->classroom_id)->with('students')->first();
        $students = $classroom ? $classroom->students()->role('student')->get() : collect();

        $attendanceDate = $request->attendance_date ?? date('Y-m-d');

        return view('attendance.create', compact('students', 'course', 'attendanceDate'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required',
            'attendance_date' => 'required|date',
            'attendances' => 'required|array'
        ]);

        foreach ($request->attendances as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'classroom_id' => $request->classroom_id,
                    'course_id' => $request->course_id,
                    'student_id' => $studentId,
                    'attendance_date' => $request->attendance_date,
                ],
                [
                    'instructor_id' => Auth::id(),
                    'status' => $status
                ]
            );
        }

        return redirect()->route('attendance.index')->with('success', 'Absensi berhasil disimpan.');
    }

    public function show(Course $course, $date)
    {
        // Ambil semua record absensi untuk course + date
        $attendances = Attendance::with(['student', 'instructor', 'classroom'])
            ->where('course_id', $course->id)
            ->where('attendance_date', $date)
            ->get();

        // Permission: admin can view all, instructor only their own course's records
        if (Auth::user()->hasRole('instructor')) {
            if ($attendances->isEmpty() || $attendances->first()->instructor_id !== Auth::id()) {
                abort(403);
            }
        }

        return view('attendance.show', compact('attendances', 'course', 'date'));
    }

    public function edit(Attendance $attendance)
    {
        // Admin can edit any; instructor can edit only their own
        if (Auth::user()->hasRole('instructor') && $attendance->instructor_id !== Auth::id()) {
            abort(403);
        }

        return view('attendance.edit', compact('attendance'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        // Admin can update any; instructor only their own
        if (Auth::user()->hasRole('instructor') && $attendance->instructor_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:present,sick,absent',
        ]);

        $attendance->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Absensi diperbarui.');
    }

    public function updateGroup(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'attendance_date' => 'required|date',
            'attendances' => 'required|array'
        ]);

        $course = Course::findOrFail($request->course_id);

        // Permission: admin can update any; instructor only their own course
        if (Auth::user()->hasRole('instructor') && $course->instructor_id !== Auth::id()) {
            abort(403);
        }

        foreach ($request->attendances as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'classroom_id' => $request->classroom_id,
                    'course_id' => $request->course_id,
                    'student_id' => $studentId,
                    'attendance_date' => $request->attendance_date,
                ],
                [
                    'instructor_id' => Auth::id(),
                    'status' => $status
                ]
            );
        }

        return redirect()->route('attendance.show', ['course' => $request->course_id, 'date' => $request->attendance_date])->with('success', 'Absensi diperbarui.');
    }
}
