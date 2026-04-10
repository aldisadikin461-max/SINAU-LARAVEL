<?php

namespace App\Services;

use App\Models\Streak;
use Carbon\Carbon;

class StreakService
{
    const MAX_RECOVERY = 3;

    // ── Activate ──────────────────────────────────────────────────
    /**
     * Aktifkan streak baru untuk user.
     * Jika sudah aktif, return streak tanpa perubahan.
     */
    public function activate(int $userId): Streak
    {
        $streak = $this->getOrCreate($userId);

        // Jika sudah aktif, tidak perlu diaktifkan ulang
        if ($streak->is_active) {
            return $streak;
        }

        $streak->update([
            'current_streak'   => 1,
            'streak_count'     => 1,
            'last_activity_at' => now(),
            'last_increase_at' => now(),
            'started_at'       => now(),
            'last_active_date' => today(),
            'longest_streak'   => max($streak->longest_streak ?? 0, 1),
        ]);

        return $streak->fresh();
    }

    // ── Record Activity ───────────────────────────────────────────
    /**
     * Catat aktivitas harian (jawab soal).
     * Return array status streak.
     */
    public function recordActivity(int $userId): array
    {
        $streak = $this->getOrCreate($userId);

        // Sudah jawab hari ini? Skip
        if ($streak->last_active_date && $streak->last_active_date->isToday()) {
            return [
                'increased'  => false,
                'current'    => $streak->current,
                'is_active'  => $streak->is_active,
                'was_reset'  => false,
            ];
        }

        $wasReset   = false;
        $increased  = false;

        // Belum pernah aktif → auto activate
        if (!$streak->started_at) {
            $this->activate($userId);
            $streak->refresh();
            return [
                'increased' => true,
                'current'   => $streak->current,
                'is_active' => true,
                'was_reset' => false,
            ];
        }

        // Cek apakah streak mati (last_activity > 24 jam lalu)
        if ($streak->last_activity_at && $streak->last_activity_at->lt(now()->subHours(24))) {
            // Streak mati — reset tapi tetap catat aktivitas hari ini
            $streak->update([
                'current_streak'   => 0,
                'streak_count'     => 0,
                'started_at'       => null,
                'last_activity_at' => now(),
                'last_active_date' => today(),
            ]);
            $wasReset = true;

            return [
                'increased' => false,
                'current'   => 0,
                'is_active' => false,
                'was_reset' => true,
            ];
        }

        // Streak aktif, belum jawab hari ini → tambah streak
        $newCurrent = ($streak->current_streak ?? 0) + 1;
        $newLongest = max($streak->longest_streak ?? 0, $newCurrent);

        $streak->update([
            'current_streak'   => $newCurrent,
            'streak_count'     => $newCurrent,
            'last_activity_at' => now(),
            'last_increase_at' => now(),
            'last_active_date' => today(),
            'longest_streak'   => $newLongest,
        ]);

        $increased = true;

        return [
            'increased' => true,
            'current'   => $newCurrent,
            'is_active' => true,
            'was_reset' => false,
        ];
    }

    // ── Recover Streak ────────────────────────────────────────────
    /**
     * Pulihkan streak yang sudah mati (max 3x/bulan).
     */
    public function recoverStreak(int $userId): array
    {
        $streak = $this->getOrCreate($userId);

        // Streak masih aktif
        if ($streak->is_active) {
            return [
                'success'      => false,
                'message'      => 'Streak kamu masih aktif, tidak perlu dipulihkan.',
                'recovery_left' => $streak->recovery_left,
            ];
        }

        // Kuota habis
        if (($streak->recovery_used_this_month ?? 0) >= self::MAX_RECOVERY) {
            return [
                'success'      => false,
                'message'      => 'Kuota recovery bulan ini sudah habis (maks 3x/bulan).',
                'recovery_left' => 0,
            ];
        }

        $streak->update([
            'current_streak'             => 1,
            'streak_count'               => 1,
            'started_at'                 => now(),
            'last_activity_at'           => now(),
            'last_increase_at'           => now(),
            'last_active_date'           => today(),
            'recovery_used_this_month'   => ($streak->recovery_used_this_month ?? 0) + 1,
            'longest_streak'             => max($streak->longest_streak ?? 0, 1),
        ]);

        $left = self::MAX_RECOVERY - $streak->fresh()->recovery_used_this_month;

        return [
            'success'       => true,
            'message'       => "Streak berhasil dipulihkan! Sisa recovery: {$left}x bulan ini.",
            'recovery_left' => $left,
        ];
    }

    // ── Get Streak Data ───────────────────────────────────────────
    /**
     * Ambil semua data streak user dalam format array.
     */
    public function getStreakData(int $userId): array
    {
        $streak = $this->getOrCreate($userId);

        return [
            'current'       => $streak->current,
            'longest'       => $streak->longest_streak ?? 0,
            'is_active'     => $streak->is_active,
            'recovery_left' => $streak->recovery_left,
            'last_activity' => $streak->last_activity_at,
            'started_at'    => $streak->started_at,
        ];
    }

    // ── Reset Monthly Recovery ────────────────────────────────────
    /**
     * Reset kuota recovery semua user (dijadwalkan tiap tgl 1).
     */
    public function resetMonthlyRecovery(): void
    {
        Streak::query()->update(['recovery_used_this_month' => 0]);
    }

    // ── Helper Private ────────────────────────────────────────────
    private function getOrCreate(int $userId): Streak
    {
        return Streak::firstOrCreate(
            ['user_id' => $userId],
            [
                'streak_count'             => 0,
                'longest_streak'           => 0,
                'current_streak'           => 0,
                'recovery_used_this_month' => 0,
            ]
        );
    }
}
