<?php

namespace App\Services;

use App\Models\Quest;
use App\Models\User;
use App\Models\UserQuest;

class QuestService
{
    public function resetDailyQuests(User $user): void
    {
        // Hapus quest hari ini lalu buat ulang dari semua quest aktif
        UserQuest::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->delete();

        $quests = Quest::all();

        foreach ($quests as $quest) {
            UserQuest::create([
                'user_id'      => $user->id,
                'quest_id'     => $quest->id,
                'progress'     => 0,
                'is_completed' => false,
            ]);
        }
    }

    public function updateProgress(User $user, string $tipe, int $jumlah = 1): void
    {
        $userQuests = UserQuest::with('quest')
            ->where('user_id', $user->id)
            ->whereHas('quest', fn($q) => $q->where('tipe', $tipe))
            ->where('is_completed', false)
            ->whereDate('created_at', today())
            ->get();

        foreach ($userQuests as $uq) {
            $uq->progress += $jumlah;

            if ($uq->progress >= $uq->quest->target) {
                $uq->is_completed = true;
                $uq->completed_at = now();
            }

            $uq->save();
        }
    }
}
