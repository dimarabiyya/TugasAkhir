<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Course;
use App\Http\Requests\ModuleRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        
        // Mulai query dengan eager loading
        $query = Module::with(['course', 'lessons']);

        // -----------------------------------------------------------
        // LOGIKA FILTER ROLE (Baru Ditambahkan)
        // -----------------------------------------------------------
        
        // Cek jika user adalah Instructor DAN BUKAN Admin
        if ($user->hasRole('instructor') && !$user->hasRole('admin')) {
            
            // 1. Filter MODULES: 
            // Ambil module HANYA jika course-nya memiliki instructor_id = user yang login
            $query->whereHas('course', function($q) use ($user) {
                $q->where('instructor_id', $user->id);
            });

            // 2. Filter DROPDOWN COURSES:
            // List course untuk filter di view hanya course milik instruktur tersebut
            $courses = Course::select('id', 'title')
                             ->where('instructor_id', $user->id)
                             ->get();
                             
        } else {
            // Jika Admin, ambil semua course untuk dropdown
            $courses = Course::select('id', 'title')->get();
        }

        // -----------------------------------------------------------
        // END LOGIKA FILTER ROLE
        // -----------------------------------------------------------

        // Search functionality (Tetap sama)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('course', function($courseQuery) use ($searchTerm) {
                      $courseQuery->where('title', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        // Filter by specific course (Tetap sama)
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Pagination & Ordering
        // Pastikan scopeOrdered() ada di Model Module, jika tidak ganti jadi orderBy('order')
        $modules = $query->ordered()->paginate(15)->appends($request->query());

        return view('modules.index', compact('modules', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course): View
    {
        $this->checkManagePermission();
        
        // TAMBAHAN KEAMANAN (Opsional tapi disarankan):
        // Pastikan instruktur tidak bisa create modul untuk course orang lain lewat URL
        if (auth()->user()->hasRole('instructor') && !auth()->user()->hasRole('admin')) {
            if ($course->instructor_id !== auth()->id()) {
                abort(403, 'Unauthorized access to this course.');
            }
        }
        
        // Get the next order number for this course
        $nextOrder = $course->modules()->max('order') + 1;
        
        return view('modules.create', compact('course', 'nextOrder'));
    }

    // ... (Method store, show, edit, update, destroy biarkan sama) ...
    // Note: Untuk edit, update, destroy sebaiknya juga ditambahkan 
    // pengecekan instructor_id seperti di create() di atas agar lebih aman.

    public function store(ModuleRequest $request, Course $course): RedirectResponse
    {
        // Validasi kepemilikan course
        if (auth()->user()->hasRole('instructor') && !auth()->user()->hasRole('admin')) {
            if ($course->instructor_id !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }
        }

        $validated = $request->validated();
        $validated['course_id'] = $course->id;

        Module::create($validated);

        return redirect()
            ->route('courses.show', $course)
            ->with('success', 'Module created successfully.');
    }

    public function show(Module $module): View
    {
        $module->load(['course', 'lessons' => function($query) {
            $query->orderBy('order');
        }]);

        return view('modules.show', compact('module'));
    }

    public function edit(Module $module): View
    {
        $this->checkManagePermission();
        
        // Validasi kepemilikan
        if (auth()->user()->hasRole('instructor') && !auth()->user()->hasRole('admin')) {
            if ($module->course->instructor_id !== auth()->id()) {
                abort(403, 'Unauthorized access.');
            }
        }
        
        $module->load('course');
        
        return view('modules.edit', compact('module'));
    }

    public function update(ModuleRequest $request, Module $module): RedirectResponse
    {
        // Validasi kepemilikan sebelum update
        if (auth()->user()->hasRole('instructor') && !auth()->user()->hasRole('admin')) {
            if ($module->course->instructor_id !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }
        }

        $validated = $request->validated();
        $module->update($validated);

        return redirect()
            ->route('modules.show', $module)
            ->with('success', 'Module updated successfully.');
    }

    public function destroy(Module $module): RedirectResponse
    {
        $this->checkManagePermission();
        
        // Validasi kepemilikan sebelum hapus
        if (auth()->user()->hasRole('instructor') && !auth()->user()->hasRole('admin')) {
            if ($module->course->instructor_id !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }
        }
        
        $course = $module->course;
        
        if ($module->lessons()->count() > 0) {
            return redirect()
                ->route('modules.show', $module)
                ->with('error', 'Cannot delete module with existing lessons. Please delete all lessons first.');
        }

        $module->delete();

        return redirect()
            ->route('courses.show', $course)
            ->with('success', 'Module deleted successfully.');
    }

    private function checkManagePermission(): void
    {
        if (!auth()->user()->hasAnyRole(['admin', 'instructor'])) {
            abort(403, 'You do not have permission to manage modules.');
        }
    }
}