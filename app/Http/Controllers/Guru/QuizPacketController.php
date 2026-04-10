<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Imports\QuizPacketImport;
use App\Models\QuizPacket;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class QuizPacketController extends Controller
{
    // Daftar paket soal milik guru ini
    public function index()
    {
        $packets = QuizPacket::where('guru_id', auth()->id())
            ->withCount('questions')
            ->latest()
            ->paginate(10);

        return view('guru.quiz.index', compact('packets'));
    }

    // Form buat paket baru
    public function create()
    {
        return view('guru.quiz.create');
    }

    // Simpan paket baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:255',
            'deskripsi'=> 'nullable|string',
            'kelas'    => 'nullable|string|max:100',
            'jurusan'  => 'nullable|string|max:100',
        ]);

        $packet = QuizPacket::create(array_merge($validated, [
            'guru_id' => auth()->id(),
            'status'  => 'draft',
        ]));

        return redirect()->route('guru.quiz.show', $packet)
            ->with('success', 'Paket soal berhasil dibuat! Sekarang tambahkan soal.');
    }

    // Detail paket + daftar soal
    public function show(QuizPacket $quiz)
    {
        $this->authorize_guru($quiz);
        $quiz->load('questions');
        return view('guru.quiz.show', compact('quiz'));
    }

    // Form edit paket
    public function edit(QuizPacket $quiz)
    {
        $this->authorize_guru($quiz);
        return view('guru.quiz.edit', compact('quiz'));
    }

    // Update paket
    public function update(Request $request, QuizPacket $quiz)
    {
        $this->authorize_guru($quiz);
        $validated = $request->validate([
            'nama'     => 'required|string|max:255',
            'deskripsi'=> 'nullable|string',
            'kelas'    => 'nullable|string|max:100',
            'jurusan'  => 'nullable|string|max:100',
            'status'   => 'required|in:draft,published',
        ]);

        $quiz->update($validated);
        return redirect()->route('guru.quiz.show', $quiz)
            ->with('success', 'Paket soal berhasil diperbarui.');
    }

    // Hapus paket
    public function destroy(QuizPacket $quiz)
    {
        $this->authorize_guru($quiz);
        $quiz->delete();
        return redirect()->route('guru.quiz.index')
            ->with('success', 'Paket soal berhasil dihapus.');
    }

    // ── Import Excel ──────────────────────────────────────────────

    // Form import
    // Seharusnya
public function importForm()
{
    $packets = QuizPacket::where('guru_id', auth()->id())
        ->latest()
        ->paginate(10); // ← ganti get() jadi paginate()

    return view('guru.quiz.import', compact('packets'));
}
    // Proses import Excel
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:5120',
        ], [
            'file.required' => 'Pilih file Excel dulu.',
            'file.mimes'    => 'Format harus .xlsx atau .xls',
            'file.max'      => 'Ukuran file maksimal 5MB',
        ]);

        try {
            $import = new QuizPacketImport();
            Excel::import($import, $request->file('file'));

            $nama  = $import->getPacketName();
            $count = $import->getImportedSoal();

            // Bersihkan session
            session()->forget('_import_packet_id');

            return redirect()->route('guru.quiz.index')
                ->with('success', "✅ Paket \"{$nama}\" berhasil diimport dengan {$count} soal!");

        } catch (\Exception $e) {
            session()->forget('_import_packet_id');
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    // ── Soal ──────────────────────────────────────────────────────

    // Form tambah soal
    public function createQuestion(QuizPacket $quiz)
    {
        $this->authorize_guru($quiz);
        return view('guru.quiz.question-form', compact('quiz'));
    }

    // Simpan soal baru
    public function storeQuestion(Request $request, QuizPacket $quiz)
    {
        $this->authorize_guru($quiz);

        $rules = [
            'pertanyaan'   => 'required|string',
            'tipe'         => 'required|in:pilgan,uraian,benar_salah',
            'tingkat'      => 'required|in:mudah,sedang,sulit',
            'poin'         => 'required|integer|min:1|max:100',
            'pembahasan'   => 'nullable|string',
        ];

        if ($request->tipe === 'pilgan') {
            $rules['opsi_a']        = 'required|string';
            $rules['opsi_b']        = 'required|string';
            $rules['opsi_c']        = 'required|string';
            $rules['opsi_d']        = 'required|string';
            $rules['jawaban_benar'] = 'required|in:A,B,C,D';
        }

        if ($request->tipe === 'benar_salah') {
            $rules['jawaban_benar'] = 'required|in:Benar,Salah';
        }

        $validated = $request->validate($rules);
        $validated['quiz_packet_id'] = $quiz->id;
        $validated['urutan']         = $quiz->questions()->count() + 1;

        QuizQuestion::create($validated);

        if ($request->has('tambah_lagi')) {
            return redirect()->route('guru.quiz.question.create', $quiz)
                ->with('success', 'Soal ditambahkan! Tambah soal lagi.');
        }

        return redirect()->route('guru.quiz.show', $quiz)
            ->with('success', 'Soal berhasil ditambahkan.');
    }

    // Form edit soal
    public function editQuestion(QuizPacket $quiz, QuizQuestion $question)
    {
        $this->authorize_guru($quiz);
        return view('guru.quiz.question-form', compact('quiz', 'question'));
    }

    // Update soal
    public function updateQuestion(Request $request, QuizPacket $quiz, QuizQuestion $question)
    {
        $this->authorize_guru($quiz);

        $rules = [
            'pertanyaan' => 'required|string',
            'tipe'       => 'required|in:pilgan,uraian,benar_salah',
            'tingkat'    => 'required|in:mudah,sedang,sulit',
            'poin'       => 'required|integer|min:1|max:100',
            'pembahasan' => 'nullable|string',
        ];

        if ($request->tipe === 'pilgan') {
            $rules['opsi_a'] = $rules['opsi_b'] = $rules['opsi_c'] = $rules['opsi_d'] = 'required|string';
            $rules['jawaban_benar'] = 'required|in:A,B,C,D';
        }
        if ($request->tipe === 'benar_salah') {
            $rules['jawaban_benar'] = 'required|in:Benar,Salah';
        }

        $question->update($request->validate($rules));

        return redirect()->route('guru.quiz.show', $quiz)
            ->with('success', 'Soal berhasil diperbarui.');
    }

    // Hapus soal
    public function destroyQuestion(QuizPacket $quiz, QuizQuestion $question)
    {
        $this->authorize_guru($quiz);
        $question->delete();
        return redirect()->route('guru.quiz.show', $quiz)
            ->with('success', 'Soal berhasil dihapus.');
    }

    private function authorize_guru(QuizPacket $quiz): void
    {
        if ($quiz->guru_id !== auth()->id()) abort(403);
    }
}