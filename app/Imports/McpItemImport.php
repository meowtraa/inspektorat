<?php

namespace App\Imports;

use App\Models\McpItem;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;

class McpItemImport implements OnEachRow
{
    protected int $areaId;

    public function __construct(int $areaId)
    {
        $this->areaId = $areaId;
    }

    private function normalize(string $text): string
    {
        $text = trim($text);
        $text = preg_replace('/\s+/', ' ', $text);

        return ucwords(strtolower($text));
    }

    public function onRow(Row $row): void
    {
        $data = $row->toArray();

        $code = trim($data[0] ?? null);
        $name = $this->normalize($data[1] ?? '');
        $status = strtolower(trim($data[2] ?? ''));
        $year = trim($data[3] ?? '');
        $notes = trim($data[4] ?? '');

        if ($name === '' || ! is_numeric($year)) {
            return;
        }

        // Status → boolean
        $isComplete = in_array($status, [
            '1', 'yes', 'y', 'ya', 'true', 'lengkap', 'complete',
        ], true);

        McpItem::updateOrCreate(
            [
                'area_id' => $this->areaId,
                'year' => $year,
                'name' => $name,
            ],
            [
                'code' => $code,
                'is_complete' => $isComplete,
                'notes' => $notes ?: null,
            ]
        );
    }
}
