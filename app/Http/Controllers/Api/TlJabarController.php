<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TlJabar;
use Illuminate\Http\Request;

class TlJabarController extends Controller
{
    private function status(float $p): string
    {
        if ($p >= 80) {
            return 'hijau';
        }
        if ($p >= 60) {
            return 'kuning';
        }

        return 'merah';
    }

    public function index(Request $request)
    {
        $tahun = $request->input('tahun');
        $semester = $request->input('semester');

        if (! $tahun || ! $semester) {
            // Jika tidak ada parameter, ambil yang terbaru
            $latest = TlJabar::select('tahun', 'semester')
                ->orderBy('tahun', 'desc')
                ->orderBy('semester', 'desc')
                ->first();

            if (! $latest) {
                return response()->json([
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }

            $tahun = $latest->tahun;
            $semester = $latest->semester;
        }

        $baseQuery = TlJabar::where('tahun', $tahun)
            ->where('semester', $semester);

        // Summary
        $avg = round($baseQuery->avg('persentase_tl') ?? 0, 2);
        $above80 = (clone $baseQuery)->where('persentase_tl', '>=', 80)->count();
        $between60_80 = (clone $baseQuery)->whereBetween('persentase_tl', [60, 79.99])->count();
        $below60 = (clone $baseQuery)->where('persentase_tl', '<', 60)->count();

        // Top & Bottom
        $top = (clone $baseQuery)->orderBy('persentase_tl', 'desc')
            ->limit(10)
            ->get(['nama_skpd', 'persentase_tl'])
            ->map(fn ($item) => [
                'nama_skpd' => $item->nama_skpd,
                'persentase_tl' => $item->persentase_tl,
                'status' => $this->status($item->persentase_tl),
            ]);

        $bottom = (clone $baseQuery)->orderBy('persentase_tl', 'asc')
            ->limit(10)
            ->get(['nama_skpd', 'persentase_tl'])
            ->map(fn ($item) => [
                'nama_skpd' => $item->nama_skpd,
                'persentase_tl' => $item->persentase_tl,
                'status' => $this->status($item->persentase_tl),
            ]);

        // Pagination
        $listPaginated = (clone $baseQuery)->orderBy('persentase_tl', 'desc')
            ->paginate($request->input('per_page', 10));

        $list = collect($listPaginated->items())->map(fn ($item) => [
            'nama_skpd' => $item->nama_skpd,
            'persentase_tl' => $item->persentase_tl,
            'status' => $this->status($item->persentase_tl),
        ]);

        return response()->json([
            'tahun' => $tahun,
            'semester' => $semester,
            'summary' => [
                'average' => $avg,
                'above_80' => $above80,
                'between_60_80' => $between60_80,
                'below_60' => $below60,
            ],
            'top' => $top,
            'bottom' => $bottom,
            'list' => [
                'current_page' => $listPaginated->currentPage(),
                'total' => $listPaginated->total(),
                'per_page' => $listPaginated->perPage(),
                'items' => $list,
            ],
        ]);
    }
}
