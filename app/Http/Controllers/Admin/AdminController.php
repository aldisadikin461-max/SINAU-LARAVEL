<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use App\Models\Forum;
use App\Models\Scholarship;
use App\Models\Streak;
use App\Models\User;
use App\Models\UserAnswer;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalSiswa     = User::where('role', 'siswa')->count();
        $totalGuru      = User::where('role', 'guru')->count();
        $totalEbook     = Ebook::count();
        $totalBeasiswa  = Scholarship::count();
        $totalForum     = Forum::count();

        $streakHariIni  = Streak::whereDate('last_active_date', today())->count();
        $soalDijawab    = UserAnswer::whereDate('answered_at', today())->count();

        // Leaderboard top 5 streak
        $topStreak = Streak::with('user')
            ->orderByDesc('streak_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalSiswa', 'totalGuru', 'totalEbook',
            'totalBeasiswa', 'totalForum', 'streakHariIni',
            'soalDijawab', 'topStreak'
        ));
    }

    // ── Kelola User ───────────────────────────────────────────────
    public function users(Request $request)
    {
        $users = User::query()
            ->when($request->role, fn($q) => $q->where('role', $request->role))
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%"))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'role'    => 'required|in:admin,guru,siswa',
            'jurusan' => 'nullable|string|max:100',
            'kelas'   => 'nullable|string|max:20',
            'phone'   => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
    }

    // ── Statistik ─────────────────────────────────────────────────
    public function statistik()
    {
        // Soal dijawab per hari (7 hari terakhir)
        $soalPerHari = UserAnswer::selectRaw('DATE(answered_at) as tanggal, COUNT(*) as total')
            ->where('answered_at', '>=', now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Distribusi role
        $distribusiRole = User::selectRaw('role, COUNT(*) as total')
            ->groupBy('role')
            ->pluck('total', 'role');

        return view('admin.statistik', compact('soalPerHari', 'distribusiRole'));
    }
}
