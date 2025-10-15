<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    // Các cột có thể được gán giá trị hàng loạt (mass assignment)
    protected $fillable = [
        'title',
        'duration',
        'total_questions',
    ];
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
