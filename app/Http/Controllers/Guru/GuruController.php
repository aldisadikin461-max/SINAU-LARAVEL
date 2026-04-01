<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use App\Models\Question;
use App\Models\Streak;
use App\Models\Task;
use App\Models\User;
use App\Models\UserAnswer;
use Illuminate\Support\Collection;

class GuruController extends Controller
{
    public function dashboard()
    {
        $totalEbook    = Ebook::count();
        $totalSoal     = Question::count();
        $totalTugas    = Task::where('guru_id', auth()->id())->count();
        $streakHariIni = Streak::whereDate('last_active_date', today())->count();
        $soalDijawab   = UserAnswer::whereDate('answered_at', today())->count();

        // ── Aktivitas Terbaru (dari database, bukan dummy) ──
        $aktivitas = collect();

        // E-Book terbaru milik guru ini
        Ebook::latest()->take(5)->get()->each(function ($e) use (&$aktivitas) {
            $aktivitas->push([
                'icon'   => '📚',
                'label'  => 'E-Book diupload',
                'detail' => $e->judul ?? $e->title ?? $e->nama ?? '-',
                'time'   => $e->created_at,
            ]);
        });

        // Soal terbaru
        Question::latest()->take(5)->get()->each(function ($q) use (&$aktivitas) {
            $aktivitas->push([
                'icon'   => '❓',
                'label'  => 'Soal baru ditambah',
                'detail' => $q->pertanyaan ?? $q->soal ?? $q->question ?? '-',
                'time'   => $q->created_at,
            ]);
        });

        // Tugas terbaru milik guru ini
        Task::where('guru_id', auth()->id())->latest()->take(5)->get()->each(function ($t) use (&$aktivitas) {
            $aktivitas->push([
                'icon'   => '📝',
                'label'  => 'Tugas di-assign',
                'detail' => ($t->judul ?? $t->title ?? $t->nama ?? '-') . ($t->kelas ? ' · ' . $t->kelas : ''),
                'time'   => $t->created_at,
            ]);
        });

        // Urutkan berdasarkan waktu terbaru, ambil 8
        $aktivitas = $aktivitas->sortByDesc('time')->take(8)->values();

        return view('guru.dashboard', compact(
            'totalEbook', 'totalSoal', 'totalTugas',
            'streakHariIni', 'soalDijawab', 'aktivitas'
        ));
    }

    public function pregresSiswa()
    {
        $siswa = User::where('role', 'siswa')
            ->with(['streak', 'userAnswers'])
            ->orderBy('name')
            ->paginate(15);

        return view('guru.progres', compact('siswa'));
    }
}
