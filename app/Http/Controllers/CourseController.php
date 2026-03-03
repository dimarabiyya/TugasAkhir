<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Course::with(['modules.lessons', 'instructor', 'classroom']);

        /*
        |--------------------------------------------------------------------------
        | FILTER BERDASARKAN ROLE
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('admin')) {
            // Admin bisa lihat semua
        }

        elseif ($user->hasRole('instructor')) {
            // Instructor hanya lihat course miliknya
            $query->where('instructor_id', $user->id);
        }

        elseif ($user->hasRole('student')) {

            // Ambil classroom tempat student terdaftar
            $classroomIds = $user->classrooms()->pluck('classrooms.id');

            // Kalau student belum punya classroom → tampilkan kosong tapi tetap pagination aman
            if ($classroomIds->isEmpty()) {
                $courses = collect();
                return view('courses.index', compact('courses'));
            }

            $query->whereIn('classroom_id', $classroomIds);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER LEVEL
        |--------------------------------------------------------------------------
        */

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS PUBLISH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('published')) {
            $query->where('is_published', $request->published);
        }

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $courses = $query->latest()
                        ->paginate(12)
                        ->withQueryString(); // supaya filter tidak hilang saat pindah page

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $this->checkManagePermission();
        
        $classrooms = Classroom::all();

        $instructors = \App\Models\User::whereHas('roles', function($q) {
            $q->where('name', 'instructor');
        })->orderBy('name')->get();
        
        return view('courses.create', compact('classrooms', 'instructors'));
    }

    public function store(Request $request)
    {
        $this->checkManagePermission();
        
        // 1. Hapus 'price' dari validasi
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:beginner,intermediate,advanced',
            'classroom_id' => 'required|exists:classrooms,id',
            'duration_hours' => 'required|integer|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'instructor_id' => 'nullable|exists:users,id',
        ]);

        $data = $request->all();

        // 2. Set default price jadi 0 secara manual
        $data['price'] = 0;

        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('course-thumbnails', $filename, 'public');
            $data['thumbnail'] = $path;
        }

        if (auth()->user()->hasRole('instructor') && !auth()->user()->hasRole('admin')) {
            if (empty($data['instructor_id'])) {
                $data['instructor_id'] = auth()->id();
            }
        }

        Course::create($data);

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    // Method detail & show tidak perlu diubah signifikan
    public function detail(Course $course, $slug = null)
    {
        $course->load(['modules.lessons', 'modules.lessons.quiz', 'enrollments', 'instructor']);
        return view('courses.detail', compact('course'));
    }

    public function show(Course $course, $slug = null)
    {
        $user = Auth::user();

        // --- PROTEKSI AKSES (Agar tidak bisa nembak ID lewat URL) ---
        if ($user->hasRole('student')) {
            $myClassrooms = $user->classrooms()->pluck('classrooms.id')->toArray();
            if (!in_array($course->classroom_id, $myClassrooms)) {
                abort(403, 'Anda tidak terdaftar di kelas untuk modul ini.');
            }
        } 
        elseif ($user->hasRole('instructor') && !$user->hasRole('admin')) {
            // Pastikan instruktur memang mengajar di kelas tersebut
            $isInstructorInClass = Course::where('classroom_id', $course->classroom_id)
                                         ->where('instructor_id', $user->id)
                                         ->exists();
            if (!$isInstructorInClass) {
                abort(403, 'Anda tidak memiliki akses ke kelas ini.');
            }
        }

        if ($slug && $slug !== $course->slug) {
            return redirect()->route('courses.show', ['course' => $course->id, 'slug' => $course->slug]);
        }
        
        $course->load(['modules.lessons', 'modules.lessons.quiz', 'enrollments', 'instructor']);
        
        $isEnrolled = $user->enrollments()->where('course_id', $course->id)->exists();
        $enrollment = $user->enrollments()->where('course_id', $course->id)->first();
        
        return view('courses.show', compact('course', 'isEnrolled', 'enrollment'));
    }

    public function edit(Course $course)
    {
        $this->checkManagePermission();
        
        $instructors = \App\Models\User::whereHas('roles', function($q) {
        $q->where('name', 'instructor');
        })->orderBy('name')->get();

        $classrooms = Classroom::all();
        return view('courses.edit', compact('course', 'classrooms', 'instructors'));
    }

    public function update(Request $request, Course $course)
    {
        $this->checkManagePermission();
        
        // 1. Hapus 'price' dari validasi
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:beginner,intermediate,advanced',
            'classroom_id' => 'required|exists:classrooms,id',
            'duration_hours' => 'required|integer|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'instructor_id' => 'nullable|exists:users,id',
        ]);

        $data = $request->all();

        // 2. Pastikan price tetap 0 atau ambil nilai lama jika tidak diubah (untuk keamanan)
        $data['price'] = 0;

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }

            $image = $request->file('thumbnail');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('course-thumbnails', $filename, 'public');
            $data['thumbnail'] = $path;
        }

        if (auth()->user()->hasRole('instructor') && !auth()->user()->hasRole('admin')) {
            if (empty($data['instructor_id'])) {
                $data['instructor_id'] = auth()->id();
            }
        }

        $course->update($data);

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $this->checkManagePermission();
        
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    public function togglePublished(Course $course)
    {
        $this->checkManagePermission();
        $course->update(['is_published' => !$course->is_published]);
        return redirect()->back()
            ->with('success', 'Course status updated successfully.');
    }

    private function checkManagePermission()
    {
        if (!auth()->check() || !auth()->user()->hasAnyRole(['admin', 'instructor'])) {
            abort(403, 'Only admins and instructors can manage courses.');
        }
    }
}