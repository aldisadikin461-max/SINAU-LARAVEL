<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserPoint;

class PointService
{
    // Level threshold tiap 100 poin
    const POIN_PER_LEVEL = 100;

    public function addPoints(User $user, int $poin, string $aktivitas, string $keterangan = ''): void
    {
        UserPoint::create([
            'user_id'    => $user->id,
            'poin'       => $poin,
            'aktivitas'  => $aktivitas,
            'keterangan' => $keterangan,
        ]);

        $user->increment('total_poin', $poin);
        $user->refresh();

        $this->updateLevel($user);
    }

    public function updateLevel(User $user): void
    {
        $level = (int) floor($user->total_poin / self::POIN_PER_LEVEL) + 1;

        if ($user->level !== $level) {
            $user->update(['level' => $level]);
        }
    }
}
