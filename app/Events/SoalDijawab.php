<?php

namespace App\Events;

use App\Models\User;
use App\Models\UserAnswer;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SoalDijawab
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly User       $user,
        public readonly UserAnswer $answer,
    ) {}
}
