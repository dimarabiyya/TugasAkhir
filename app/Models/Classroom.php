<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'instructor_id'];

    public function instructor() {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'classroom_id');
    }

    public function students() {
        return $this->belongsToMany(User::class, 'classroom_user');
    }
}
