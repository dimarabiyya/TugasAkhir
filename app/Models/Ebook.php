<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'publication_year',
        'cover_image',
        'file_path',
        'uploaded_by',
    ];

    // Relasi ke User (opsional, jika ingin tahu siapa yang upload)
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}