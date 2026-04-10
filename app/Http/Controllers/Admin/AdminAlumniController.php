<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\AlumniImport;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminAlumniController extends Controller
{
    /**
     * Dashboard alumni — tampil semua data + form import
     */
    public function index(Request $request)
    {
        $tahun  = $request->tahun;
        $search = $request->search;

        $query = Alumni::query();

        if ($tahun) {
            $query->where('tahun_lulus', $tahun);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('kampus', 'like', "%{$search}%")
                  ->orWhere('jurusan', 'like', "%{$search}%");
            });
        }

        $alumni    = $query->orderByDesc('tahun_lulus')->orderBy('nama')->paginate(20)->withQueryString();
        $tahunList = Alumni::availableYears();
        $total     = Alumni::count();

        return view('admin.alumni.index', compact('alumni', 'tahunList', 'tahun', 'search', 'total'));
    }

    /**
     * Import Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ], [
            'file.required' => 'Pilih file Excel dulu ya.',
            'file.mimes'    => 'Format file harus .xlsx, .xls, atau .csv',
            'file.max'      => 'Ukuran file maksimal 5MB',
        ]);

        try {
            $import = new AlumniImport();
            Excel::import($import, $request->file('file'));

            $count = $import->getImportedCount();
            return back()->with('success', "✅ Berhasil import {$count} data alumni!");
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    /**
     * Hapus satu data alumni
     */
    public function destroy(Alumni $alumni)
    {
        $nama = $alumni->nama;
        $alumni->delete();
        return back()->with('success', "Data alumni {$nama} berhasil dihapus.");
    }

    /**
     * Hapus semua alumni per tahun
     */
    public function destroyByTahun(Request $request)
    {
        $request->validate(['tahun' => 'required|integer']);
        $count = Alumni::where('tahun_lulus', $request->tahun)->count();
        Alumni::where('tahun_lulus', $request->tahun)->delete();
        return back()->with('success', "Berhasil hapus {$count} data alumni tahun {$request->tahun}.");
    }

    /**
     * Download template Excel
     */
    public function template()
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_alumni.csv"',
        ];

        $rows = [
            ['Nama', 'Kampus', 'Domain Kampus', 'Jurusan', 'Jalur', 'Tahun Lulus'],
            ['Ahmad Fauzi', 'Universitas Indonesia', 'ui.ac.id', 'Teknik Informatika', 'SNBP', '2024'],
            ['Budi Santoso', 'Institut Teknologi Bandung', 'itb.ac.id', 'Teknik Sipil', 'SNBT', '2024'],
            ['Citra Lestari', 'Universitas Gadjah Mada', 'ugm.ac.id', 'Kedokteran', 'Mandiri', '2023'],
        ];

        $output = fopen('php://output', 'w');
        ob_start();
        foreach ($rows as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
        $content = ob_get_clean();

        return response($content, 200, $headers);
    }
}