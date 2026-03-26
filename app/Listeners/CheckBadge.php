<?php

namespace App\Listeners;

use App\Events\BadgeDiraih;
use App\Events\SoalDijawab;
use App\Services\BadgeService;

class CheckBadge
{
    public function __construct(protected BadgeService $badgeService) {}

    public function handle(SoalDijawab $event): void
    {
        $badge = $this->badgeService->checkMilestone($event->user);

        if ($badge) {
            BadgeDiraih::dispatch($event->user, $badge);
        }
    }
}
