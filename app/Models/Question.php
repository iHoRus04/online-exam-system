<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'type',
        'question_text',
        'options',
        'correct_answer',
    ];

    protected $casts = [
        'options' => 'array', // Laravel sẽ tự decode JSON thành mảng
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
    public function studentAnswers()
    {
        return $this->hasMany(\App\Models\StudentAnswer::class, 'question_id');
    }

}