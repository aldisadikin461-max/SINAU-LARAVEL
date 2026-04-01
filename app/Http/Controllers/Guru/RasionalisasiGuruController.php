<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Rasionalisasi;
use App\Models\User;
use Illuminate\Http\Request;

class RasionalisasiGuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Rasionalisasi::with('user')
            ->whereHas('user', fn($q) => $q->where('role', 'siswa'));

        if ($request->mode && in_array($request->mode, ['kuliah', 'kerja'])) {
            $query->where('mode', $request->mode);
        }

        if ($request->jurusan) {
            $query->whereHas('user', fn($q) => $q->where('jurusan', $request->jurusan));
        }

        if ($request->search) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$request->search}%"));
        }

        $riwayat = $query->latest()->paginate(15)->withQueryString();

        // Statistik
        $totalKuliah = Rasionalisasi::whereHas('user', fn($q) => $q->where('role', 'siswa'))
            ->where('mode', 'kuliah')->count();
        $totalKerja = Rasionalisasi::whereHas('user', fn($q) => $q->where('role', 'siswa'))
            ->where('mode', 'kerja')->count();
        $rataScore = Rasionalisasi::whereHas('user', fn($q) => $q->where('role', 'siswa'))
            ->whereNotNull('skor_kesiapan')->avg('skor_kesiapan');

        return view('guru.rasionalisasi.index', compact(
            'riwayat', 'totalKuliah', 'totalKerja', 'rataScore'
        ));
    }

    public function show($id)
    {
        $rasi = Rasionalisasi::with('user')
            ->whereHas('user', fn($q) => $q->where('role', 'siswa'))
            ->findOrFail($id);

        return view('guru.rasionalisasi.show', compact('rasi'));
    }
}
