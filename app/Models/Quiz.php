<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'soal',
        'jawaban',
        'jawaban_salah1',
        'jawaban_salah2',
    ];
}
