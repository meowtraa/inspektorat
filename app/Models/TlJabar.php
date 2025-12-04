<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TlJabar extends Model
{


    protected $table = 'tl_jabars';


    protected $fillable = ['nama_skpd', 'persentase_tl', 'tahun', 'semester'];


    protected $casts = [
        'persentase_tl' => 'float',
    ];
}
