<?php

namespace App\Imports;

use App\Models\TlBpk;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Row;

class TlBpkImport implements OnEachRow, WithStartRow
{
    protected int $tahun;

    protected int $semester;

    public function __construct(int $tahun, int $semester)
    {
        $this->tahun = $tahun;
        $this->semester = $semester;
    }

    /**
     * Data mulai dari ROW 6
     */
    public function startRow(): int
    {
        return 6;
    }

    private function normalize(string $text): string
    {
        $text = trim($text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $text);

        // Normalisasi Kecamatan
        $text = preg_replace(
            '/^(Kecamatan|KECAMATAN|Kec|KEC)\.?[\s]+/u',
            'KECAMATAN ',
            $text
        );

        // Normalisasi Desa
        $text = preg_replace(
            '/^(Desa|DESA|Ds|DS)\.?[\s]+/u',
            'Desa ',
            $text
        );

        $text = preg_replace('/\.+/', '.', $text);

        return $text;
    }

    public function onRow(Row $row): void
    {
        $data = $row->toArray();

        // Kolom A = nomor → DIABAIKAN
        // Kolom B = Nama SKPD
        $namaSkpd = $this->normalize((string) ($data[1] ?? ''));

        if ($namaSkpd === '') {
            return;
        }

        // Guard: pastikan ini baris data, bukan header
        if (! is_numeric($data[2] ?? null)) {
            return;
        }

        TlBpk::updateOrCreate(
            [
                'nama_skpd' => $namaSkpd,
                'tahun' => $this->tahun,
                'semester' => $this->semester,
            ],
            [
                'jumlah_temuan' => (int) ($data[2] ?? 0),
                'jumlah_rekomendasi' => (int) ($data[3] ?? 0),
                'sesuai' => (int) ($data[4] ?? 0),
                'belum_sesuai' => (int) ($data[5] ?? 0),
                'belum_ditindaklanjuti' => (int) ($data[6] ?? 0),
            ]
        );
    }
}
