<?php

namespace App\Console\Commands;

use App\Services\StreakService;
use Illuminate\Console\Command;

class ResetMonthlyRecovery extends Command
{
    protected $signature   = 'streak:reset-recovery';
    protected $description = 'Reset kuota recovery streak setiap awal bulan';

    public function handle(StreakService $streakService): void
    {
        $streakService->resetMonthlyRecovery();
        $this->info('✅ Recovery streak berhasil direset untuk semua user.');
    }
}
