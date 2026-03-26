<?php

namespace App\Services;

use App\Models\Streak;
use App\Models\User;
use Carbon\Carbon;

class StreakService
{
    public function updateStreak(User $user): Streak
    {
        $streak = $user->streak ?? Streak::create([
            'user_id'          => $user->id,
            'streak_count'     => 0,
            'last_active_date' => null,
            'longest_streak'   => 0,
        ]);

        $today     = Carbon::today()->toDateString();
        $yesterday = Carbon::yesterday()->toDateString();
        $last      = $streak->last_active_date?->toDateString();

        if ($last === $today) {
            // Sudah aktif hari ini, tidak perlu update
            return $streak;
        }

        if ($last === $yesterday) {
            // Lanjutkan streak
            $streak->streak_count++;
        } else {
            // Reset streak
            $streak->streak_count = 1;
        }

        $streak->last_active_date = $today;

        if ($streak->streak_count > $streak->longest_streak) {
            $streak->longest_streak = $streak->streak_count;
        }

        $streak->save();

        return $streak;
    }

    public function checkAndResetStreak(User $user): void
    {
        $streak = $user->streak;

        if (! $streak) return;

        $yesterday = Carbon::yesterday()->toDateString();
        $last      = $streak->last_active_date?->toDateString();

        // Jika tidak aktif kemarin dan hari ini belum, reset
        if ($last && $last < $yesterday) {
            $streak->streak_count = 0;
            $streak->save();
        }
    }
}
