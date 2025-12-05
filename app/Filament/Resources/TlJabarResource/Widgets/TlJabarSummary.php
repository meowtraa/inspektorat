<?php

namespace App\Filament\Resources\TlJabarResource\Widgets;

use App\Models\TlJabar;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TlJabarSummary extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        $avg = TlJabar::avg('persentase_tl') ?? 0;

        $hijau = TlJabar::where('persentase_tl', '>=', 80)->count();
        $kuning = TlJabar::whereBetween('persentase_tl', [60, 79.99])->count();
        $merah = TlJabar::where('persentase_tl', '<', 60)->count();

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
