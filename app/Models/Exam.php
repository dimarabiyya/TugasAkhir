<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'instructions',
        'duration',
        'start_time',
        'end_time',
        'is_active'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function classrooms() {
    return $this->belongsToMany(Classroom::class, 'exam_classroom');
    }

    public function questions() {
        return $this->hasMany(Question::class);
    }

    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function attempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }
}
