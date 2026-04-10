<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kemitraan extends Model
{
    protected $table = 'kemitraan';

    protected $fillable = [
        'nama',
        'logo',
        'bidang',
        'link_website',
        'lowongan',
        'link_lowongan',
    ];

    /**
     * URL logo (uploaded atau placeholder)
     */
    public function getLogoUrlAttribute(): string
    {
        if ($this->logo && file_exists(public_path('storage/' . $this->logo))) {
            return asset('storage/' . $this->logo);
        }
        return asset('images/default-mitra.png');
    }

    /**
     * Cek apakah punya lowongan aktif
     */
    public function hasLowongan(): bool
    {
        return !empty($this->lowongan) && !empty($this->link_lowongan);
    }
}