<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\McpArea;
use App\Models\McpItem;
use Illuminate\Http\Request;

class McpSummaryController extends Controller
{
    public function summary(Request $request)
    {
        // Ambil parameter year (optional)
        $year = $request->input('year');

        // Jika year kosong → ambil tahun terbaru
        if (! $year) {
            $year = McpItem::max('year');
        }

        // Jika tetap null → tidak ada data sama sekali
        if (! $year) {
            return response()->json([
                'year' => null,
                'areas' => [],
                'message' => 'Belum ada data MCP Item',
            ]);
        }

        // Ambil semua area
        $areas = McpArea::all();

        $result = [];

        foreach ($areas as $area) {
            $total = McpItem::where('area_id', $area->id)
                ->where('year', $year)
                ->count();

            $complete = McpItem::where('area_id', $area->id)
                ->where('year', $year)
                ->where('is_complete', true)
                ->count();

            $progress = $total > 0
                ? round(($complete / $total) * 100, 1)
                : 0;

            $result[] = [
                'area_id' => $area->id,
                'area_name' => $area->name,
                'year' => $year,
                'total' => $total,
                'complete' => $complete,
                'progress' => $progress,
            ];
        }

        return response()->json([
            'year' => $year,
            'areas' => $result,
        ]);
    }
}
