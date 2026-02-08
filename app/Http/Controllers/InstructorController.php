<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class InstructorController extends Controller
{
    public function index()
    {
        // Mengambil semua user yang memiliki role instructor
        $instructors = User::role('instructor')->latest()->paginate(10);
        return view('instructors.index', compact('instructors'));
    }

    public function create()
    {
        return view('instructors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Menetapkan role instructor (role id 2)
        $user->assignRole('instructor');

        return redirect()->route('instructors.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function edit(User $instructor)
    {
        return view('instructors.edit', compact('instructor'));
    }

    public function update(Request $request, User $instructor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $instructor->id,
        ]);

        $instructor->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $instructor->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('instructors.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(User $instructor)
    {
        $instructor->delete();
        return redirect()->route('instructors.index')->with('success', 'Guru berhasil dihapus.');
    }
}