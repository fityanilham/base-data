<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'answer_text'
    ];

    public function quiz()
    {
        return $this->belongTo(Quiz::class);
    }
}
