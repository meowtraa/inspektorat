<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class McpAreaScore extends Model
{
    protected $fillable = [
        'mcp_area_id',
        'tahun',
        'persentase',
        'bobot',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'persentase' => 'float',
        'bobot' => 'float',
    ];

    public function area()
    {
        return $this->belongsTo(McpArea::class, 'mcp_area_id');
    }

    /**
     * Nilai terbobot = persentase × bobot / 100
     */
    protected $appends = ['nilai_terbobot'];

    public function getNilaiTerbobotAttribute(): float
    {
        return round(
            ($this->persentase * $this->bobot) / 100,
            2
        );
    }
}
