<?php

namespace App\Services;

use App\Models\User;

class WhatsAppService
{
    const TEMPLATES = [
        'streak'  => "Hei {nama}! 🔥 Streak kamu di Sinau sudah {streak} hari.\nJangan sampai putus ya! Yuk jawab 1 soal hari ini:\nhttp://sinau.test/siswa/dashboard — Kinners nunggu kamu! 🐱",
        'tugas'   => "Hei {nama}! 📚 Ada tugas baru di Sinau:\n{judul} — Deadline: {deadline}.\nCek sekarang: http://sinau.test/siswa/dashboard",
        'badge'   => "Hei {nama}! 🏅 Selamat! Kamu baru saja meraih badge\n'{badge}' di Sinau! Pertahankan streak-mu ya Smeconer!\nLihat koleksi badge: http://sinau.test/siswa/dashboard",
        'bebas'   => "{pesan}",
    ];

    public function buildMessage(string $template, array $data): string
    {
        $text = self::TEMPLATES[$template] ?? $data['pesan'] ?? '';

        foreach ($data as $key => $value) {
            $text = str_replace('{' . $key . '}', $value, $text);
        }

        return $text;
    }

    public function getWaLink(string $phone, string $message): string
    {
        $phone   = preg_replace('/\D/', '', $phone);
        $phone   = ltrim($phone, '0');
        $phone   = '62' . $phone;

        return 'https://wa.me/' . $phone . '?text=' . urlencode($message);
    }

    public function blastLink(array $users, string $template, array $extraData = []): array
    {
        $links = [];

        foreach ($users as $user) {
            $data = array_merge($extraData, [
                'nama'   => $user->name,
                'streak' => $user->streak?->streak_count ?? 0,
            ]);

            $message = $this->buildMessage($template, $data);
            $links[] = [
                'user' => $user,
                'link' => $this->getWaLink($user->phone ?? '', $message),
            ];
        }

        return $links;
    }
}
