<?php

namespace App\Exports;

use App\Models\Course;
use App\Models\Classroom;
use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceRecapExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $courseId;
    protected $startDate;
    protected $endDate;

    public function __construct($courseId, $startDate, $endDate)
    {
        $this->courseId = $courseId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function array(): array
    {
        $course = Course::findOrFail($this->courseId);
        
        $classroom = Classroom::with(['students' => function($q) {
            $q->role('student');
        }])->findOrFail($course->classroom_id);

        $data = [];
        $no = 1;

        foreach ($classroom->students as $student) {
            $attendances = Attendance::where('course_id', $this->courseId)
                ->where('student_id', $student->id)
                ->whereBetween('attendance_date', [$this->startDate, $this->endDate])
                ->get();

            $data[] = [
                $no++,
                $student->nisn ?? '-',
                $student->name,
                $attendances->where('status', 'present')->count(),
                $attendances->where('status', 'sick')->count(),
                $attendances->where('status', 'absent')->count(),
            ];
        }

        return $data;
    }

    public function headings(): array
    {
        $course = Course::find($this->courseId);
        return [
            ['REKAPITULASI ABSENSI'],
            ['Mata Pelajaran : ' , ($course->name ?? 'Semua')],
            ['Periode : ' , $this->startDate . ' s/d ' . $this->endDate],
            [], 
            ['No', 'NISN', 'Nama Siswa', 'Total Hadir', 'Total Sakit', 'Total Alpa']
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Menebalkan baris judul dan header tabel
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            5 => ['font' => ['bold' => true]],
        ];
    }
}