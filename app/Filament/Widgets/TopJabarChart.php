<?php

namespace App\Filament\Widgets;

use App\Models\TlJabar;
use Filament\Widgets\ChartWidget;

class TopJabarChart extends ChartWidget
{
    protected static ?string $heading = 'Top 10 Tindak Lanjut IPDA Provinsi Jabar';

    public function getColumnSpan(): array|string|int
    {
        return 'full';
    }

    protected function getData(): array
    {
        $latest = TlJabar::select('tahun', 'semester')
            ->orderByDesc('tahun')
            ->orderByDesc('semester')
            ->first();

        if (! $latest) {
            return ['datasets' => [], 'labels' => []];
        }

        $records = TlJabar::where('tahun', $latest->tahun)
            ->where('semester', $latest->semester)
            ->orderByDesc('persentase_tl')
            ->limit(10)
            ->get(['nama_skpd', 'persentase_tl']);

        return [
            'datasets' => [
                [
                    'backgroundColor' => '#10B981',
                    'borderColor' => '#059669',
                    'borderWidth' => 2,
                    'label' => 'Persentase TL (%)',
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
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'grid' => ['color' => 'rgba(0,0,0,0.08)'],
                ],
                'y' => [
                    'grid' => ['display' => false],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
