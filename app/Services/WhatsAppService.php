<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class WhatsAppService
{
    private array $templates = [
        'streak' => "Hai {nama}! 🔥\n\nStreak belajarmu di Sinau hampir putus nih. Yuk belajar sebentar hari ini biar streak-mu tetap terjaga!\n\nSemangat, Smeconer! 💪\n\n— Sinau SMKN 1 Purwokerto",
        'badge'  => "Hai {nama}! 🏅\n\nSelamat! Kamu baru saja meraih badge baru di Sinau! Terus pertahankan semangat belajarmu.\n\nBangga sama kamu, Smeconer! 🎉\n\n— Sinau SMKN 1 Purwokerto",
        'motivasi' => "Hai {nama}! 💪\n\nJangan lupa belajar hari ini ya! Setiap langkah kecil membawamu lebih dekat ke impianmu.\n\nAyo, Smeconer!\n\n— Sinau SMKN 1 Purwokerto",
        'bebas'  => '{pesan}',
    ];

    public function buildMessage(string $template, array $data): string
    {
        $msg = $this->templates[$template] ?? $data['pesan'] ?? '';
        return str_replace(
            ['{nama}', '{pesan}'],
            [$data['nama'] ?? '', $data['pesan'] ?? ''],
            $msg
        );
    }

    public function formatPhone(string $phone): string
    {
        // Hapus semua karakter non-angka
        $phone = preg_replace('/\D/', '', $phone);

        // Ganti 0 di depan dengan 62
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        // Tambah 62 kalau belum ada
        if (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    public function getWaLink(string $phone, string $message): string
    {
        $phone = $this->formatPhone($phone);
        return 'https://wa.me/' . $phone . '?text=' . rawurlencode($message);
    }

    public function blastLink($users, string $template, array $extra = []): array
    {
        $users = collect($users); // pastikan selalu Collection
        return $users->map(function (User $user) use ($template, $extra) {
            $data = array_merge(['nama' => $user->name], $extra);
            $msg  = $this->buildMessage($template, $data);

            return [
                'name'  => $user->name,
                'phone' => $user->phone ?? null,
                'waUrl' => $user->phone
                    ? $this->getWaLink($user->phone, $msg)
                    : null,
            ];
        })->values()->toArray();
    }
}
