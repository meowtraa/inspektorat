<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TindakLanjutController extends Controller
{
    public function index(Request $request, string $jenis)
    {
        $model = $this->getModelClass($jenis);

        if (! $model) {
            return response()->json([
                'error' => 'Parameter jenis tidak valid',
                'valid' => ['bpk', 'jabar', 'kab'],
            ], 400);
        }

        $latest = $model::select('tahun', 'semester')
            ->orderByDesc('tahun')
            ->orderByDesc('semester')
            ->first();

        if (! $latest) {
            return response()->json([
                'message' => 'Data tidak tersedia',
            ], 404);
        }

        $query = $model::where('tahun', $latest->tahun)
            ->where('semester', $latest->semester);

        $allData = (clone $query)->get();

        $summary = [
            'avg' => round($allData->avg('persentase_tl'), 2),
            'diatas80' => $allData->where('persentase_tl', '>=', 80)->count(),
            'antara60_79' => $allData->whereBetween('persentase_tl', [60, 79])->count(),
            'dibawah60' => $allData->where('persentase_tl', '<', 60)->count(),
            'total_skpd' => $allData->count(),
        ];

        return response()->json([
            'jenis' => strtoupper($jenis),
            'periode' => $latest,
            'summary' => $summary,
            'top_skpd' => (clone $query)
                ->orderBy('persentase_tl', 'desc')
                ->limit(10)
                ->get(),
            'bottom_skpd' => (clone $query)
                ->orderBy('persentase_tl', 'asc')
                ->limit(10)
                ->get(),
            'list_all' => (clone $query)
                ->orderBy('nama_skpd')
                ->paginate($request->get('per_page', 10)),
        ]);
    }

    private function getModelClass(string $jenis): ?string
    {
        return match ($jenis) {
            'bpk' => \App\Models\TlBpk::class,
            'jabar' => \App\Models\TlJabar::class,
            'kab' => \App\Models\TlKab::class,
            default => null,
        };
    }
}
