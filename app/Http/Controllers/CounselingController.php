<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CounselingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CounselingController extends Controller
{
    // 1. Tampilkan Riwayat Chat (Halaman Utama Konseling)
    public function index()
    {
        $user = Auth::user();
        
        // Ambil sesi chat yang melibatkan user ini
        $query = CounselingSession::with(['student', 'instructor']);

        if ($user->hasRole('admin')) {
            // Admin bisa lihat semua
            $sessions = $query->latest()->get();
        } else {
            // Student atau Instructor hanya lihat chat mereka sendiri
            $sessions = $query->where('student_id', $user->id)
                             ->orWhere('instructor_id', $user->id)
                             ->latest()
                             ->get();
        }

        return view('counseling.index', compact('sessions'));
    }

    // 2. Halaman Khusus Memilih Guru (Hanya untuk Student)
    public function chooseInstructor()
    {
        // Ambil semua user yang punya role instructor
        $instructors = User::role('instructor')->get();
        return view('counseling.choose', compact('instructors'));
    }

    // 3. Method untuk memulai/membuat sesi chat (startSession)
    public function startSession(User $instructor)
    {
        // Gunakan firstOrCreate agar tidak buat sesi ganda untuk orang yang sama
        $session = CounselingSession::firstOrCreate([
            'student_id' => Auth::id(),
            'instructor_id' => $instructor->id,
        ]);

        return redirect()->route('counseling.show', $session->id);
    }

    public function show(CounselingSession $session)
    {
        // Proteksi akses
        if (!Auth::user()->hasRole('admin') && 
            Auth::id() !== $session->student_id && 
            Auth::id() !== $session->instructor_id) {
            abort(403);
        }

        $messages = $session->messages()->with('sender')->oldest()->get();
        return view('counseling.show', compact('session', 'messages'));
    }
    
    public function storeMessage(Request $request, CounselingSession $session)
    {
        // 1. Validasi input agar pesan tidak kosong
        $request->validate([
            'message' => 'required|string',
        ]);

        // 2. Simpan pesan ke database melalui relasi session
        // Ini akan otomatis mengisi session_id
        $session->messages()->create([
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'is_read' => false,
        ]);

        // 3. Kembali ke halaman chat dengan pesan sukses
        return back()->with('success', 'Pesan berhasil dikirim.');
    }

    public function destroy(CounselingSession $session)
    {
        $user = auth()->user();

        // Logika Keamanan: 
        // Izinkan hapus jika user adalah Admin, ATAU Student pemiliknya, ATAU Instructor pemiliknya
        if ($user->hasRole('admin') || $user->id === $session->student_id || $user->id === $session->instructor_id) {
            
            // 1. Hapus semua pesan di dalam sesi ini dulu agar tidak error Foreign Key
            $session->messages()->delete();

            // 2. Hapus sesi utamanya
            $session->delete();

            return redirect()->route('counseling.index')->with('success', 'Sesi konseling berhasil dihapus.');
        }

        // Jika user asing mencoba hapus chat orang lain
        abort(403, 'Anda tidak memiliki akses untuk menghapus chat ini.');
    }

}