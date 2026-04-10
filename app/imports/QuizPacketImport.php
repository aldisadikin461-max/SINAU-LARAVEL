<?php

namespace App\Imports;

use App\Models\QuizPacket;
use App\Models\QuizQuestion;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class QuizPacketImport implements WithMultipleSheets
{
    private int $importedSoal = 0;
    private string $packetName = '';

    public function sheets(): array
    {
        return [
            0 => new InfoPaketSheet($this),
            1 => new SoalSheet($this),
        ];
    }

    public function setPacketName(string $name): void
    {
        $this->packetName = $name;
    }

    public function getPacketName(): string
    {
        return $this->packetName;
    }

    public function addSoal(int $count): void
    {
        $this->importedSoal += $count;
    }

    public function getImportedSoal(): int
    {
        return $this->importedSoal;
    }
}


// ── Sheet 1: Info Paket ──────────────────────────────────────────
class InfoPaketSheet implements \Maatwebsite\Excel\Concerns\ToModel,
                                 \Maatwebsite\Excel\Concerns\WithHeadingRow,
                                 \Maatwebsite\Excel\Concerns\SkipsEmptyRows
{
    private QuizPacketImport $parent;
    public ?int $packetId = null;

    public function __construct(QuizPacketImport $parent)
    {
        $this->parent = $parent;
    }

    public function headingRow(): int { return 2; }

    public function model(array $row): ?\Illuminate\Database\Eloquent\Model
    {
        $nama = $row['nama_paket'] ?? $row['nama'] ?? null;
        if (!$nama) return null;

        $status = strtolower(trim($row['status'] ?? 'draft'));
        if (!in_array($status, ['draft', 'published'])) $status = 'draft';

        $packet = QuizPacket::create([
            'guru_id'   => auth()->id(),
            'nama'      => trim($nama),
            'deskripsi' => $row['deskripsi'] ?? null,
            'kelas'     => $row['kelas'] ?? null,
            'jurusan'   => $row['jurusan'] ?? null,
            'status'    => $status,
        ]);

        $this->packetId = $packet->id;
        $this->parent->setPacketName($packet->nama);

        // Simpan packet ID ke session untuk dipakai SoalSheet
        session(['_import_packet_id' => $packet->id]);

        return null; // sudah disimpan manual
    }
}


// ── Sheet 2: Soal ────────────────────────────────────────────────
class SoalSheet implements \Maatwebsite\Excel\Concerns\ToModel,
                            \Maatwebsite\Excel\Concerns\WithHeadingRow,
                            \Maatwebsite\Excel\Concerns\SkipsEmptyRows
{
    private QuizPacketImport $parent;
    private int $urutan = 0;

    public function __construct(QuizPacketImport $parent)
    {
        $this->parent = $parent;
    }

    public function headingRow(): int { return 2; }

    public function model(array $row): ?\Illuminate\Database\Eloquent\Model
    {
        $pertanyaan = $row['pertanyaan'] ?? null;
        if (!$pertanyaan) return null;

        $packetId = session('_import_packet_id');
        if (!$packetId) return null;

        $tipe = strtolower(trim($row['tipe'] ?? 'pilgan'));
        if (!in_array($tipe, ['pilgan', 'benar_salah', 'uraian'])) $tipe = 'pilgan';

        $tingkat = strtolower(trim($row['tingkat'] ?? 'sedang'));
        if (!in_array($tingkat, ['mudah', 'sedang', 'sulit'])) $tingkat = 'sedang';

        $jawaban = $row['jawaban_benar'] ?? null;
        if ($jawaban) $jawaban = trim($jawaban);

        $this->urutan++;
        $urutan = (int)($row['no_urut'] ?? $this->urutan);
        $poin   = (int)($row['poin'] ?? 10);
        if ($poin <= 0) $poin = 10;

        $soal = QuizQuestion::create([
            'quiz_packet_id' => $packetId,
            'pertanyaan'     => trim($pertanyaan),
            'tipe'           => $tipe,
            'opsi_a'         => $row['opsi_a'] ?? null,
            'opsi_b'         => $row['opsi_b'] ?? null,
            'opsi_c'         => $row['opsi_c'] ?? null,
            'opsi_d'         => $row['opsi_d'] ?? null,
            'jawaban_benar'  => $jawaban ?: null,
            'pembahasan'     => $row['pembahasan'] ?? null,
            'tingkat'        => $tingkat,
            'poin'           => $poin,
            'urutan'         => $urutan,
        ]);

        $this->parent->addSoal(1);
        return null;
    }
}