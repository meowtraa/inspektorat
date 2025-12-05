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
        $avg = TlKab::avg('persentase_tl') ?? 0;

        $hijau = TlKab::where('persentase_tl', '>=', 80)->count();
        $kuning = TlKab::whereBetween('persentase_tl', [60, 79.99])->count();
        $merah = TlKab::where('persentase_tl', '<', 60)->count();

        return [
            Stat::make('Rata-rata Persentase TL', number_format($avg, 2, ',', '.').' %')
                ->color(
                    $avg >= 80 ? 'success'
                        : ($avg >= 60 ? 'warning' : 'danger')
                )
                ->description('Rata-rata semua SKPD'),

            Stat::make('Diatas 80%', $hijau)
                ->color('success')
                ->description('SKPD'),

            Stat::make('60% - 79%', $kuning)
                ->color('warning')
                ->description('SKPD'),

            Stat::make('Dibawah 60%', $merah)
                ->color('danger')
                ->description('SKPD'),
        ];
    }
}
