<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TlKab extends Model
{


    protected $table = 'tl_kabs';

    protected $fillable = ['nama_skpd', 'persentase_tl', 'tahun', 'semester'];


    protected $casts = [
        'persentase_tl' => 'float',
    ];
}
