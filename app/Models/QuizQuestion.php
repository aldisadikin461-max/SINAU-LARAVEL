<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizQuestion extends Model
{
   protected $fillable = [
    'quiz_packet_id',
    'pertanyaan',
    'tipe',
    'tingkat',
    'poin',
    'opsi_a',
    'opsi_b',
    'opsi_c',
    'opsi_d',
    'jawaban_benar',
    'pembahasan',
    'urutan',
];

    public function packet(): BelongsTo
    {
        return $this->belongsTo(QuizPacket::class, 'quiz_packet_id');
    }

    public function labelTipe(): string
    {
        return match ($this->tipe) {
            'pilgan'      => 'Pilihan Ganda',
            'uraian'      => 'Uraian',
            'benar_salah' => 'Benar / Salah',
            default       => $this->tipe,
        };
    }
}