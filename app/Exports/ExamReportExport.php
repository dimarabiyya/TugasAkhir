<?php

namespace App\Exports;

use App\Models\Exam;
use App\Models\Classroom;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExamReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $exam;
    protected $classroom;

    public function __construct(Exam $exam, Classroom $classroom)
    {
        $this->exam = $exam;
        $this->classroom = $classroom;
    }

    public function collection()
    {
        // Ambil siswa di kelas ini beserta nilainya untuk ujian ini
        return $this->classroom->students()->with(['examAttempts' => function($q) {
            $q->where('exam_id', $this->exam->id);
        }])->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'Email',
            'Status',
            'Nilai',
            'Waktu Selesai'
        ];
    }

    public function map($student): array
    {
        static $no = 1;
        $attempt = $student->examAttempts->first();

        return [
            $no++,
            $student->name,
            $student->email,
            $attempt && $attempt->submitted_at ? 'Selesai' : ($attempt ? 'Proses' : 'Belum'),
            $attempt ? number_format($attempt->score, 2) : '-',
            $attempt && $attempt->submitted_at ? $attempt->submitted_at->format('d/m/Y H:i') : '-',
        ];
    }
}