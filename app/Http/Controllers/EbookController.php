<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EbookController extends Controller
{
    // Menampilkan daftar e-book (Untuk Admin, Guru, Siswa)
    public function index()
    {
        $ebooks = Ebook::latest()->paginate(12);
        return view('ebooks.index', compact('ebooks'));
    }

    // Form Upload (Hanya Admin)
    public function create()
    {
        // Cek permission disini atau di route middleware (disarankan)
        return view('ebooks.create');
    }

    // Proses Simpan ke DB (Hanya Admin)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publication_year' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'cover_image' => 'required|image|mimes:jpeg,png,jpg|max:10024', // Max 10MB
            'ebook_file' => 'required|mimes:pdf|max:10024', // Max 100MB PDF
        ]);

        // Upload Cover
        $coverPath = $request->file('cover_image')->store('covers', 'public');

        // Upload PDF
        $filePath = $request->file('ebook_file')->store('ebooks', 'public');

        Ebook::create([
            'title' => $request->title,
            'author' => $request->author,
            'publication_year' => $request->publication_year,
            'cover_image' => $coverPath,
            'file_path' => $filePath,
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()->route('ebooks.index')->with('success', 'E-book berhasil ditambahkan!');
    }

    // Download E-book (Bisa dilimit hanya user login)
    public function download(Ebook $ebook)
    {
        $filePath = storage_path('app/public/' . $ebook->file_path);

        if (file_exists($filePath)) {
            return response()->download($filePath, $ebook->title . '.pdf');
        }

        return back()->with('error', 'File tidak ditemukan.');
    }

    // Hapus E-book (Hanya Admin)
    public function destroy(Ebook $ebook)
    {
        // Hapus file fisik
        if ($ebook->cover_image) Storage::disk('public')->delete($ebook->cover_image);
        if ($ebook->file_path) Storage::disk('public')->delete($ebook->file_path);

        $ebook->delete();

        return redirect()->route('ebooks.index')->with('success', 'E-book berhasil dihapus.');
    }
}