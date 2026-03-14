<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (!isset($row['name']) || !isset($row['email'])) {
                continue;
            }

            $student = User::updateOrCreate(
                ['email' => $row['email']], 
                [
                    'nisn' => $row['nisn'] ?? null,
                    'name' => $row['name'],
                    'phone' => $row['phone'] ?? null,
                    'level' => 'student',
                    'password' => Hash::make('siswa123'), 
                ]
            );

            if (!$student->hasRole('student')) {
                $student->assignRole('student');
            }
        }
    }
}