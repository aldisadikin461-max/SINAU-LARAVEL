<?php

namespace App\Listeners;

use App\Events\BadgeDiraih;
use App\Events\QuestSelesai;
use App\Events\SoalDijawab;
use App\Models\Notification;

class SendNotification
{
    public function handle(SoalDijawab|QuestSelesai|BadgeDiraih $event): void
    {
        if ($event instanceof BadgeDiraih) {
            Notification::create([
                'user_id' => $event->user->id,
                'judul'   => '🏅 Badge Baru!',
                'pesan'   => "Selamat! Kamu meraih badge '{$event->badge->nama}'. Pertahankan streakmu, Smeconer!",
                'tipe'    => 'badge',
            ]);
        }

        if ($event instanceof QuestSelesai) {
            Notification::create([
                'user_id' => $event->user->id,
                'judul'   => '✅ Quest Selesai!',
                'pesan'   => "Quest '{$event->userQuest->quest->judul}' berhasil diselesaikan. Poin bonus ditambahkan!",
                'tipe'    => 'quest',
            ]);
        }
    }
}
