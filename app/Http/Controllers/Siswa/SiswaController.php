<?php

namespace App\Http\Controllers\Siswa;

use App\Events\SoalDijawab;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ebook;
use App\Models\Forum;
use App\Models\Question;
use App\Models\Scholarship;
use App\Models\Streak;
use App\Models\StudyPlan;
use App\Models\UserAnswer;
use App\Services\StreakService;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function __construct(protected StreakService $streakService) {}

    // ── Dashboard ─────────────────────────────────────────────────
    public function dashboard(Request $request)
    {
        $user       = auth()->user();
        $streakData = $this->streakService->getStreakData($user->id);
        $streak     = Streak::where('user_id', $user->id)->first();
        $categories = Category::all();

        $ebooks = Ebook::with('category')
            ->when($request->search, fn($q) => $q->where('judul', 'like', "%{$request->search}%"))
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $badges        = $user->userBadges()->with('badge')->latest()->get();
        $notifications = $user->notifications()->where('is_read', false)->latest()->take(5)->get();

        // Paket soal yang tersedia untuk siswa
        $paketSoal = \App\Models\QuizPacket::where('status', 'published')
            ->where(function ($q) use ($user) {
                $q->whereNull('kelas')->orWhere('kelas', $user->kelas);
            })
            ->where(function ($q) use ($user) {
                $q->whereNull('jurusan')->orWhere('jurusan', $user->jurusan);
            })
            ->withCount('questions')
            ->latest()
            ->take(3)
            ->get();

        return view('siswa.dashboard', compact(
            'user', 'streak', 'streakData', 'ebooks', 'categories',
            'badges', 'notifications', 'paketSoal'
        ));
    }

    // ── Latihan Soal ──────────────────────────────────────────────
    public function latihanSoal(Request $request)
    {
        $user       = auth()->user();
        $categories = Category::all();
        $streakData = $this->streakService->getStreakData($user->id);

        // Soal deterministik berdasarkan hari
        $query = Question::with('category');

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->tingkat) {
            $query->where('tingkat_kesulitan', $request->tingkat);
        }

        $totalSoal = $query->count();

        if ($totalSoal === 0) {
            return view('siswa.latihan', compact('categories', 'streakData'))
                ->with('soal', null)
                ->with('jawabanHariIni', null);
        }

        $hariKe = (int) floor(now()->timestamp / 86400);
        $index  = $hariKe % $totalSoal;
        $soal   = $query->skip($index)->first();

        // Cek sudah jawab hari ini
        $jawabanHariIni = UserAnswer::where('user_id', $user->id)
            ->where('question_id', $soal->id)
            ->whereDate('answered_at', today())
            ->first();

        return view('siswa.latihan', compact(
            'soal', 'categories', 'streakData', 'jawabanHariIni'
        ));
    }

    // ── Jawab Soal ────────────────────────────────────────────────
    public function jawabSoal(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'jawaban'     => 'required|in:a,b,c,d',
        ]);

        $user = auth()->user();

        // Cek sudah jawab hari ini
        $sudahJawab = UserAnswer::where('user_id', $user->id)
            ->where('question_id', $request->question_id)
            ->whereDate('answered_at', today())
            ->first();

        if ($sudahJawab) {
            return response()->json(['error' => 'Kamu sudah menjawab soal ini hari ini.'], 422);
        }

        $question = Question::findOrFail($request->question_id);
        $benar    = $request->jawaban === $question->jawaban_benar;

        $answer = UserAnswer::create([
            'user_id'     => $user->id,
            'question_id' => $question->id,
            'jawaban'     => $request->jawaban,
            'is_correct'  => $benar,
            'answered_at' => now(),
        ]);

        // Activate streak jika diminta lewat session
        if (session('activate_streak')) {
            $this->streakService->activate($user->id);
            session()->forget('activate_streak');
        }

        // Catat aktivitas streak
        $streakResult = $this->streakService->recordActivity($user->id);

        // Dispatch event (untuk poin, badge, quest, notif)
        try {
            SoalDijawab::dispatch($user, $answer);
        } catch (\Exception $e) {
            \Log::warning('SoalDijawab event error: ' . $e->getMessage());
        }

        return response()->json([
            'benar'            => $benar,
            'jawaban_benar'    => $question->jawaban_benar,
            'streak'           => $streakResult['current'],
            'streak_increased' => $streakResult['increased'],
            'streak_active'    => $streakResult['is_active'],
            'was_reset'        => $streakResult['was_reset'],
        ]);
    }

    // ── Activate Streak ───────────────────────────────────────────
    public function activateStreak()
    {
        session(['activate_streak' => true]);
        return redirect()->route('siswa.latihan');
    }

    // ── Recover Streak ────────────────────────────────────────────
    public function recoverStreak()
    {
        $result = $this->streakService->recoverStreak(auth()->id());

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    // ── Leaderboard ───────────────────────────────────────────────
    public function leaderboard(Request $request)
    {
        $user = auth()->user();
        $tab  = $request->tab ?? 'sekolah';

        $query = Streak::with('user')->orderByDesc('current_streak');

        if ($tab === 'jurusan') {
            $query->whereHas('user', fn($q) => $q->where('jurusan', $user->jurusan));
        } elseif ($tab === 'kelas') {
            $query->whereHas('user', fn($q) => $q->where('kelas', $user->kelas));
        }

        $leaderboard = $query->take(20)->get();

        return view('siswa.leaderboard', compact('leaderboard', 'tab'));
    }

    // ── Beasiswa ──────────────────────────────────────────────────
    public function beasiswa(Request $request)
    {
        $user = auth()->user();

        $scholarships = Scholarship::query()
            ->when($request->jenjang, fn($q) => $q->where('jenjang', $request->jenjang))
            ->when($request->tipe, fn($q) => $q->where('tipe', $request->tipe))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->orderBy('deadline')
            ->paginate(10)
            ->withQueryString();

        $bookmarked = $user->bookmarks()->pluck('scholarship_id')->toArray();

        return view('siswa.beasiswa', compact('scholarships', 'bookmarked'));
    }

    public function toggleBookmark(Request $request)
    {
        $request->validate(['scholarship_id' => 'required|exists:scholarships,id']);
        $user = auth()->user();

        $bookmark = $user->bookmarks()->where('scholarship_id', $request->scholarship_id)->first();

        if ($bookmark) {
            $bookmark->delete();
            $status = 'removed';
        } else {
            $user->bookmarks()->create(['scholarship_id' => $request->scholarship_id]);
            $status = 'added';
        }

        return response()->json(['status' => $status]);
    }

    // ── Study Plan ────────────────────────────────────────────────
    public function studyPlan()
    {
        $plans = auth()->user()->studyPlans()->orderBy('target_date')->get();
        return view('siswa.study-plan', compact('plans'));
    }

    public function storeStudyPlan(Request $request)
    {
        $validated = $request->validate([
            'judul'       => 'required|string|max:255',
            'target_date' => 'required|date|after_or_equal:today',
        ]);

        auth()->user()->studyPlans()->create($validated);

        return redirect()->route('siswa.study-plan')
            ->with('success', 'Rencana belajar ditambahkan!');
    }

    public function updateStudyPlan(Request $request, StudyPlan $plan)
    {
        abort_unless($plan->user_id === auth()->id(), 403);
        $plan->update(['status' => $request->status]);
        return response()->json(['ok' => true]);
    }

    public function destroyStudyPlan(StudyPlan $plan)
    {
        abort_unless($plan->user_id === auth()->id(), 403);
        $plan->delete();
        return redirect()->route('siswa.study-plan')->with('success', 'Rencana dihapus.');
    }

    // ── Forum ─────────────────────────────────────────────────────
    public function forum(Request $request)
    {
        $categories = Category::all();

        $threads = Forum::with(['user', 'category', 'replies'])
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('siswa.forum', compact('threads', 'categories'));
    }

    public function storeForum(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'judul'       => 'required|string|max:255',
            'isi'         => 'required|string',
        ]);

        Forum::create(array_merge($validated, ['user_id' => auth()->id()]));

        return redirect()->route('siswa.forum')->with('success', 'Thread berhasil dibuat!');
    }

    public function storeReply(Request $request, Forum $forum)
    {
        $request->validate(['isi' => 'required|string']);

        $forum->replies()->create([
            'user_id' => auth()->id(),
            'isi'     => $request->isi,
        ]);

        return redirect()->back()->with('success', 'Balasan dikirim!');
    }

    // ── Riwayat ───────────────────────────────────────────────────
    public function riwayat()
    {
        $answers = auth()->user()->userAnswers()
            ->with('question.category')
            ->latest('answered_at')
            ->paginate(20);

        return view('siswa.riwayat', compact('answers'));
    }

    // ── Pomodoro ──────────────────────────────────────────────────
    public function pomodoro()
    {
        return view('siswa.pomodoro');
    }

    // ── Notifikasi ────────────────────────────────────────────────
    public function markNotifRead(Request $request)
    {
        auth()->user()->notifications()->update(['is_read' => true]);
        return response()->json(['ok' => true]);
    }
}
