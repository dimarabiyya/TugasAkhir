<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Lesson;
use App\Models\TaskSubmission;
use App\Models\TaskGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Menampilkan daftar tugas berdasarkan Classroom user
     */
    public function index()
    {
        $user = auth()->user();
        $query = Task::with(['lesson.module.course.classroom']);

        if ($user->hasRole('admin')) {
            // Admin: Lihat semua
            $tasks = $query->latest()->get();
        } 
        elseif ($user->hasRole('instructor')) {
            // Instructor: Filter berdasarkan instructor_id di tabel courses
            $tasks = $query->whereHas('lesson.module.course', function($q) use ($user) {
                $q->where('instructor_id', $user->id);
            })->latest()->get();
        } 
        else {
            // STUDENT: Filter berdasarkan classroom_id yang ada di tabel pivot 'classroom_user'
            $studentClassroomIds = $user->classrooms()->pluck('classrooms.id'); // Ambil semua ID kelas student

            $tasks = $query->whereHas('lesson.module.course', function($q) use ($studentClassroomIds) {
                $q->whereIn('classroom_id', $studentClassroomIds);
            })->latest()->get();
        }

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Menampilkan form buat tugas (Hanya Guru)
     */
    public function create()
    {
        $user = auth()->user();

        // Pastikan menggunakan Namespace Model yang benar
        if ($user->role_id == 1) {
            // Admin: Ambil SEMUA kelas tanpa filter
            $classrooms = \App\Models\Classroom::orderBy('name', 'asc')->get();
        } else {
            // Guru: Filter kelas berdasarkan course yang dia ampu (instructor_id)
            $classrooms = \App\Models\Classroom::whereHas('courses', function($query) use ($user) {
                $query->where('instructor_id', $user->id);
            })->get();
        }

        // DEBUG: Jika masih kosong di browser, aktifkan baris bawah ini untuk cek data
        // dd($classrooms); 

        return view('tasks.create', compact('classrooms'));
    }

    /**
     * Menyimpan tugas baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required|string|max:255',
            'due_date' => 'nullable|date',
        ]);

        $task = new Task($request->all());
        $task->slug = Str::slug($request->title) . '-' . time();
        $task->status = 'published'; // default langsung publish
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dibuat!');
    }

    /**
     * Menampilkan detail tugas, form submit (Murid), dan daftar pengumpul (Guru)
     */
    public function show($id)
    {
        $task = Task::with(['lesson.module.course.classroom'])->findOrFail($id);
        $user = auth()->user();
        
        $taskClassroomId = optional($task->lesson->module->course)->classroom_id;
        $canAccess = false;

        if ($user->hasRole('admin')) {
            $canAccess = true;
        } 
        elseif ($user->hasRole('instructor')) {
            // Instructor cek lewat instructor_id di course
            $canAccess = ($task->lesson->module->course->instructor_id == $user->id);
        } 
        else {
            // STUDENT: Cek apakah ID kelas tugas ini ada di daftar kelas si student
            $canAccess = $user->classrooms()->where('classrooms.id', $taskClassroomId)->exists();
        }

        if (!$canAccess) {
            abort(403, 'Anda tidak terdaftar di kelas yang memiliki tugas ini.');
        }

        return view('tasks.show', compact('task'));
    }
    /**
     * Menampilkan form edit (Hanya Guru)
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Memperbarui tugas
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Menghapus tugas
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus!');
    }

    public function submit(Request $request, $taskId)
    {
        // 1. Validasi Input
        $request->validate([
            'submission_type' => 'required|in:file,link',
            'file' => 'required_if:submission_type,file|file|mimes:pdf,jpg,png|max:10240', // Max 10MB
            'link_url' => 'required_if:submission_type,link|nullable|url',
            'notes' => 'nullable|string'
        ], [
            'file.mimes' => 'Format file harus PDF, JPG, atau PNG.',
            'file.max' => 'Ukuran file maksimal adalah 10MB.'
        ]);

        $user = auth()->user();
        $task = Task::findOrFail($taskId);

        // 2. Siapkan Data Dasar
        $data = [
            'task_id' => $task->id,
            'user_id' => $user->id,
            'submission_type' => $request->submission_type,
            'notes' => $request->notes,
        ];

        // 3. Logika Upload File ke folder 'tasks'
        if ($request->submission_type == 'file') {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                
                // Simpan ke storage/app/public/tasks
                $path = $file->store('tasks', 'public');
                
                $data['file_path'] = $path;
                $data['original_file_name'] = $file->getClientOriginalName();
                $data['file_size'] = $file->getSize();
                $data['link_url'] = null; // Reset link jika sebelumnya ada
            }
        } else {
            // Jika pilih Link
            $data['link_url'] = $request->link_url;
            $data['file_path'] = null;
            $data['original_file_name'] = null;
        }

        // 4. UpdateOrCreate (Bisa kumpulkan ulang/re-submit)
        TaskSubmission::updateOrCreate(
            ['task_id' => $task->id, 'user_id' => $user->id],
            $data
        );

        return redirect()->back()->with('success', 'Tugas Anda berhasil dikirim!');
    }
}