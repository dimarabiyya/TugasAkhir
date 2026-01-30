<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Module;
use App\Http\Requests\LessonRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

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

        // ---------------------------------------------------
        // 1. LOGIKA FILTER ROLE (Hanya tampilkan milik sendiri)
        // ---------------------------------------------------
        if ($user->hasRole('instructor') && !$user->hasRole('admin')) {
            // Ambil Lesson hanya jika Module -> Course -> Instructor ID sama dengan User ID
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

        // ---------------------------------------------------
        // 2. LOGIKA PENCARIAN & FILTER LAINNYA
        // ---------------------------------------------------
        
        // Search functionality
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

        // Filter by module
        if ($request->filled('module_id')) {
            $query->where('module_id', $request->module_id);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // (Filter is_free dihapus/diabaikan dari controller ini jika sudah tidak dipakai di view)

        $lessons = $query->ordered()->paginate(15)->appends($request->query());
        $lessonTypes = ['video', 'reading', 'audio', 'interactive'];

        return view('lessons.index', compact('lessons', 'modules', 'lessonTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Module $module): View
    {
        $this->checkManagePermission();
        
        // KEAMANAN: Cek apakah instruktur memiliki module ini
        if (auth()->user()->hasRole('instructor') && !auth()->user()->hasRole('admin')) {
            if ($module->course->instructor_id !== auth()->id()) {
                abort(403, 'Unauthorized access to this module.');
            }
        }
        
        // Get the next order number for this module
        $nextOrder = $module->lessons()->max('order') + 1;
        $lessonTypes = ['video', 'reading', 'audio', 'interactive'];
        
        return view('lessons.create', compact('module', 'nextOrder', 'lessonTypes'));
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
        
        // SETTING MANUAL:
        $validated['module_id'] = $module->id;
        $validated['is_free'] = 1; 

        Lesson::create($validated);

        return redirect()
            ->route('modules.show', $module)
            ->with('success', 'Lesson created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson): View
    {
        // Cek akses lesson
        if (auth()->user()->hasRole('instructor') && !auth()->user()->hasRole('admin')) {
            if ($lesson->module->course->instructor_id !== auth()->id()) {
                abort(403, 'Unauthorized view.');
            }
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
        
        // SETTING MANUAL:
        // Kita paksa 0 agar update tidak error karena field hilang dari request
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
        if ($lesson->quiz) {
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