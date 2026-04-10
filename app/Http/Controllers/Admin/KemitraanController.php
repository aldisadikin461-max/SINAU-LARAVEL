<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kemitraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KemitraanController extends Controller
{
    public function index()
    {
        $mitra = Kemitraan::orderBy('nama')->paginate(12);
        return view('admin.kemitraan.index', compact('mitra'));
    }

    public function create()
    {
        return view('admin.kemitraan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'          => 'required|string|max:255',
            'logo'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'bidang'        => 'required|string|max:255',
            'link_website'  => 'nullable|url|max:500',
            'lowongan'      => 'nullable|string',
            'link_lowongan' => 'nullable|url|max:500',
        ], [
            'nama.required'   => 'Nama mitra wajib diisi.',
            'bidang.required' => 'Bidang kerja sama wajib diisi.',
            'logo.image'      => 'File harus berupa gambar.',
            'logo.max'        => 'Logo maksimal 2MB.',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('kemitraan', 'public');
        }

        Kemitraan::create($data);
        return redirect()->route('admin.kemitraan.index')->with('success', 'Mitra berhasil ditambahkan!');
    }

    public function edit(Kemitraan $kemitraan)
    {
        return view('admin.kemitraan.edit', compact('kemitraan'));
    }

    public function update(Request $request, Kemitraan $kemitraan)
    {
        $data = $request->validate([
            'nama'          => 'required|string|max:255',
            'logo'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'bidang'        => 'required|string|max:255',
            'link_website'  => 'nullable|url|max:500',
            'lowongan'      => 'nullable|string',
            'link_lowongan' => 'nullable|url|max:500',
        ]);

        if ($request->hasFile('logo')) {
            // Hapus logo lama
            if ($kemitraan->logo) {
                Storage::disk('public')->delete($kemitraan->logo);
            }
            $data['logo'] = $request->file('logo')->store('kemitraan', 'public');
        }

        $kemitraan->update($data);
        return redirect()->route('admin.kemitraan.index')->with('success', 'Data mitra berhasil diupdate!');
    }

    public function destroy(Kemitraan $kemitraan)
    {
        if ($kemitraan->logo) {
            Storage::disk('public')->delete($kemitraan->logo);
        }
        $kemitraan->delete();
        return back()->with('success', 'Mitra berhasil dihapus.');
    }
}