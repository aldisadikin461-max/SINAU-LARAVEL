<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tryout extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'durasi_menit',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai'   => 'datetime',
            'tanggal_selesai' => 'datetime',
        ];
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'tryout_questions');
    }
}
