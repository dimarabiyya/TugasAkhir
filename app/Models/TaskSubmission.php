<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskSubmission extends Model
{
    protected $table = 'task_submissions';
    protected $fillable = [
        'task_id', 'user_id', 'submission_type', 
        'file_path', 'original_file_name', 'file_size', 
        'link_url', 'notes'
    ];

    public function student() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function task() {
        return $this->belongsTo(Task::class);
    }

    // Relasi ke tabel penilaian (jika ada)
    public function grade() {
        // Tambahkan parameter kedua untuk foreign key
        return $this->hasOne(TaskGrade::class, 'task_submission_id');
    }
}