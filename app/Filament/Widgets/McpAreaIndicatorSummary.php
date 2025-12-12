<?php

namespace App\Filament\Widgets;

use App\Models\McpArea;
use App\Models\McpItem;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class McpAreaIndicatorSummary extends BaseWidget
{
    protected function getStats(): array
    {
        // Tahun terbaru dari MCP Item
        $latestYear = McpItem::max('year');

        if (! $latestYear) {
            return [
                Stat::make('Tidak Ada Data', 'Belum ada MCP Item')
                    ->color('gray'),
            ];
        }

        // Ambil semua area
        $areas = McpArea::all();

        $cards = [];

        foreach ($areas as $area) {
            // Total item per area & tahun
            $total = McpItem::where('area_id', $area->id)
                ->where('year', $latestYear)
                ->count();

            // Item complete
            $complete = McpItem::where('area_id', $area->id)
                ->where('year', $latestYear)
                ->where('is_complete', true)
                ->count();

            // Hitung progress %
            $progress = $total > 0
                ? round(($complete / $total) * 100, 1)
                : 0;

            $cards[] = Stat::make($area->name, "{$progress}%")
                ->description("{$complete} dari {$total} item (Tahun {$latestYear})")
                ->descriptionIcon('heroicon-o-check-circle')
                ->color(
                    $progress >= 80 ? 'success' :
                    ($progress >= 50 ? 'warning' : 'danger')
                );
        }

        return $cards;
    }
}
