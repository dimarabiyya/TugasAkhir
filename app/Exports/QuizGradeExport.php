<?php

namespace App\Exports;

use App\Models\QuizAttempt;
use App\Models\Quiz;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class QuizGradeExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $quizId;

    public function __construct($quizId)
    {
        $this->quizId = $quizId;
    }

    public function collection()
    {
        // Mengambil attempt terakhir setiap user untuk quiz ini
        return QuizAttempt::with(['user', 'quiz'])
            ->where('quiz_id', $this->quizId)
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'Email',
            'Judul Quiz',
            'Percobaan Ke-',
            'Benar',
            'Salah',
            'Kosong',
            'Total Soal',
            'Skor Akhir',
            'Status (Passing)',
            'Tanggal Pengerjaan'
        ];
    }

    public function map($attempt): array
    {
        static $no = 1;
        $status = $attempt->score >= $attempt->quiz->passing_score ? 'LULUS' : 'TIDAK LULUS';

        return [
            $no++,
            $attempt->user->name,
            $attempt->user->email,
            $attempt->quiz->title,
            $attempt->attempt_number,
            $attempt->correct_answers,
            $attempt->incorrect_answers,
            $attempt->unanswered_questions,
            $attempt->total_questions,
            $attempt->score,
            $status,
            $attempt->created_at->format('d/m/Y H:i'),
        ];
    }
}