<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Exports\QuizGradeExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    /**
     * Check if user has permission to manage quizzes
     */
    private function checkManagePermission()
    {
        if (!auth()->user()->hasAnyRole(['admin', 'instructor'])) {
            abort(403, 'Hanya admin dan Guru yang dapat mengelola quiz.');
        }
    }

    public function index()
    {
        $user = auth()->user();

        $query = Quiz::with([
            'lesson.module.course.classroom',
            'questions',
            'attempts'
        ]);

        // =====================
        // STUDENT
        // =====================
        if ($user->hasRole('student')) {
            $query->where('status', 'published')
                ->whereHas(
                    'lesson.module.course.classroom.students',
                    function ($q) use ($user) {
                        $q->where('users.id', $user->id);
                    }
                );
        }

        // =====================
        // INSTRUCTOR
        // =====================
        elseif ($user->hasRole('instructor')) {
            $query->whereHas('lesson.module.course', function ($q) use ($user) {
                $q->where('instructor_id', $user->id);
            });
        }

        // ADMIN → tanpa filter

        $quizzes = $query->latest()->paginate(10);

        return view('quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Lesson $lesson)
    {
        $this->checkManagePermission();
        return view('quizzes.create', compact('lesson'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Lesson $lesson)
    {
        $this->checkManagePermission();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'passing_score' => 'required|numeric|min:0|max:100',
            'time_limit_minutes' => 'nullable|numeric|min:1',
            'instructions' => 'nullable|string',
            'allow_multiple_attempts' => 'boolean',
            'max_attempts' => 'nullable|integer|min:1',
            'shuffle_questions' => 'boolean',
            'shuffle_answers' => 'boolean',
            'show_correct_answers' => 'boolean',
            'show_results_immediately' => 'boolean',
            'questions_per_page' => 'nullable|integer|min:1',
            'allow_navigation' => 'boolean',
            'negative_marking' => 'boolean',
            'negative_mark_value' => 'nullable|numeric|min:0|max:1',
            'status' => 'required|in:draft,published,archived',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'random_question_count' => 'nullable|integer|min:1',
            'require_all_questions' => 'boolean',
            'pass_message' => 'nullable|string',
            'fail_message' => 'nullable|string',
        ]);

        // Set default values for checkboxes if not present
        $validated['allow_multiple_attempts'] = $validated['allow_multiple_attempts'] ?? true;
        $validated['shuffle_questions'] = $validated['shuffle_questions'] ?? false;
        $validated['shuffle_answers'] = $validated['shuffle_answers'] ?? false;
        $validated['show_correct_answers'] = $validated['show_correct_answers'] ?? false;
        $validated['show_results_immediately'] = $validated['show_results_immediately'] ?? true;
        $validated['allow_navigation'] = $validated['allow_navigation'] ?? true;
        $validated['negative_marking'] = $validated['negative_marking'] ?? false;
        $validated['require_all_questions'] = $validated['require_all_questions'] ?? false;
        
        $validated['lesson_id'] = $lesson->id;
        
        Quiz::create($validated);

        return redirect()->route('quizzes.index')
            ->with('success', 'Quiz created successfully.');
    }

    /**
     * Display the public detail page for quiz
     */
    public function detail(Quiz $quiz, $slug = null)
    {
        // Load quiz with all relationships
        $quiz->load(['lesson.module.course', 'questions']);
        
        return view('quizzes.detail', compact('quiz'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz, $slug = null)
    {
        if ($slug !== $quiz->slug) {
            return redirect()->route('quizzes.show', [
                'quiz' => $quiz->id,
                'slug' => $quiz->slug
            ]);
        }

        $quiz->load([
            'lesson.module.course',
            'questions',
            'attempts.user'
        ]);

        $userAttempts = null;
        $bestAttempt = null;

        if (auth()->check() && !auth()->user()->hasAnyRole(['admin', 'instructor'])) {
            $userAttempts = auth()->user()->quizAttempts()
                ->where('quiz_id', $quiz->id)
                ->latest()
                ->get();

            $bestAttempt = auth()->user()->quizAttempts()
                ->where('quiz_id', $quiz->id)
                ->where('submitted', true)
                ->orderByDesc('score')
                ->first();
        }

        return view('quizzes.show', compact(
            'quiz',
            'userAttempts',
            'bestAttempt'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
    {
        $this->checkManagePermission();
        $quiz->load('lesson.module.course');
        
        return view('quizzes.edit', compact('quiz'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        $this->checkManagePermission();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'passing_score' => 'required|numeric|min:0|max:100',
            'time_limit_minutes' => 'nullable|numeric|min:1',
            'instructions' => 'nullable|string',
            'allow_multiple_attempts' => 'boolean',
            'max_attempts' => 'nullable|integer|min:1',
            'shuffle_questions' => 'boolean',
            'shuffle_answers' => 'boolean',
            'show_correct_answers' => 'boolean',
            'show_results_immediately' => 'boolean',
            'questions_per_page' => 'nullable|integer|min:1',
            'allow_navigation' => 'boolean',
            'negative_marking' => 'boolean',
            'negative_mark_value' => 'nullable|numeric|min:0|max:1',
            'status' => 'required|in:draft,published,archived',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'random_question_count' => 'nullable|integer|min:1',
            'require_all_questions' => 'boolean',
            'pass_message' => 'nullable|string',
            'fail_message' => 'nullable|string',
        ]);

        // Ensure boolean fields are set properly (checkboxes)
        $validated['allow_multiple_attempts'] = isset($validated['allow_multiple_attempts']);
        $validated['shuffle_questions'] = isset($validated['shuffle_questions']);
        $validated['shuffle_answers'] = isset($validated['shuffle_answers']);
        $validated['show_correct_answers'] = isset($validated['show_correct_answers']);
        $validated['show_results_immediately'] = isset($validated['show_results_immediately']);
        $validated['allow_navigation'] = isset($validated['allow_navigation']);
        $validated['negative_marking'] = isset($validated['negative_marking']);
        $validated['require_all_questions'] = isset($validated['require_all_questions']);

        $quiz->update($validated);

        return redirect()->route('quizzes.index')
            ->with('success', 'Quiz updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        $this->checkManagePermission();
        $quiz->delete();

        return redirect()->route('quizzes.index')
            ->with('success', 'Kuis berhasil di hapus!.');
    }

    public function exportExcel($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $user = auth()->user();

        // Proteksi akses
        if (!$user->hasRole('admin')) {
            $canAccess = ($quiz->lesson->module->course->instructor_id == $user->id);
            if (!$canAccess) {
                abort(403, 'Anda tidak memiliki izin untuk mengekspor nilai quiz ini.');
            }
        }

        $fileName = 'Nilai_Quiz_' . Str::slug($quiz->title) . '_' . date('Ymd_His') . '.xlsx';

        return Excel::download(new QuizGradeExport($quizId), $fileName);
    }
    
}
