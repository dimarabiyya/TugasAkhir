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

    public function grade() {
        return $this->hasOne(TaskGrade::class, 'task_submission_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}