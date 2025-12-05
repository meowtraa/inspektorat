<?php

namespace App\Filament\Widgets;

use App\Models\TlBpk;
use Filament\Widgets\ChartWidget;

class TopBpkChart extends ChartWidget
{
    protected static ?string $heading = '📈 Top 10 TL BPK';

    protected function getData(): array
    {
        $latest = TlBpk::select('tahun', 'semester')
            ->orderBy('tahun', 'desc')
            ->orderBy('semester', 'desc')
            ->first();

        $query = TlBpk::where('tahun', $latest->tahun)
            ->where('semester', $latest->semester);

        return [
            'datasets' => [
                [
                    'label' => 'Persentase TL (%)',
                    'data' => $query->orderBy('persentase_tl', 'desc')
                        ->limit(10)
                        ->pluck('persentase_tl')
                        ->toArray(),
                ],
            ],
            'labels' => $query->orderBy('persentase_tl', 'desc')
                ->limit(10)
                ->pluck('nama_skpd')
                ->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
