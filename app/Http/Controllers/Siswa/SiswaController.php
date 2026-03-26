<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Events\SoalDijawab;
use App\Models\Category;
use App\Models\Ebook;
use App\Models\Question;
use App\Models\Scholarship;
use App\Models\Streak;
use App\Models\StudyPlan;
use App\Models\UserAnswer;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    // ── Dashboard ─────────────────────────────────────────────────
    public function dashboard(Request $request)
    {
        $user       = auth()->user();
        $streak     = $user->streak;
        $categories = Category::all();

        $ebooks = Ebook::with('category')
            ->when($request->search, fn($q) => $q->where('judul', 'like', "%{$request->search}%"))
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $badges        = $user->userBadges()->with('badge')->latest()->get();
        $notifications = $user->notifications()->where('is_read', false)->latest()->take(5)->get();

        return view('siswa.dashboard', compact(
            'user', 'streak', 'ebooks', 'categories', 'badges', 'notifications'
        ));
    }

    // ── Latihan Soal ──────────────────────────────────────────────
    public function latihanSoal(Request $request)
    {
        $user       = auth()->user();
        $categories = Category::all();

        $soal = Question::with('category')
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->tingkat, fn($q) => $q->where('tingkat_kesulitan', $request->tingkat))
            ->inRandomOrder()
            ->first();

        return view('siswa.latihan', compact('soal', 'categories'));
    }

    public function jawabSoal(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'jawaban'     => 'required|in:a,b,c,d',
        ]);

        $user     = auth()->user();
        $question = Question::findOrFail($request->question_id);
        $benar    = $request->jawaban === $question->jawaban_benar;

        $answer = UserAnswer::create([
            'user_id'     => $user->id,
            'question_id' => $question->id,
            'jawaban'     => $request->jawaban,
            'is_correct'  => $benar,
            'answered_at' => now(),
        ]);

        // Trigger events (streak, poin, badge, quest)
        SoalDijawab::dispatch($user, $answer);

        return response()->json([
            'benar'         => $benar,
            'jawaban_benar' => $question->jawaban_benar,
            'streak'        => $user->fresh()->streak?->streak_count ?? 0,
        ]);
    }

    // ── Leaderboard ───────────────────────────────────────────────
    public function leaderboard(Request $request)
    {
        $user  = auth()->user();
        $tab   = $request->tab ?? 'sekolah';

        $query = Streak::with('user')->orderByDesc('streak_count');

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

        $threads = \App\Models\Forum::with(['user', 'category', 'replies'])
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

        \App\Models\Forum::create(array_merge($validated, ['user_id' => auth()->id()]));

        return redirect()->route('siswa.forum')->with('success', 'Thread berhasil dibuat!');
    }

    public function storeReply(Request $request, \App\Models\Forum $forum)
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

    // ── Notifikasi mark read ──────────────────────────────────────
    public function markNotifRead(Request $request)
    {
        auth()->user()->notifications()->update(['is_read' => true]);
        return response()->json(['ok' => true]);
    }
}
