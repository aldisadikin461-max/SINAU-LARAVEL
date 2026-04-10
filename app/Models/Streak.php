<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Streak extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'streak_count',
        'last_active_date',
        'longest_streak',
        'current_streak',
        'last_activity_at',
        'last_increase_at',
        'started_at',
        'recovery_used_this_month',
    ];

    protected function casts(): array
    {
        return [
            'last_active_date'  => 'date',
            'last_activity_at'  => 'datetime',
            'last_increase_at'  => 'datetime',
            'started_at'        => 'datetime',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Accessors ──────────────────────────────────────────────────

    /**
     * Streak aktif = punya started_at DAN last_activity_at dalam 24 jam terakhir
     */
    public function getIsActiveAttribute(): bool
    {
        if (!$this->started_at || !$this->last_activity_at) {
            return false;
        }
        return $this->last_activity_at->gte(now()->subHours(24));
    }

    /**
     * Sisa kuota recovery bulan ini (max 3)
     */
    public function getRecoveryLeftAttribute(): int
    {
        return max(0, 3 - ($this->recovery_used_this_month ?? 0));
    }

    /**
     * Nilai streak saat ini — dengan fallback ke kolom lama
     */
    public function getCurrentAttribute(): int
    {
        return $this->current_streak ?? $this->streak_count ?? 0;
    }
}
