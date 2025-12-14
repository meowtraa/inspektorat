<?php

namespace App\Filament\Resources\McpAreaScoreResource\Widgets;

use App\Models\McpAreaScore;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class McpTotalSummary extends StatsOverviewWidget
{
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $tahun = McpAreaScore::max('tahun');

        if (! $tahun) {
            return [
                Stat::make('Nilai MCP', '0')
                    ->description('Belum ada data'),
            ];
        }

        $avg = McpAreaScore::where('tahun', $tahun)->avg('persentase');

        return [
            Stat::make('Nilai MCP', number_format($avg, 1))
                ->description("Tahun {$tahun}")
                ->color(
                    $avg >= 80 ? 'success'
                        : ($avg >= 60 ? 'warning' : 'danger')
                ),
        ];
    }
}
