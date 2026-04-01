<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rasionalisasi extends Model
{
    use HasFactory;

    protected $table = 'rasionalisasi';

    protected $fillable = [
        'user_id', 'mode', 'input_data', 'hasil_ai', 'skor_kesiapan', 'status',
    ];

    protected function casts(): array
    {
        return [
            'input_data' => 'array',
            'hasil_ai'   => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(RasionalisasiBookmark::class);
    }

    // Helper: label mode
    public function getLabelModeAttribute(): string
    {
        return $this->mode === 'kuliah' ? '🎓 Kuliah' : '💼 Kerja';
    }

    // Helper: warna skor
    public function getWarnaSkoreAttribute(): string
    {
        $s = $this->skor_kesiapan ?? 0;
        if ($s >= 75) return '#16a34a';
        if ($s >= 50) return '#d97706';
        return '#dc2626';
    }
}
