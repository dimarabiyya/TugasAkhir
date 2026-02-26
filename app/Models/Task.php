<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'lesson_id', 'title', 'slug', 'description', 'instructions', 
        'max_score', 'file_types', 'max_file_size', 'allow_link', 
        'allow_file', 'allow_multiple_submissions', 'due_date', 'status'
    ];

    // Relasi ke Lesson
    public function lesson() {
        return $this->belongsTo(Lesson::class);
    }

    // Relasi ke semua pengumpulan murid
    public function submissions() {
        return $this->hasMany(TaskSubmission::class);
    }
}
