<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class McpAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            'Perencanaan & Penganggaran APBD',
            'Pengadaan Barang/Jasa (PBJ)',
            'Perizinan / Pelayanan Publik',
            'APIP',
            'Manajemen ASN',
            'Optimalisasi PAD',
            'Manajemen Aset Daerah',
            'Tata Kelola Pemerintahan Desa',
        ];

        foreach ($areas as $area) {
            \App\Models\McpArea::create(['name' => $area]);
        }
    }
}
