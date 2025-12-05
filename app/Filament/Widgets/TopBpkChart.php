<?php

namespace App\Filament\Widgets;

use App\Models\TlBpk;
use Filament\Widgets\ChartWidget;

class TopBpkChart extends ChartWidget
{
    protected static ?string $heading = 'Top 10 Tindak Lanjut BPK';

    public function getColumnSpan(): array|string|int
    {
        return 'full';
    }

    protected function getData(): array
    {
        $latest = TlBpk::select('tahun', 'semester')
            ->orderBy('tahun', 'desc')
            ->orderBy('semester', 'desc')
            ->first();

        if (! $latest) {
            return [
                'datasets' => [['label' => 'Persentase TL (%)', 'data' => []]],
                'labels' => [],
            ];
        }

        $records = TlBpk::where('tahun', $latest->tahun)
            ->where('semester', $latest->semester)
            ->orderBy('persentase_tl', 'desc')
            ->limit(10)
            ->get(['nama_skpd', 'persentase_tl']);

        return [
            'datasets' => [
                [
                    'label' => 'Persentase TL (%)',
                    'backgroundColor' => '#F59E0B',
                    'borderColor' => '#D97706',
                    'borderWidth' => 2,
                    'data' => $records->pluck('persentase_tl')->toArray(),
                ],
            ],
            'labels' => $records->pluck('nama_skpd')->toArray(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'responsive' => true,
            'maintainAspectRatio' => false,

            'plugins' => [
                'legend' => ['display' => false],
                'datalabels' => [
                    'anchor' => 'end',
                    'align' => 'right',
                    'formatter' => 'function(value) { return value + "%" }',
                    'color' => '#000',
                    'font' => ['weight' => 'bold'],
                ],
            ],

            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => 'rgba(0,0,0,0.08)',
                        'drawBorder' => true,
                    ],
                    'border' => [
                        'color' => '#000',
                        'width' => 2,
                    ],
                    'ticks' => [
                        'callback' => 'function(v) { return v + "%" }',
                    ],
                ],
                'y' => [
                    'grid' => ['display' => false],
                    'border' => [
                        'color' => '#000',
                        'width' => 2,
                    ],
                    'ticks' => [
                        'font' => ['size' => 11],
                        'autoSkip' => false,
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
