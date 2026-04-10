<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $table = 'alumni';

    protected $fillable = [
        'nama',
        'kampus',
        'domain_kampus',
        'jurusan',
        'jalur',
        'tahun_lulus',
    ];

    /**
     * URL logo kampus dari Clearbit
     */
    public function getLogoUrlAttribute(): string
    {
        if ($this->domain_kampus) {
            return "https://www.google.com/s2/favicons?domain={$this->domain_kampus}&sz=128";
        }
        return asset('images/default-kampus.png');
    }

    /**
     * Badge color untuk jalur
     */
    public function getBadgeColorAttribute(): string
    {
        return match($this->jalur) {
            'SNBP'    => 'badge-snbp',
            'SNBT'    => 'badge-snbt',
            'Mandiri' => 'badge-mandiri',
            default   => 'badge-snbp',
        };
    }

    /**
     * Ambil daftar tahun yang tersedia
     */
    public static function availableYears(): array
    {
        return static::select('tahun_lulus')
            ->distinct()
            ->orderByDesc('tahun_lulus')
            ->pluck('tahun_lulus')
            ->toArray();
    }
}