<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskGrade extends Model
{
    protected $table = 'task_grades';
    protected $fillable = [ 
        'task_submission_id', 
        'grader_id', 
        'score', 
        'feedback'
    ];

    public function submission() {
        return $this->belongsTo(TaskSubmission::class, 'task_submission_id');
    }

    public function grader() {
        return $this->belongsTo(User::class, 'grader_id');
    }
}