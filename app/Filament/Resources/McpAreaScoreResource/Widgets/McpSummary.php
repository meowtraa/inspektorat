<?php

namespace App\Filament\Resources\McpAreaScoreResource\Widgets;

use App\Models\McpAreaScore;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class McpSummary extends StatsOverviewWidget
{
    protected function getColumns(): int
    {
        return 2; // ⬅️ card card
    }

    protected function getStats(): array
    {
        $tahun = McpAreaScore::max('tahun');

        if (! $tahun) {
            return [];
        }

        return McpAreaScore::with('area')
            ->where('tahun', $tahun)
            ->orderBy('mcp_area_id')
            ->get()
            ->map(function ($row) use ($tahun) {

                return Stat::make(
                    $row->area->name,
                    number_format($row->persentase, 1)
                )
                    ->description("Bobot {$row->bobot}% • {$tahun}")
                    ->color(
                        $row->persentase >= 80 ? 'success'
                            : ($row->persentase >= 60 ? 'warning' : 'danger')
                    );
            })
            ->toArray();
    }
}
