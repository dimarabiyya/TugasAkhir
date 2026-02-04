<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Course extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'level',
        'price', // Biarkan tetap di sini agar bisa diisi '0' oleh controller
        'is_published',
        'duration_hours',
        'instructor_id',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'price' => 'decimal:2', // Tetap pertahankan casting ini
    ];

    // Boot method (sama seperti sebelumnya, tidak perlu diubah)
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($course) {
            if (empty($course->slug)) {
                $course->slug = Str::slug($course->title);
            }
        });
        
        static::updating(function ($course) {
            if ($course->isDirty('title') && empty($course->slug)) {
                $course->slug = Str::slug($course->title);
            }
        });
    }

    // Relationships (sama seperti sebelumnya, dipersingkat di sini)
    public function modules() { return $this->hasMany(Module::class)->orderBy('order'); }
    public function enrollments() { return $this->hasMany(Enrollment::class); }
    public function users() { return $this->belongsToMany(User::class, 'enrollments')->withPivot(['enrolled_at', 'completed_at', 'progress_percentage'])->withTimestamps(); }
    public function transactions() { return $this->hasMany(Transaction::class); }
    public function instructor() { return $this->belongsTo(User::class, 'instructor_id'); }
    public function testimonials() { return $this->hasMany(Testimonial::class); }

    public function getLessonsCountAttribute()
    {
        return $this->modules->sum(function ($module) {
            return $module->lessons->count();
        });
    }

    public function scopePublished($query) { return $query->where('is_published', true); }
    public function scopeLevel($query, $level) { return $query->where('level', $level); }
    
    public function getUrlAttribute() { return route('courses.show', ['course' => $this->id, 'slug' => $this->slug]); }
    
    // UPDATE BAGIAN INI: Hapus price dari index pencarian (opsional)
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'level' => $this->level,
            // 'price' => $this->price, // Bisa dihapus atau biarkan saja
            'is_published' => $this->is_published,
            'duration_hours' => $this->duration_hours,
        ];
    }
    
    public function getScoutKey() { return $this->id; }
    public function getScoutKeyName() { return 'id'; }

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }
}