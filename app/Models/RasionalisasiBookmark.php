<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RasionalisasiBookmark extends Model
{
    use HasFactory;

    protected $table = 'rasionalisasi_bookmarks';

    protected $fillable = [
        'user_id', 'rasionalisasi_id', 'tipe', 'nama', 'link', 'data_extra',
    ];

    protected function casts(): array
    {
        return ['data_extra' => 'array'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rasionalisasi()
    {
        return $this->belongsTo(Rasionalisasi::class);
    }
}
