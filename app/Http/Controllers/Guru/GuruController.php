<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use App\Models\Question;
use App\Models\Streak;
use App\Models\Task;
use App\Models\User;
use App\Models\UserAnswer;

class GuruController extends Controller
{
    public function dashboard()
    {
        $totalEbook     = Ebook::count();
        $totalSoal      = Question::count();
        $totalTugas     = Task::where('guru_id', auth()->id())->count();
        $streakHariIni  = Streak::whereDate('last_active_date', today())->count();
        $soalDijawab    = UserAnswer::whereDate('answered_at', today())->count();

        return view('guru.dashboard', compact(
            'totalEbook', 'totalSoal', 'totalTugas',
            'streakHariIni', 'soalDijawab'
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
