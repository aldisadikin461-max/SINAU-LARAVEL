<?php

namespace App\Events;

use App\Models\User;
use App\Models\UserQuest;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestSelesai
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly User      $user,
        public readonly UserQuest $userQuest,
    ) {}
}
