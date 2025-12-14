<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\McpArea;
use App\Models\McpItem;
use App\Models\McpAreaScore;
use Illuminate\Http\Request;

class McpSummaryController extends Controller
{
    public function summary(Request $request)
    {
        // ===============================
        // YEAR (TIDAK DIUBAH)
        // ===============================
        $year = $request->input('year');

        if (! $year) {
            $year = McpItem::max('year');
        }

        if (! $year) {
            return response()->json([
                'year' => null,
                'areas' => [],
                'message' => 'Belum ada data MCP Item',
            ]);
        }

        // ===============================
        // AREAS (McpItem) — KODE LAMA
        // ===============================
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

        // ===============================
        // NILAI MCP (BARU) — McpAreaScore
        // ===============================
        $scores = McpAreaScore::with('area')
            ->where('tahun', $year)
            ->get();

        $nilaiAreas = $scores->map(fn ($row) => [
            'area_id' => $row->mcp_area_id,
            'area_name' => $row->area->name,
            'year' => $year,
            'nilai' => (float) $row->persentase,
            'bobot' => (int) $row->bobot,
        ])->values();

        $nilaiTotal = $scores->avg('persentase');
        $nilaiTotal = $nilaiTotal ? round($nilaiTotal, 2) : 0;

        // ===============================
        // RESPONSE FINAL
        // ===============================
        return response()->json([
            'year' => $year,

            // 🔹 BARU
            'nilai_total' => $nilaiTotal,
            'nilai_areas' => $nilaiAreas,

            // 🔹 LAMA (TIDAK DIUBAH)
            'areas' => $result,
        ]);
    }
}
