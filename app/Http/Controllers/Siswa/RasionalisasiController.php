<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Rasionalisasi;
use App\Models\RasionalisasiBookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RasionalisasiController extends Controller
{
    const JURUSAN = ['AKL', 'MPLB', 'PPLG', 'PM', 'TF', 'TJKT', 'DKV'];

    const SKILLS = [
        'Pemrograman Web', 'Desain Grafis', 'Jaringan Komputer', 'Akuntansi',
        'Microsoft Office', 'Video Editing', 'Fotografi', 'Public Speaking',
        'Administrasi', 'Marketing Digital', 'Customer Service', 'Coding Python',
        'Database (SQL)', 'Animasi', 'Ilustrasi Digital', 'Teknik Furniture',
    ];

    // ── Index ─────────────────────────────────────────────────────
    public function index()
    {
        $riwayat = Rasionalisasi::where('user_id', auth()->id())
            ->latest()->take(3)->get();
        return view('siswa.rasionalisasi.index', compact('riwayat'));
    }

    // ── Form Kuliah ───────────────────────────────────────────────
    public function formKuliah()
    {
        return view('siswa.rasionalisasi.form-kuliah', [
            'jurusanList' => self::JURUSAN,
        ]);
    }

    // ── Form Kerja ────────────────────────────────────────────────
    public function formKerja()
    {
        return view('siswa.rasionalisasi.form-kerja', [
            'jurusanList' => self::JURUSAN,
            'skillList'   => self::SKILLS,
        ]);
    }

    // ── Proses Kuliah ─────────────────────────────────────────────
    public function prosesKuliah(Request $request)
    {
        $validated = $request->validate([
            'jurusan'            => 'required|in:' . implode(',', self::JURUSAN),
            'nilai_b_inggris'    => 'required|numeric|min:0|max:100',
            'nilai_b_indonesia'  => 'required|numeric|min:0|max:100',
            'nilai_matematika'   => 'required|numeric|min:0|max:100',
            'nilai_sejarah'      => 'required|numeric|min:0|max:100',
            'nilai_pancasila'    => 'required|numeric|min:0|max:100',
            'nilai_b_jawa'       => 'required|numeric|min:0|max:100',
            'nilai_produktif'    => 'required|numeric|min:0|max:100',
        ]);

        $nilai = [
            'B. Inggris'          => (float) $validated['nilai_b_inggris'],
            'B. Indonesia'        => (float) $validated['nilai_b_indonesia'],
            'Matematika'          => (float) $validated['nilai_matematika'],
            'Sejarah'             => (float) $validated['nilai_sejarah'],
            'Pendidikan Pancasila'=> (float) $validated['nilai_pancasila'],
            'B. Jawa'             => (float) $validated['nilai_b_jawa'],
        ];

        $mapelTerkuat = array_key_max($nilai);
        $rataMapel    = round(array_sum($nilai) / count($nilai), 2);
        $rataAll      = round(($rataMapel + $validated['nilai_produktif']) / 2, 2);

        $prompt = "Kamu adalah konselor pendidikan SMK Indonesia yang berpengalaman. Berdasarkan data berikut, berikan rekomendasi jurusan kuliah dan kampus yang relevan untuk siswa SMKN 1 Purwokerto. Balas HANYA dengan JSON valid tanpa teks lain, tanpa markdown, tanpa backtick.

Data siswa:
- Jurusan SMK: {$validated['jurusan']}
- Nilai B.Inggris: {$nilai['B. Inggris']}
- Nilai B.Indonesia: {$nilai['B. Indonesia']}
- Nilai Matematika: {$nilai['Matematika']}
- Nilai Sejarah: {$nilai['Sejarah']}
- Nilai Pendidikan Pancasila: {$nilai['Pendidikan Pancasila']}
- Nilai B.Jawa: {$nilai['B. Jawa']}
- Rata-rata nilai produktif/jurusan: {$validated['nilai_produktif']}
- Mapel terkuat: {$mapelTerkuat} (nilai: {$nilai[$mapelTerkuat]})
- Rata-rata mapel umum: {$rataMapel}
- Rata-rata keseluruhan: {$rataAll}

Format JSON response (wajib ikuti persis):
{\"skor_kesiapan\":75,\"ringkasan\":\"string 2-3 kalimat\",\"tingkat_peluang\":\"Tinggi\",\"mapel_terkuat\":\"nama mapel\",\"rekomendasi_jurusan\":[{\"nama_prodi\":\"nama\",\"relevansi\":\"alasan\",\"prospek_karir\":[\"karir1\",\"karir2\",\"karir3\"],\"kampus\":[{\"nama\":\"nama kampus\",\"kota\":\"kota\",\"link\":\"https://...\",\"akreditasi\":\"A\",\"keterangan\":\"info singkat\"},{\"nama\":\"nama kampus\",\"kota\":\"kota\",\"link\":\"https://...\",\"akreditasi\":\"A\",\"keterangan\":\"info singkat\"},{\"nama\":\"nama kampus\",\"kota\":\"kota\",\"link\":\"https://...\",\"akreditasi\":\"B\",\"keterangan\":\"info singkat\"}]}],\"action_plan\":[\"langkah1\",\"langkah2\",\"langkah3\",\"langkah4\",\"langkah5\"],\"tips_utbk\":[\"tip1\",\"tip2\",\"tip3\"]}

Berikan tepat 5 rekomendasi jurusan. Pastikan link kampus adalah URL nyata dan valid.";

        $hasilAi = $this->panggilGroq($prompt);

        if (!$hasilAi) {
            return back()->withErrors(['ai' => 'Gagal menghubungi AI. Coba lagi dalam beberapa saat.'])->withInput();
        }

        $rasi = Rasionalisasi::create([
            'user_id'        => auth()->id(),
            'mode'           => 'kuliah',
            'input_data'     => array_merge($validated, [
                'nilai_list'   => $nilai,
                'mapel_terkuat'=> $mapelTerkuat,
                'rata_rata'    => $rataAll,
            ]),
            'hasil_ai'       => $hasilAi,
            'skor_kesiapan'  => $hasilAi['skor_kesiapan'] ?? null,
            'status'         => 'selesai',
        ]);

        return redirect()->route('siswa.rasionalisasi.hasil', $rasi->id);
    }

    // ── Proses Kerja ──────────────────────────────────────────────
    public function prosesKerja(Request $request)
    {
        $validated = $request->validate([
            'jurusan' => 'required|in:' . implode(',', self::JURUSAN),
            'skills'  => 'required|array|min:1',
            'skills.*'=> 'string',
            'minat'   => 'required|in:Industri,Startup,Pemerintah,Wirausaha,Freelance',
        ]);

        $skillsStr = implode(', ', $validated['skills']);

        $prompt = "Kamu adalah konselor karir SMK Indonesia yang berpengalaman. Berikan rekomendasi karir dan perusahaan untuk lulusan SMK. Balas HANYA dengan JSON valid tanpa teks lain, tanpa markdown, tanpa backtick.

Data siswa:
- Jurusan SMK: {$validated['jurusan']}
- Skill yang dikuasai: {$skillsStr}
- Minat kerja: {$validated['minat']}

Format JSON response (wajib ikuti persis):
{\"skor_kesiapan\":70,\"ringkasan\":\"string 2-3 kalimat\",\"rekomendasi_karir\":[{\"posisi\":\"nama jabatan\",\"deskripsi\":\"deskripsi singkat\",\"gaji_entry\":\"Rp 4-6 juta/bulan\",\"persyaratan\":[\"req1\",\"req2\",\"req3\"],\"perusahaan\":[{\"nama\":\"nama perusahaan\",\"kota\":\"kota\",\"link\":\"https://...\",\"cara_melamar\":\"cara\"},{\"nama\":\"nama perusahaan\",\"kota\":\"kota\",\"link\":\"https://...\",\"cara_melamar\":\"cara\"},{\"nama\":\"nama perusahaan\",\"kota\":\"kota\",\"link\":\"https://...\",\"cara_melamar\":\"cara\"}]}],\"road_map\":[{\"periode\":\"0-6 bulan\",\"fokus\":\"fokus utama\",\"kegiatan\":[\"kegiatan1\",\"kegiatan2\"]},{\"periode\":\"6-12 bulan\",\"fokus\":\"fokus utama\",\"kegiatan\":[\"kegiatan1\",\"kegiatan2\"]},{\"periode\":\"1-3 tahun\",\"fokus\":\"fokus utama\",\"kegiatan\":[\"kegiatan1\",\"kegiatan2\"]}],\"action_plan\":[\"langkah1\",\"langkah2\",\"langkah3\",\"langkah4\",\"langkah5\"],\"sertifikasi_rekomendasi\":[\"sertif1\",\"sertif2\",\"sertif3\"]}

Berikan tepat 5 rekomendasi karir yang relevan.";

        $hasilAi = $this->panggilGroq($prompt);

        if (!$hasilAi) {
            return back()->withErrors(['ai' => 'Gagal menghubungi AI. Coba lagi dalam beberapa saat.'])->withInput();
        }

        $rasi = Rasionalisasi::create([
            'user_id'       => auth()->id(),
            'mode'          => 'kerja',
            'input_data'    => $validated,
            'hasil_ai'      => $hasilAi,
            'skor_kesiapan' => $hasilAi['skor_kesiapan'] ?? null,
            'status'        => 'selesai',
        ]);

        return redirect()->route('siswa.rasionalisasi.hasil', $rasi->id);
    }

    // ── Hasil ─────────────────────────────────────────────────────
    public function hasil($id)
    {
        $rasi = Rasionalisasi::where('user_id', auth()->id())
            ->findOrFail($id);

        $bookmarkedNames = RasionalisasiBookmark::where('user_id', auth()->id())
            ->where('rasionalisasi_id', $id)
            ->pluck('nama')
            ->toArray();

        return view('siswa.rasionalisasi.hasil', compact('rasi', 'bookmarkedNames'));
    }

    // ── Riwayat ───────────────────────────────────────────────────
    public function riwayat(Request $request)
    {
        $query = Rasionalisasi::where('user_id', auth()->id())->latest();

        if ($request->mode && in_array($request->mode, ['kuliah', 'kerja'])) {
            $query->where('mode', $request->mode);
        }

        $riwayat = $query->paginate(10)->withQueryString();

        return view('siswa.rasionalisasi.riwayat', compact('riwayat'));
    }

    // ── Bandingkan ────────────────────────────────────────────────
    public function bandingkan(Request $request)
    {
        $semua = Rasionalisasi::where('user_id', auth()->id())
            ->latest()->get();

        $kiri  = null;
        $kanan = null;

        if ($request->kiri && $request->kanan) {
            $kiri  = Rasionalisasi::where('user_id', auth()->id())->find($request->kiri);
            $kanan = Rasionalisasi::where('user_id', auth()->id())->find($request->kanan);
        }

        return view('siswa.rasionalisasi.bandingkan', compact('semua', 'kiri', 'kanan'));
    }

    // ── Bookmark ──────────────────────────────────────────────────
    public function bookmark(Request $request)
    {
        $request->validate([
            'rasionalisasi_id' => 'required|exists:rasionalisasi,id',
            'tipe'             => 'required|in:kampus,karir',
            'nama'             => 'required|string|max:255',
            'link'             => 'nullable|string',
            'data_extra'       => 'nullable|array',
        ]);

        $existing = RasionalisasiBookmark::where('user_id', auth()->id())
            ->where('rasionalisasi_id', $request->rasionalisasi_id)
            ->where('nama', $request->nama)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['status' => 'removed', 'message' => 'Bookmark dihapus']);
        }

        RasionalisasiBookmark::create([
            'user_id'          => auth()->id(),
            'rasionalisasi_id' => $request->rasionalisasi_id,
            'tipe'             => $request->tipe,
            'nama'             => $request->nama,
            'link'             => $request->link,
            'data_extra'       => $request->data_extra,
        ]);

        return response()->json(['status' => 'added', 'message' => 'Disimpan ke bookmark!']);
    }

    // ── Destroy ───────────────────────────────────────────────────
    public function destroy($id)
    {
        $rasi = Rasionalisasi::where('user_id', auth()->id())->findOrFail($id);
        $rasi->delete();

        return redirect()->route('siswa.rasionalisasi.riwayat')
            ->with('success', 'Hasil rasionalisasi berhasil dihapus.');
    }

    // ── Groq API (Gratis) ─────────────────────────────────────────
    private function panggilGroq(string $prompt): ?array
    {
        try {
            $apiKey = env('GROQ_API_KEY');

            if (!$apiKey) {
                \Log::error('GROQ_API_KEY tidak ditemukan di .env');
                return null;
            }

            // Ganti model di bawah dengan model Groq yang valid:
            // Saat ini (2026) model yang direkomendasikan: llama-3.3-70b-versatile
            // Alternatif: llama-3.1-70b-versatile, mixtral-8x7b-32768, gemma2-9b-it
            $response = Http::timeout(60)->withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.3-70b-versatile', // Model yang masih aktif dan gratis
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Kamu adalah konselor pendidikan dan karir SMK Indonesia yang berpengalaman. Berikan rekomendasi dalam format JSON yang diminta.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 2000,
            ]);

            if (!$response->successful()) {
                \Log::error('Groq API Error: ' . $response->body());
                return null;
            }

            $rawText = $response->json()['choices'][0]['message']['content'] ?? '';

            // Bersihkan dari markdown jika ada
            $rawText = preg_replace('/```json\s*|\s*```/', '', $rawText);
            $rawText = trim($rawText);

            $parsed = json_decode($rawText, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                \Log::error('JSON parse error: ' . json_last_error_msg() . ' | Raw: ' . $rawText);
                return null;
            }

            return $parsed;

        } catch (\Exception $e) {
            \Log::error('Groq Exception: ' . $e->getMessage());
            return null;
        }
    }
}