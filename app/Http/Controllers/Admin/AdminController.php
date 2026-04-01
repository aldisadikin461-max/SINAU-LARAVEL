<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use App\Models\Forum;
use App\Models\Scholarship;
use App\Models\Streak;
use App\Models\User;
use App\Models\UserAnswer;
use App\Models\UserBadge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ── Dashboard ─────────────────────────────────────────────────
    public function dashboard()
    {
        $stats = [
            'total_siswa'    => User::where('role', 'siswa')->count(),
            'total_guru'     => User::where('role', 'guru')->count(),
            'total_ebook'    => Ebook::count(),
            'total_beasiswa' => Scholarship::count(),
            'total_forum'    => Forum::count(),
            'siswa_aktif'    => Streak::whereDate('last_active_date', today())
                                    ->whereHas('user', fn($q) => $q->where('role', 'siswa'))
                                    ->count(),
            'soal_hari_ini'  => UserAnswer::whereDate('answered_at', today())->count(),
            'badge_hari_ini' => UserBadge::whereDate('created_at', today())->count(),
            'beasiswa_buka'  => Scholarship::where('status', 'buka')->count(),
        ];

        $topStreak = User::where('role', 'siswa')
            ->with('streak')
            ->get()
            ->sortByDesc(fn($u) => $u->streak?->streak_count ?? 0)
            ->take(5)
            ->values();

        $streakWarning = User::where('role', 'siswa')
            ->with('streak')
            ->whereHas('streak', fn($q) => $q->whereDate('last_active_date', today()->subDay()))
            ->take(5)
            ->get();

        $recentSiswa = User::where('role', 'siswa')->latest()->take(5)->get();

        $chartAktif = collect(range(6, 0))->map(fn($i) => [
            'label' => today()->subDays($i)->format('d/m'),
            'count' => Streak::whereDate('last_active_date', today()->subDays($i))
                            ->whereHas('user', fn($q) => $q->where('role', 'siswa'))
                            ->count(),
        ])->values();

        $chartSoal = collect(range(6, 0))->map(fn($i) => [
            'label' => today()->subDays($i)->format('d/m'),
            'count' => UserAnswer::whereDate('answered_at', today()->subDays($i))->count(),
        ])->values();

        $chartLevel = User::where('role', 'siswa')
            ->selectRaw('level, COUNT(*) as total')
            ->groupBy('level')
            ->pluck('total', 'level')
            ->toArray();

        return view('admin.dashboard', compact(
            'stats', 'topStreak', 'streakWarning',
            'recentSiswa', 'chartAktif', 'chartSoal', 'chartLevel'
        ));
    }

    // ── Kelola User ───────────────────────────────────────────────
    public function users(Request $request)
    {
        $users = User::query()
            ->when($request->role, fn($q) => $q->where('role', $request->role))
            ->when($request->search, fn($q) => $q
                ->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%"))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role'     => 'required|in:admin,guru,siswa',
            'jurusan'  => 'nullable|string|max:100',
            'kelas'    => 'nullable|string|max:20',
            'phone'    => 'nullable|string|max:20',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
            'jurusan'  => $validated['jurusan'] ?? null,
            'kelas'    => $validated['kelas'] ?? null,
            'phone'    => $validated['phone'] ?? null,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User baru berhasil ditambahkan.');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role'     => 'required|in:admin,guru,siswa',
            'jurusan'  => 'nullable|string|max:100',
            'kelas'    => 'nullable|string|max:20',
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->update([
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'role'    => $validated['role'],
            'jurusan' => $validated['jurusan'] ?? null,
            'kelas'   => $validated['kelas'] ?? null,
            'phone'   => $validated['phone'] ?? null,
        ]);

        // Update password hanya jika diisi
        if (!empty($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroyUser(User $user)
    {
        // Jangan hapus diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    // ── Statistik ─────────────────────────────────────────────────
    public function statistik()
    {
        $soalPerHari = UserAnswer::selectRaw('DATE(answered_at) as tanggal, COUNT(*) as total')
            ->where('answered_at', '>=', now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $distribusiRole = User::selectRaw('role, COUNT(*) as total')
            ->groupBy('role')
            ->pluck('total', 'role');

        return view('admin.statistik', compact('soalPerHari', 'distribusiRole'));
    }
}
