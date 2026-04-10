<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use App\Models\Question;
use App\Models\Streak;
use App\Models\Task;
use App\Models\User;
use App\Models\UserAnswer;
use App\Services\StreakService;

class GuruController extends Controller
{
    public function __construct(protected StreakService $streakService) {}

    public function dashboard()
{
    $totalEbook    = Ebook::count();
    $totalSoal     = Question::count();
    $totalTugas    = Task::where('guru_id', auth()->id())->count();
    $streakHariIni = Streak::whereDate('last_active_date', today())->count();
    $soalDijawab   = UserAnswer::whereDate('answered_at', today())->count();

    // ── Aktivitas Terbaru ──
    $aktivitas = collect();

    Ebook::latest()->take(5)->get()->each(function ($e) use (&$aktivitas) {
        $aktivitas->push([
            'icon'   => '📚',
            'label'  => 'E-Book diupload',
            'detail' => $e->judul ?? '-',
            'time'   => $e->created_at,
        ]);
    });

    Question::latest()->take(5)->get()->each(function ($q) use (&$aktivitas) {
        $aktivitas->push([
            'icon'   => '❓',
            'label'  => 'Soal baru ditambah',
            'detail' => $q->pertanyaan ?? '-',
            'time'   => $q->created_at,
        ]);
    });

    Task::where('guru_id', auth()->id())->latest()->take(5)->get()->each(function ($t) use (&$aktivitas) {
        $aktivitas->push([
            'icon'   => '📝',
            'label'  => 'Tugas di-assign',
            'detail' => $t->judul ?? $t->nama ?? '-',
            'time'   => $t->created_at,
        ]);
    });

    $aktivitas = $aktivitas->sortByDesc('time')->take(8)->values();

    return view('guru.dashboard', compact(
        'totalEbook', 'totalSoal', 'totalTugas',
        'streakHariIni', 'soalDijawab', 'aktivitas'
    ));
}

    public function pregresSiswa()
    {
        $siswaList = User::where('role', 'siswa')
            ->with('streak')
            ->orderBy('name')
            ->get()
            ->map(function ($siswa) {
                $streakData  = $this->streakService->getStreakData($siswa->id);
                $totalSoal   = UserAnswer::where('user_id', $siswa->id)->count();
                $totalBenar  = UserAnswer::where('user_id', $siswa->id)->where('is_correct', true)->count();
                $rataRata    = $totalSoal > 0 ? round($totalBenar / $totalSoal * 100) : 0;

                $siswa->streakData  = $streakData;
                $siswa->totalSoal   = $totalSoal;
                $siswa->rataRata    = $rataRata;

                return $siswa;
            });

        return view('guru.progres', compact('siswaList'));
    }
}
