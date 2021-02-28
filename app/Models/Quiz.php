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
        'salah1',
        'salah2',
    ];

    public function lesson()
    {
        return $this->belongTo(Lesson::class);
    }
}
