<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Kemitraan;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    /**
     * Landing page alumni — pilih Kuliah atau Kemitraan
     */
    public function index()
    {
        $tahunList = Alumni::availableYears();
        return view('siswa.alumni.index', compact('tahunList'));
    }

    /**
     * Halaman alumni kuliah — filter per tahun
     */
    public function kuliah(Request $request)
    {
        $tahunList = Alumni::availableYears();
        $tahun     = $request->tahun ?? ($tahunList[0] ?? date('Y'));

        $alumni = Alumni::where('tahun_lulus', $tahun)
            ->orderBy('nama')
            ->get();

        return view('siswa.alumni.kuliah', compact('alumni', 'tahunList', 'tahun'));
    }

    /**
     * Halaman kemitraan
     */
    public function kemitraan()
    {
        $mitra = Kemitraan::orderBy('nama')->get();
        return view('siswa.alumni.kemitraan', compact('mitra'));
    }
}