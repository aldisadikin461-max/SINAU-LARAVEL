<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAttempt extends Model
{
    protected $fillable = [
        'quiz_packet_id', 'user_id', 'skor', 'total_poin',
        'benar', 'salah', 'uraian_count', 'jawaban', 'selesai_at',
    ];

    protected $casts = [
        'jawaban'    => 'array',
        'selesai_at' => 'datetime',
    ];

    public function packet(): BelongsTo
    {
        return $this->belongsTo(QuizPacket::class, 'quiz_packet_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function persentase(): int
    {
        if (!$this->total_poin) return 0;
        return (int) round(($this->skor / $this->total_poin) * 100);
    }
}