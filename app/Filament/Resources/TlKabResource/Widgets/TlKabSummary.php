<?php

namespace App\Filament\Resources\TlKabResource\Widgets;

use App\Models\TlKab;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TlKabSummary extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        // Ambil tahun & semester TERBARU
        $latest = TlKab::query()
            ->select('tahun', 'semester')
            ->orderByDesc('tahun')
            ->orderByDesc('semester')
            ->first();

        if (! $latest) {
            return [
                Stat::make('Belum Ada Data', '-')
                    ->description('Data TL IPDA Kab. Tasikmalaya belum tersedia')
                    ->color('gray'),
            ];
        }

        // Query data tahun & semester terbaru
        $query = TlKab::query()
            ->where('tahun', $latest->tahun)
            ->where('semester', $latest->semester);

        /* =========================
         * AGREGAT UTAMA
         * ========================= */
        $totalRekomendasi = (int) $query->sum('jumlah_rekomendasi');
        $totalSesuai = (int) $query->sum('sesuai');
        $totalBelumSesuai = (int) $query->sum('belum_sesuai');
        $totalBelumDitindaklanjuti = (int) $query->sum('belum_ditindaklanjuti');

        $avgPersentase = $totalRekomendasi > 0
            ? round(($totalSesuai / $totalRekomendasi) * 100, 2)
            : 0;

        /* =========================
         * KATEGORI SKPD
         * ========================= */
        $records = $query->get();

        $hijau = $records->filter(fn ($r) => $r->persentase_tl >= 80)->count();
        $kuning = $records->filter(
            fn ($r) => $r->persentase_tl >= 60 && $r->persentase_tl < 80
        )->count();
        $merah = $records->filter(fn ($r) => $r->persentase_tl < 60)->count();

        return [

            /* ===== RATA-RATA TL ===== */
            Stat::make(
                'Rata-rata Persentase TL',
                number_format($avgPersentase, 2, ',', '.') . ' %'
            )
                ->description("Tahun {$latest->tahun} • Semester {$latest->semester}")
                ->color(
                    $avgPersentase >= 80
                        ? 'success'
                        : ($avgPersentase >= 60 ? 'warning' : 'danger')
                ),

            /* ===== KATEGORI SKPD ===== */
            Stat::make('SKPD ≥ 80%', $hijau)
                ->description('Sangat Baik')
                ->color('success'),

            Stat::make('SKPD 60–79%', $kuning)
                ->description('Cukup')
                ->color('warning'),

            Stat::make('SKPD < 60%', $merah)
                ->description('Perlu Perhatian')
                ->color('danger'),

            /* ===== TOTAL REKOMENDASI ===== */
            Stat::make(
                'Total Rekomendasi',
                number_format($totalRekomendasi, 0, ',', '.')
            )
                ->description('Seluruh SKPD')
                ->color('primary'),

            /* ===== SESUAI ===== */
            Stat::make(
                'Sesuai',
                number_format($totalSesuai, 0, ',', '.')
            )
                ->description('Rekomendasi')
                ->color('success'),

            /* ===== BELUM SESUAI ===== */
            Stat::make(
                'Belum Sesuai',
                number_format($totalBelumSesuai, 0, ',', '.')
            )
                ->description('Rekomendasi')
                ->color('warning'),

            /* ===== BELUM DITINDAKLANJUTI ===== */
            Stat::make(
                'Belum Ditindaklanjuti',
                number_format($totalBelumDitindaklanjuti, 0, ',', '.')
            )
                ->description('Rekomendasi')
                ->color('danger'),
        ];
    }
}
