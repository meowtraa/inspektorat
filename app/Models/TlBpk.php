<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TlBpk extends Model
{

    protected $table = 'tl_bpk';

    protected $fillable = ['nama_skpd', 'persentase_tl', 'tahun', 'semester'];

    protected $casts = [
        'persentase_tl' => 'float',
    ];
}
