<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\QuizAttempt;
use App\Models\QuizPacket;
use Illuminate\Http\Request;

class QuizAttemptController extends Controller
{
    // Daftar paket soal yang bisa dikerjakan siswa
    public function index()
    {
        $packets = QuizPacket::where('status', 'published')
            ->withCount('questions')
            ->with(['attempts' => fn($q) => $q->where('user_id', auth()->id())->latest()])
            ->latest()
            ->get();

        return view('siswa.quiz.index', compact('packets'));
    }

    // Mulai / kerjakan paket soal
    public function show(QuizPacket $packet)
    {
        if ($packet->status !== 'published') abort(404);
        $packet->load('questions');
        return view('siswa.quiz.kerjakan', compact('packet'));
    }

    // Submit jawaban
    public function submit(Request $request, QuizPacket $packet)
    {
        if ($packet->status !== 'published') abort(404);

        $packet->load('questions');
        $jawaban   = $request->input('jawaban', []);
        $skor      = 0;
        $benar     = 0;
        $salah     = 0;
        $uraian    = 0;
        $totalPoin = 0;
        $detail    = [];

        foreach ($packet->questions as $q) {
            $totalPoin += $q->poin;
            $jawSiswa   = $jawaban[$q->id] ?? null;

            if ($q->tipe === 'uraian') {
                $uraian++;
                $detail[$q->id] = [
                    'jawaban' => $jawSiswa,
                    'benar'   => null, // dinilai manual
                    'poin'    => 0,
                ];
            } else {
                $isBenar = $jawSiswa && strtoupper($jawSiswa) === strtoupper($q->jawaban_benar);
                if ($isBenar) {
                    $skor += $q->poin;
                    $benar++;
                } else {
                    $salah++;
                }
                $detail[$q->id] = [
                    'jawaban'       => $jawSiswa,
                    'jawaban_benar' => $q->jawaban_benar,
                    'benar'         => $isBenar,
                    'poin'          => $isBenar ? $q->poin : 0,
                ];
            }
        }

        $attempt = QuizAttempt::create([
            'quiz_packet_id' => $packet->id,
            'user_id'        => auth()->id(),
            'skor'           => $skor,
            'total_poin'     => $totalPoin,
            'benar'          => $benar,
            'salah'          => $salah,
            'uraian_count'   => $uraian,
            'jawaban'        => $detail,
            'selesai_at'     => now(),
        ]);

        return redirect()->route('siswa.quiz.hasil', $attempt);
    }

    // Halaman hasil
    public function hasil(QuizAttempt $attempt)
    {
        if ($attempt->user_id !== auth()->id()) abort(403);
        $attempt->load('packet.questions');
        return view('siswa.quiz.hasil', compact('attempt'));
    }

    // Riwayat semua attempt siswa
    public function riwayat()
    {
        $attempts = QuizAttempt::where('user_id', auth()->id())
            ->with('packet')
            ->latest()
            ->paginate(10);

        return view('siswa.quiz.riwayat', compact('attempts'));
    }
}