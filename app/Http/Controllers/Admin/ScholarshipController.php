<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    public function index(Request $request)
    {
        $scholarships = Scholarship::query()
            ->when($request->jenjang, fn($q) => $q->where('jenjang', $request->jenjang))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.scholarships.index', compact('scholarships'));
    }

    public function create()
    {
        return view('admin.scholarships.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'         => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'jenjang'       => 'required|in:SMA,SMK,S1',
            'tipe'          => 'required|string|max:100',
            'deadline'      => 'required|date',
            'link'          => 'required|url',
            'status'        => 'required|in:buka,tutup',
            'deskripsi'     => 'nullable|string',
        ]);

        Scholarship::create($validated);

        return redirect()->route('admin.scholarships.index')
            ->with('success', 'Beasiswa berhasil ditambahkan.');
    }

    public function edit(Scholarship $scholarship)
    {
        return view('admin.scholarships.edit', compact('scholarship'));
    }

    public function update(Request $request, Scholarship $scholarship)
    {
        $validated = $request->validate([
            'judul'         => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'jenjang'       => 'required|in:SMA,SMK,S1',
            'tipe'          => 'required|string|max:100',
            'deadline'      => 'required|date',
            'link'          => 'required|url',
            'status'        => 'required|in:buka,tutup',
            'deskripsi'     => 'nullable|string',
        ]);

        $scholarship->update($validated);

        return redirect()->route('admin.scholarships.index')
            ->with('success', 'Beasiswa berhasil diperbarui.');
    }

    public function destroy(Scholarship $scholarship)
    {
        $scholarship->delete();
        return redirect()->route('admin.scholarships.index')
            ->with('success', 'Beasiswa berhasil dihapus.');
    }
}
