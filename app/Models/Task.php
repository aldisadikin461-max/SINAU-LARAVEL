<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'guru_id',
        'jurusan',
        'kelas',
        'judul',
        'deskripsi',
        'deadline',
    ];

    protected function casts(): array
    {
        return ['deadline' => 'datetime'];
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
