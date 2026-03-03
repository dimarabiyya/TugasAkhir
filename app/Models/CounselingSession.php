<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounselingSession extends Model
{
    protected $fillable = ['student_id', 'instructor_id', 'subject'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function messages()
    {
        return $this->hasMany(CounselingMessage::class, 'session_id');
    }
}