<?php

namespace App\Imports;

use App\Models\TlKab;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;

class TlKabImport implements OnEachRow
{
    protected int $tahun;

    protected int $semester;

    public function __construct(int $tahun, int $semester)
    {
        $this->tahun = $tahun;
        $this->semester = $semester;
    }

    private function normalize(string $text): string
    {
        $text = trim($text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $text);

        $text = preg_replace('/^(Kecamatan|KECAMATAN|Kec|KEC)\.?[\s]+/i', 'Kecamatan ', $text);
        $text = preg_replace('/^(Desa|DESA|Ds|DS)\.?[\s]+/i', 'Desa ', $text);

        $text = preg_replace('/\.+/', '.', $text);

        return ucwords(strtolower($text));
    }

    public function onRow(Row $row): void
    {
        $data = $row->toArray();

        $nama = $this->normalize($data[0] ?? '');
        $persen = trim($data[1] ?? '0');

        $persen = preg_replace('/[^0-9.,]/', '', $persen);
        $persen = str_replace(',', '.', $persen);

        if ($nama === '' || ! is_numeric($persen)) {
            return;
        }

        TlKab::updateOrCreate(
            [
                'nama_skpd' => $nama,
                'tahun' => $this->tahun,
                'semester' => $this->semester,
            ],
            [
                'persentase_tl' => (float) $persen,
            ]
        );
    }
}
