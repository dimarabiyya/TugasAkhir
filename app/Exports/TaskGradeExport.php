<?php

namespace App\Exports;

use App\Models\Task;
use App\Models\TaskSubmission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TaskGradeExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $taskId;

    public function __construct($taskId)
    {
        $this->taskId = $taskId;
    }

    public function collection()
    {
        // Ambil semua pengumpulan untuk tugas ini beserta relasi user dan nilai (grade)
        return TaskSubmission::with(['user', 'grade', 'task'])
            ->where('task_id', $this->taskId)
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'Email',
            'Judul Tugas',
            'Skor Maksimal',
            'Nilai Siswa',
            'Feedback Guru',
            'Tanggal Kumpul',
        ];
    }

    public function map($submission): array
    {
        static $no = 1;
        return [
            $no++,
            $submission->user->name,
            $submission->user->email,
            $submission->task->title,
            $submission->task->max_score,
            $submission->grade ? $submission->grade->score : 'Belum Dinilai',
            $submission->grade ? $submission->grade->feedback : '-',
            $submission->created_at->format('d/m/Y H:i'),
        ];
    }
}