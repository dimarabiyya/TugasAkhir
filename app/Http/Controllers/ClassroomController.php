<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
// Import Controller bawaan Laravel
use App\Http\Controllers\Controller;

class ClassroomController extends Controller
{
    /**
     * Menampilkan daftar kelas (Index)
     */
    public function index()
    {
        // Mengambil kelas beserta nama instruktur dan hitung jumlah siswa
        $classrooms = Classroom::with('instructor')->withCount('students')->get();
        return view('classrooms.index', compact('classrooms'));
    }

    /**
     * Form tambah kelas
     */
    public function create()
    {
        // Ambil instruktur (role 2) dan siswa (role 3)
        // Asumsi menggunakan Spatie Permission seperti di file RolePermissionSeeder Anda
        $instructors = User::role('instructor')->get(); 
        $students = User::role('student')->get(); 

        return view('classrooms.create', compact('instructors', 'students'));
    }

    /**
     * Simpan kelas baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'instructor_id' => 'required|exists:users,id',
            'student_ids' => 'nullable|array',
            'description' => 'nullable'
        ]);

        // 1. Buat Kelas
        $classroom = Classroom::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
            'description' => $request->description,
            'instructor_id' => $request->instructor_id,
        ]);

        // 2. Pasangkan Siswa ke Kelas (Tabel Pivot)
        if ($request->student_ids) {
            $classroom->students()->attach($request->student_ids);
        }

        return redirect()->route('classrooms.index')
            ->with('success', 'Kelas berhasil dibuat dan siswa telah didaftarkan.');
    }

    /**
     * Form Edit Kelas
     */
    public function edit(Classroom $classroom)
    {
        $instructors = User::role('instructor')->get();
        $students = User::role('student')->get();
        
        // Ambil ID siswa yang sudah ada di kelas ini untuk ditandai (selected) di view
        $currentStudents = $classroom->students->pluck('id')->toArray();

        return view('classrooms.edit', compact('classroom', 'instructors', 'students', 'currentStudents'));
    }

    /**
     * Update data kelas
     */
    public function update(Request $request, Classroom $classroom)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'instructor_id' => 'required|exists:users,id',
            'student_ids' => 'nullable|array',
        ]);

        $classroom->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
            'description' => $request->description,
            'instructor_id' => $request->instructor_id,
        ]);

        // Menggunakan sync() untuk menghapus siswa lama dan mengganti dengan yang baru dipilih
        $classroom->students()->sync($request->student_ids);

        return redirect()->route('classrooms.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    /**
     * Hapus kelas
     */
    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->route('classrooms.index')->with('success', 'Kelas berhasil dihapus.');
    }
}