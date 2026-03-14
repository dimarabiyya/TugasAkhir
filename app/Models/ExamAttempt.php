<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    protected $fillable = ['exam_id', 'user_id', 'started_at', 'submitted_at', 'score', 'answers', 'cheat_attempts'];

    // Cast jawaban dari JSON ke Array agar mudah diolah
    protected $casts = [
        'answers' => 'array',
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function exam() {
        return $this->belongsTo(Exam::class);
    }

    // Fungsi hitung skor otomatis
    public function calculateScore()
    {
        $exam = $this->exam;
        $questions = $exam->questions;
        $correctCount = 0;
        $totalQuestions = $questions->count();

        foreach ($questions as $question) {
            // Cek apakah jawaban siswa untuk ID soal ini sama dengan kunci
            if (isset($this->answers[$question->id]) && $this->answers[$question->id] == $question->correct_answer) {
                $correctCount++;
            }
        }

        // Skor skala 100
        $this->score = ($totalQuestions > 0) ? ($correctCount / $totalQuestions) * 100 : 0;
        $this->save();
    }
}