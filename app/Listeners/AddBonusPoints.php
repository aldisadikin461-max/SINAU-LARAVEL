<?php

namespace App\Listeners;

use App\Events\QuestSelesai;
use App\Services\PointService;

class AddBonusPoints
{
    public function __construct(protected PointService $pointService) {}

    public function handle(QuestSelesai $event): void
    {
        $this->pointService->addPoints(
            $event->user,
            $event->userQuest->quest->poin_reward,
            'quest_selesai',
            "Menyelesaikan quest: {$event->userQuest->quest->judul}"
        );
    }
}
