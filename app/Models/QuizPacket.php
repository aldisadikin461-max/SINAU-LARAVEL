<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizPacket extends Model
{
    protected $fillable = ['guru_id', 'nama', 'deskripsi', 'kelas', 'jurusan', 'status'];

    public function guru()
{
    return $this->belongsTo(\App\Models\User::class, 'guru_id');
}

public function questions()
{
    return $this->hasMany(\App\Models\QuizQuestion::class, 'quiz_packet_id');
}

public function attempts()
{
    return $this->hasMany(\App\Models\QuizAttempt::class, 'quiz_packet_id');
}


    public function totalPoin(): int
    {
        return $this->questions()->sum('poin');
    }
}