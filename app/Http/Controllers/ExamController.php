<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Course;
use App\Models\Classroom;
use App\Models\Question;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\ExamReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ExamController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('student')) {
            $exams = Exam::with(['course', 'classrooms'])
                ->whereHas('classrooms', function($query) use ($user) {
                    $query->whereHas('students', function($q) use ($user) {
                        $q->where('user_id', $user->id);
                    });
                })
                ->where('is_active', true)
                ->where('end_time', '>', now()) 
                ->latest()
                ->get();

            return view('exams.show', compact('exams'));
        }

        if ($user->hasRole('admin')) {
            $exams = Exam::with(['course', 'classrooms'])->latest()->get();
        } else {
            $exams = Exam::with(['course', 'classrooms'])
                ->whereHas('course', function($query) use ($user) {
                    $query->where('instructor_id', $user->id);
                })->latest()->get();
        }

        return view('exams.index', compact('exams'));
    }

    public function start(Exam $exam)
    {
        $user = auth()->user();

        $isEligible = $exam->classrooms()
            ->whereHas('students', fn($q) => $q->where('user_id', $user->id))
            ->exists();

        if (!$isEligible) {
            abort(403, 'Anda tidak terdaftar untuk ujian ini.');
        }

        if (now() < $exam->start_time || now() > $exam->end_time) {
            return redirect()->route('exams.index')->with('error', 'Ujian belum tersedia atau sudah berakhir.');
        }

        $attempt = ExamAttempt::firstOrCreate([
            'exam_id' => $exam->id,
            'user_id' => $user->id,
        ], [
            'started_at' => now(),
            'cheat_attempts' => 0,
            'answers' => [], 
        ]);

        if ($attempt->submitted_at) {
            return redirect()->route('exams.index')->with('error', 'Anda sudah mengumpulkan ujian ini.');
        }

        // Mengarah ke resources/views/exams/start.blade.php
        return view('exams.start', compact('exam', 'attempt'));
    }

    public function saveProgress(Request $request, Exam $exam)
    {
        $attempt = ExamAttempt::where('exam_id', $exam->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($attempt && !$attempt->submitted_at) {
            $answers = $attempt->answers ?? [];
            $answers[$request->question_id] = $request->answer;
            
            $attempt->update(['answers' => $answers]);
            return response()->json(['status' => 'success']);
        }
        
        return response()->json(['status' => 'error'], 403);
    }

    public function submit(Request $request, Exam $exam)
    {
        $attempt = ExamAttempt::where('exam_id', $exam->id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (!$attempt->submitted_at) {
            $attempt->submitted_at = now();
            $attempt->save();
            
            $attempt->calculateScore();
        }

        $startTime = $attempt->started_at;
        $duration = $exam->duration * 60;   
        $now = now();

        if ($now->diffInSeconds($startTime) > ($duration + 30)) {
            $attempt->update(['score' => 0, 'status' => 'cheating']);
        }

        return redirect()->route('exams.result', $exam->id)->with('success', 'Ujian telah dikumpulkan.');
    }

    public function result(Exam $exam)
    {
        $user = auth()->user();

        // Ambil data attempt siswa untuk ujian ini
        $attempt = ExamAttempt::where('exam_id', $exam->id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Pastikan siswa sudah submit, jika belum jangan kasih lihat hasil
        if (!$attempt->submitted_at) {
            return redirect()->route('exams.start', $exam->id);
        }

        return view('exams.result', compact('exam', 'attempt'));
    }

    public function storeQuestion(Request $request, Exam $exam)
    {
        $request->validate([
            'question_text' => 'required',
            'options.A' => 'required',
            'options.B' => 'required',
            'correct_answer' => 'required',
        ]);

        $exam->questions()->create([
            'question_text' => $request->question_text,
            'options' => $request->options,
            'correct_answer' => $request->correct_answer,
        ]);

        return back()->with('success', 'Soal berhasil ditambahkan!');
    }

    public function create()
    {
        if (auth()->user()->hasRole('student')) abort(403, 'Akses Dilarang');
        $user = auth()->user();
        $courses = Course::where('instructor_id', $user->id)->get();
        $classrooms = Classroom::where('instructor_id', $user->id)->get();
        return view('exams.create', compact('courses', 'classrooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'classroom_ids' => 'required|array',
        ]);

        $exam = Exam::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'instructions' => $request->instructions,
            'duration' => $request->duration,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        $exam->classrooms()->attach($request->classroom_ids);

        return redirect()->route('exams.index')->with('success', 'Ujian berhasil dibuat. Silahkan tambahkan soal.');
    }

        public function edit(Exam $exam)
    {
        $user = auth()->user();

        if ($user->id !== $exam->course->instructor_id && !$user->hasRole('admin')) {
            abort(403);
        }

        $courses = Course::where('instructor_id', $user->id)->get();
        $classrooms = Classroom::where('instructor_id', $user->id)->get();
        $questions = $exam->questions;

        return view('exams.edit', compact('exam', 'courses', 'classrooms', 'questions'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'title' => 'required',
            'duration' => 'required|integer',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'classroom_ids' => 'required|array',
        ]);

        $exam->update($request->only(['title', 'instructions', 'duration', 'start_time', 'end_time']));
        $exam->classrooms()->sync($request->classroom_ids);

        return redirect()->route('exams.index')->with('success', 'Ujian berhasil diperbarui.');
    }

    public function report(Exam $exam)
    {
        $user = auth()->user();

        if (!$user->hasRole('admin') && $exam->course->instructor_id !== $user->id) {
            abort(403);
        }

        $classrooms = $exam->classrooms()->with(['students' => function($query) use ($exam) {
            $query->with(['examAttempts' => function($q) use ($exam) {
                $q->where('exam_id', $exam->id);
            }]);
        }])->get();

        return view('exams.report', compact('exam', 'classrooms'));
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('exams.index')->with('success', 'Ujian telah dihapus.');
    }

    public function destroyQuestion(Exam $exam, Question $question)
    {
        $question->delete();
        return back()->with('success', 'Soal berhasil dihapus.');
    }

    public function exportExcel(Exam $exam, Classroom $classroom)
    {
        $fileName = 'Nilai_' . $exam->title . '_' . $classroom->name . '.xlsx';
        
        return Excel::download(
            new ExamReportExport($exam, $classroom), 
            $fileName
        );
    }

    public function logCheat(Exam $exam)
    {
        $attempt = ExamAttempt::where('exam_id', $exam->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($attempt && !$attempt->submitted_at) {
            $attempt->increment('cheat_attempts');
            
            return response()->json([
                'current_attempts' => $attempt->cheat_attempts,
                'max_limit' => 2
            ]);
        }
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
