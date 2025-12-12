<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\McpArea; 

class McpItem extends Model
{
    protected $fillable = [
        'area_id',
        'year',
        'code',
        'name',
        'is_complete',
        'notes',
    ];

    public function area()
    {
        return $this->belongsTo(McpArea::class);
    }
}
