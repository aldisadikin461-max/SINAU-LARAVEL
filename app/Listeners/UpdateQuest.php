<?php

namespace App\Listeners;

use App\Events\SoalDijawab;
use App\Services\QuestService;

class UpdateQuest
{
    public function __construct(protected QuestService $questService) {}

    public function handle(SoalDijawab $event): void
    {
        $this->questService->updateProgress($event->user, 'jawab_soal');
    }
}
