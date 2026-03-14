<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Classroom;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Exports\AttendanceRecapExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;


class AttendanceController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            $groups = Attendance::select('course_id', 'attendance_date', 'classroom_id', 'instructor_id')
                ->with(['course', 'classroom', 'instructor'])
                ->groupBy('course_id', 'attendance_date', 'classroom_id', 'instructor_id')
                ->orderBy('attendance_date', 'desc')
                ->get();

            return view('attendance.index', compact('groups'));
        }

        $groups = Attendance::select('course_id', 'attendance_date', 'classroom_id', 'instructor_id')
            ->with(['course', 'classroom', 'instructor'])
            ->where('instructor_id', Auth::id())
            ->groupBy('course_id', 'attendance_date', 'classroom_id', 'instructor_id')
            ->orderBy('attendance_date', 'desc')
            ->get();

        $courses = Course::where('instructor_id', Auth::id())->with('classroom')->get();

        return view('attendance.index', compact('groups', 'courses'));
    }

    public function create(Request $request)
    {
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
        $attendances = Attendance::with(['student', 'instructor', 'classroom'])
            ->where('course_id', $course->id)
            ->where('attendance_date', $date)
            ->get();

        if ($attendances->isEmpty()) abort(404);

        if (!Auth::user()->hasRole('admin')) {
            if ($attendances->first()->instructor_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki akses melihat absensi ini.');
            }
        }

        return view('attendance.show', compact('attendances', 'course', 'date'));
    }

    public function edit(Request $request)
    {
        $courseId = $request->course;
        $date = $request->date;

        $attendances = Attendance::with('student')
            ->where('course_id', $courseId)
            ->where('attendance_date', $date)
            ->get();

        if ($attendances->isEmpty()) abort(404);

        // LOGIC BARU: Jika bukan admin, baru proteksi instructor
        if (!Auth::user()->hasRole('admin')) {
            $firstAttendance = $attendances->first();
            if ($firstAttendance->instructor_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki akses untuk mengubah absensi ini.');
            }
        }

        $course = Course::findOrFail($courseId);
        return view('attendance.edit', compact('attendances', 'course', 'date'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        if (!Auth::user()->hasRole('admin')) {
            if (Auth::user()->hasRole('instructor') && $attendance->instructor_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki otoritas untuk mengubah data ini.');
            }
        }

        $request->validate([
            'status' => 'required|in:present,sick,absent',
        ]);

        $attendance->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Absensi berhasil diperbarui oleh ' . Auth::user()->name);
    }

    public function updateGroup(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'attendance_date' => 'required|date',
            'attendances' => 'required|array'
        ]);

        $course = Course::findOrFail($request->course_id);

        // Proteksi Role
        if (!Auth::user()->hasRole('admin')) {
            if ($course->instructor_id !== Auth::id()) {
                abort(403);
            }
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
                    // Tetap gunakan instructor_id asli dari course agar data tidak "pindah tangan" ke Admin
                    'instructor_id' => $course->instructor_id, 
                    'status' => $status
                ]
            );
        }

        return redirect()->route('attendance.show', ['course' => $request->course_id, 'date' => $request->attendance_date])
                        ->with('success', 'Absensi berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'attendance_date' => 'required|date',
        ]);

        $query = Attendance::where('course_id', $request->course_id)
            ->where('classroom_id', $request->classroom_id)
            ->where('attendance_date', $request->attendance_date);

        if (!auth()->user()->hasRole('admin')) {
            $query->where('instructor_id', auth()->id());
        }

        $deleted = $query->delete();

        if ($deleted) {
            return redirect()->route('attendance.index')
                ->with('success', 'Seluruh data absensi pada grup tersebut berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Gagal menghapus data atau Anda tidak memiliki akses.');
    }


    public function recapForm()
    {
        if (Auth::user()->hasRole('admin')) {
            $courses = Course::with('classroom')->get();
        } else {
            $courses = Course::where('instructor_id', Auth::id())->with('classroom')->get();
        }

        return view('attendance.recap', compact('courses'));
    }

    public function exportRecap(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $course = Course::findOrFail($request->course_id);

        if (!Auth::user()->hasRole('admin')) {
            if ($course->instructor_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki akses untuk mengekspor data ini.');
            }
        }

        $fileName = 'Rekap_Absen_' . date('Ymd_His') . '.xlsx';

        return Excel::download(
            new AttendanceRecapExport($request->course_id, $request->start_date, $request->end_date), 
            $fileName
        );
    }
}
