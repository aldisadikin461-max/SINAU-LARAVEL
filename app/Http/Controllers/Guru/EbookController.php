<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EbookController extends Controller
{
    public function index(Request $request)
    {
        $ebooks = Ebook::with('category')
            ->when($request->search, fn($q) => $q->where('judul', 'like', "%{$request->search}%"))
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        $categories = Category::all();

        return view('guru.ebooks.index', compact('ebooks', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('guru.ebooks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'judul'       => 'required|string|max:255',
            'penulis'     => 'required|string|max:255',
            'jurusan'     => 'nullable|string|max:100',
            'file'        => 'required|mimes:pdf|max:20480',
            'cover'       => 'nullable|image|max:2048',
        ]);

        $filePath  = $request->file('file')->store('ebooks', 'public');
        $coverPath = $request->hasFile('cover')
            ? $request->file('cover')->store('ebook-covers', 'public')
            : null;

        Ebook::create([
            'category_id' => $validated['category_id'],
            'judul'       => $validated['judul'],
            'penulis'     => $validated['penulis'],
            'jurusan'     => $validated['jurusan'],
            'file_path'   => $filePath,
            'cover'       => $coverPath,
        ]);

        return redirect()->route('guru.ebooks.index')
            ->with('success', 'E-book berhasil diunggah.');
    }

    public function edit(Ebook $ebook)
    {
        $categories = Category::all();
        return view('guru.ebooks.edit', compact('ebook', 'categories'));
    }

    public function update(Request $request, Ebook $ebook)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'judul'       => 'required|string|max:255',
            'penulis'     => 'required|string|max:255',
            'jurusan'     => 'nullable|string|max:100',
            'file'        => 'nullable|mimes:pdf|max:20480',
            'cover'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($ebook->file_path);
            $validated['file_path'] = $request->file('file')->store('ebooks', 'public');
        }

        if ($request->hasFile('cover')) {
            if ($ebook->cover) Storage::disk('public')->delete($ebook->cover);
            $validated['cover'] = $request->file('cover')->store('ebook-covers', 'public');
        }

        $ebook->update($validated);

        return redirect()->route('guru.ebooks.index')
            ->with('success', 'E-book berhasil diperbarui.');
    }

    public function destroy(Ebook $ebook)
    {
        Storage::disk('public')->delete($ebook->file_path);
        if ($ebook->cover) Storage::disk('public')->delete($ebook->cover);
        $ebook->delete();

        return redirect()->route('guru.ebooks.index')
            ->with('success', 'E-book berhasil dihapus.');
    }
}
