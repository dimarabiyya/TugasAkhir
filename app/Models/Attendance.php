<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'classroom_id',
        'course_id',
        'student_id',
        'instructor_id',
        'attendance_date',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
}
