<?php

namespace App\Imports;

use App\Models\Alumni;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class AlumniImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    private int $imported = 0;

    public function model(array $row): ?Alumni
    {
        // Normalisasi heading: support "Nama", "nama", "NAMA" dll
        $nama       = $row['nama']         ?? $row['name']          ?? null;
        $kampus     = $row['kampus']        ?? $row['universitas']   ?? null;
        $domain     = $row['domain_kampus'] ?? $row['domain']        ?? null;
        $jurusan    = $row['jurusan']       ?? $row['prodi']         ?? null;
        $jalur      = $row['jalur']         ?? $row['jalur_masuk']   ?? 'SNBP';
        $tahun      = $row['tahun_lulus']   ?? $row['tahun']         ?? null;

        if (!$nama || !$kampus || !$tahun) {
            return null;
        }

        // Normalisasi jalur
        $jalurNorm = strtoupper(trim($jalur));
        if (!in_array($jalurNorm, ['SNBP', 'SNBT', 'MANDIRI'])) {
            $jalurNorm = 'SNBP';
        }
        if ($jalurNorm === 'MANDIRI') $jalurNorm = 'Mandiri';

        $this->imported++;

        return new Alumni([
            'nama'         => trim($nama),
            'kampus'       => trim($kampus),
            'domain_kampus'=> $domain ? trim($domain) : null,
            'jurusan'      => trim($jurusan ?? '-'),
            'jalur'        => $jalurNorm,
            'tahun_lulus'  => (int) $tahun,
        ]);
    }

    public function getImportedCount(): int
    {
        return $this->imported;
    }
}