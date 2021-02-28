<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lesson_id',
        'soal',
        'jawaban',
        'jawaban',
        'jawaban',
    ];

    public function lesson()
    {
        return $this->belongTo(Lesson::class);
    }
}
