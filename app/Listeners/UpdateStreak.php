<?php

namespace App\Listeners;

use App\Events\SoalDijawab;
use App\Services\StreakService;

class UpdateStreak
{
    public function __construct(protected StreakService $streakService) {}

    public function handle(SoalDijawab $event): void
    {
        if ($event->answer->is_correct) {
            $this->streakService->updateStreak($event->user);
        }
    }
}
