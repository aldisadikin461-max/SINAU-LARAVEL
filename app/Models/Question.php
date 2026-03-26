<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'pertanyaan',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'jawaban_benar',
        'tingkat_kesulitan',
    ];

    // tingkat_kesulitan: mudah | sedang | sulit

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tryouts()
    {
        return $this->belongsToMany(Tryout::class, 'tryout_questions');
    }

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }
}
