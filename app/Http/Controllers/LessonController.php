<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Module;
use App\Http\Requests\LessonRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\LessonProgress;
use App\Models\Enrollment;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        
        // Mulai query dengan eager loading
        $query = Lesson::with(['module.course']);

        if ($user->hasRole('instructor') && !$user->hasRole('admin')) {
            $query->whereHas('module.course', function($q) use ($user) {
                $q->where('instructor_id', $user->id);
            });

            // Filter dropdown Modules (hanya module milik instruktur ini)
            $modules = Module::with('course')
                ->whereHas('course', function($q) use ($user) {
                    $q->where('instructor_id', $user->id);
                })->get();
        } else {
            // Admin melihat semua module
            $modules = Module::with('course')->get();
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('module', function($moduleQuery) use ($searchTerm) {
                      $moduleQuery->where('title', 'like', '%' . $searchTerm . '%')
                                  ->orWhereHas('course', function($courseQuery) use ($searchTerm) {
                                      $courseQuery->where('title', 'like', '%' . $searchTerm . '%');
                                  });
                  });
            });
        }

        if ($request->filled('module_id')) {
            $query->where('module_id', $request->module_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $lessons = $query->ordered()->paginate(15)->appends($request->query());
        $lessonTypes = ['video', 'reading', 'audio', 'interactive'];

        return view('lessons.index', compact('lessons', 'modules', 'lessonTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Module $module)
    {
        $this->checkManagePermission();

        return view('lessons.create', compact('module'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LessonRequest $request, Module $module): RedirectResponse
    {
        // KEAMANAN: Cek kepemilikan module
        if (auth()->user()->hasRole('instructor') && !auth()->user()->hasRole('admin')) {
            if ($module->course->instructor_id !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }
        }

        $validated = $request->validated();
        
        // LOGIKA OTOMATIS: Jika durasi kosong, isi dengan 30
        if (empty($validated['duration_minutes'])) {
            $validated['duration_minutes'] = 30;
        }

        // SETTING MANUAL:
        $validated['module_id'] = $module->id;
        $validated['is_free'] = 1; 

        Lesson::create($validated);

        return redirect()
            ->route('modules.show', $module)
            ->with('success', 'Lesson created successfully.');
    }

    public function show(Lesson $lesson): View
    {
        if (auth()->user()->hasRole('instructor') && !auth()->user()->hasRole('admin')) {
            if ($lesson->module->course->instructor_id !== auth()->id()) {
                abort(403, 'Unauthorized view.');
            }
        }

        // Hanya untuk student
        if (auth()->user()->hasRole('student')) {

            LessonProgress::firstOrCreate([
                'lesson_id' => $lesson->id,
                'user_id' => auth()->id(),
            ], [
                'is_completed' => true
            ]);

            // Update progress enrollment
            $course = $lesson->module->course;

            $totalLessons = Lesson::whereHas('module', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })->count();
            $completedLessons = LessonProgress::where('user_id', auth()->id())
                ->whereHas('lesson.module', function ($query) use ($course) {
                    $query->where('course_id', $course->id);
                })
                ->count();

            $percentage = $totalLessons > 0 
                ? round(($completedLessons / $totalLessons) * 100) 
                : 0;

            Enrollment::where('user_id', auth()->id())
                ->where('course_id', $course->id)
                ->update([
                    'progress_percentage' => $percentage,
                    'completed_at' => $percentage == 100 ? now() : null
                ]);
        }

        $lesson->load(['module.course', 'quiz', 'lessonProgress' => function($query) {
            $query->where('user_id', auth()->id());
        }]);

        return view('lessons.show', compact('lesson'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson): View
    {
        $this->checkManagePermission();

        // KEAMANAN
        if (auth()->user()->hasRole('instructor') && !auth()->user()->hasRole('admin')) {
            if ($lesson->module->course->instructor_id !== auth()->id()) {
                abort(403, 'Unauthorized access.');
            }
        }
        
        $lesson->load('module.course');
        $lessonTypes = ['video', 'reading', 'audio', 'interactive'];
        
        return view('lessons.edit', compact('lesson', 'lessonTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LessonRequest $request, Lesson $lesson): RedirectResponse
    {
        // KEAMANAN
        if (auth()->user()->hasRole('instructor') && !auth()->user()->hasRole('admin')) {
            if ($lesson->module->course->instructor_id !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }
        }

       $validated = $request->validated();
    
        // LOGIKA OTOMATIS: Tambahkan juga di fungsi update agar aman
        if (empty($validated['duration_minutes'])) {
            $validated['duration_minutes'] = 30;
        }
        
        $validated['is_free'] = 0; 

        $lesson->update($validated);

        return redirect()
            ->route('lessons.show', $lesson)
            ->with('success', 'Lesson updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson): RedirectResponse
    {
        $this->checkManagePermission();

        // KEAMANAN
        if (auth()->user()->hasRole('instructor') && !auth()->user()->hasRole('admin')) {
            if ($lesson->module->course->instructor_id !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }
        }
        
        $module = $lesson->module;
        
        // Check if lesson has quiz
        if ($lesson->quiz()->exists()) {
            return redirect()
                ->route('lessons.show', $lesson)
                ->with('error', 'Cannot delete lesson with existing quiz. Please delete the quiz first.');
        }

        $lesson->delete();

        return redirect()
            ->route('modules.show', $module)
            ->with('success', 'Lesson deleted successfully.');
    }

    /**
     * Check if user has permission to manage lessons
     */
    private function checkManagePermission(): void
    {
        if (!auth()->user()->hasAnyRole(['admin', 'instructor'])) {
            abort(403, 'You do not have permission to manage lessons.');
        }
    }
}