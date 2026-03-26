<?php

namespace App\Listeners;

use App\Events\SoalDijawab;
use App\Services\PointService;

class AddPoints
{
    public function __construct(protected PointService $pointService) {}

    public function handle(SoalDijawab $event): void
    {
        if ($event->answer->is_correct) {
            $this->pointService->addPoints(
                $event->user,
                10,
                'jawab_soal',
                'Menjawab soal dengan benar'
            );
        }
    }
}
