<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use App\Models\QuizPacket;   // ← ini yang kurang
use App\Models\QuizQuestion;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('nama_kategori')->get();

        $questions = Question::with('category')
            ->when(request('search'), fn($q) => $q->where('pertanyaan', 'like', '%'.request('search').'%'))
            ->when(request('category_id'), fn($q) => $q->where('category_id', request('category_id')))
            ->when(request('tingkat'), fn($q) => $q->where('tingkat_kesulitan', request('tingkat')))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('guru.questions.index', compact('questions', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('nama_kategori')->get();
        return view('guru.questions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pertanyaan'       => 'required|string',
            'opsi_a'           => 'required|string',
            'opsi_b'           => 'required|string',
            'opsi_c'           => 'required|string',
            'opsi_d'           => 'required|string',
            'jawaban_benar'    => 'required|in:A,B,C,D',
            'tingkat_kesulitan'=> 'required|in:mudah,sedang,sulit',
            'category_id'      => 'nullable|exists:categories,id',
        ]);

        Question::create($validated);

        return redirect()->route('guru.questions.index')
            ->with('success', 'Soal berhasil ditambahkan.');
    }

    public function edit(Question $question)
    {
        $categories = Category::orderBy('nama_kategori')->get();
        return view('guru.questions.edit', compact('question', 'categories'));
    }

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'pertanyaan'       => 'required|string',
            'opsi_a'           => 'required|string',
            'opsi_b'           => 'required|string',
            'opsi_c'           => 'required|string',
            'opsi_d'           => 'required|string',
            'jawaban_benar'    => 'required|in:A,B,C,D',
            'tingkat_kesulitan'=> 'required|in:mudah,sedang,sulit',
            'category_id'      => 'nullable|exists:categories,id',
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