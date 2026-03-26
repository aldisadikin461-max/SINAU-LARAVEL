<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;
use App\Models\UserBadge;

class BadgeService
{
    // Milestone streak: 7, 14, 30, 60, 100 hari
    public function checkMilestone(User $user): ?Badge
    {
        $streakCount = $user->streak?->streak_count ?? 0;

        $badge = Badge::where('milestone_streak', $streakCount)->first();

        if (! $badge) return null;

        // Cek apakah sudah punya badge ini
        $alreadyAwarded = UserBadge::where('user_id', $user->id)
            ->where('badge_id', $badge->id)
            ->exists();

        if ($alreadyAwarded) return null;

        return $this->awardBadge($user, $badge);
    }

    public function awardBadge(User $user, Badge $badge): Badge
    {
        UserBadge::create([
            'user_id'    => $user->id,
            'badge_id'   => $badge->id,
            'awarded_at' => now(),
        ]);

        return $badge;
    }
}
