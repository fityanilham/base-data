<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pelajaran',
        'guru',
        'tingkatan',
        'deskripsi',
      ];
    
      public function user() {
        return $this->belongsTo(User::class);
      }
    
      public function chapter() {
        return $this->hasMany(Chapter::class);
      }
}
