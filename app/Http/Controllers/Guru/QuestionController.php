<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $questions = Question::with('category')
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->tingkat, fn($q) => $q->where('tingkat_kesulitan', $request->tingkat))
            ->when($request->search, fn($q) => $q->where('pertanyaan', 'like', "%{$request->search}%"))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $categories = Category::all();

        return view('guru.questions.index', compact('questions', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('guru.questions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'       => 'required|exists:categories,id',
            'pertanyaan'        => 'required|string',
            'opsi_a'            => 'required|string|max:255',
            'opsi_b'            => 'required|string|max:255',
            'opsi_c'            => 'required|string|max:255',
            'opsi_d'            => 'required|string|max:255',
            'jawaban_benar'     => 'required|in:a,b,c,d',
            'tingkat_kesulitan' => 'required|in:mudah,sedang,sulit',
        ]);

        Question::create($validated);

        return redirect()->route('guru.questions.index')
            ->with('success', 'Soal berhasil ditambahkan.');
    }

    public function edit(Question $question)
    {
        $categories = Category::all();
        return view('guru.questions.edit', compact('question', 'categories'));
    }

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'category_id'       => 'required|exists:categories,id',
            'pertanyaan'        => 'required|string',
            'opsi_a'            => 'required|string|max:255',
            'opsi_b'            => 'required|string|max:255',
            'opsi_c'            => 'required|string|max:255',
            'opsi_d'            => 'required|string|max:255',
            'jawaban_benar'     => 'required|in:a,b,c,d',
            'tingkat_kesulitan' => 'required|in:mudah,sedang,sulit',
        ]);

        $question->update($validated);

        return redirect()->route('guru.questions.index')
            ->with('success', 'Soal berhasil diperbarui.');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('guru.questions.index')
            ->with('success', 'Soal berhasil dihapus.');
    }
}
