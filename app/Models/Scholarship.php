<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'penyelenggara',
        'jenjang',
        'tipe',
        'deadline',
        'link',
        'status',
        'deskripsi',
    ];

    // jenjang: SMA | SMK | S1
    // status: buka | tutup

    protected function casts(): array
    {
        return ['deadline' => 'date'];
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
}
