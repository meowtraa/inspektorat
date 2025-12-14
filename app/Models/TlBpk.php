<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TlBpk extends Model
{
    protected $table = 'tl_bpk';

    protected $fillable = [
        'nama_skpd',
        'jumlah_temuan',
        'jumlah_rekomendasi',
        'sesuai',
        'belum_sesuai',
        'belum_ditindaklanjuti',
        'tahun',
        'semester',
    ];

    protected $casts = [
        'jumlah_temuan' => 'integer',
        'jumlah_rekomendasi' => 'integer',
        'sesuai' => 'integer',
        'belum_sesuai' => 'integer',
        'belum_ditindaklanjuti' => 'integer',
        'tahun' => 'integer',
        'semester' => 'integer',
    ];

    /**
     * Persentase Tindak Lanjut
     * (sesuai / jumlah_rekomendasi) * 100
     */
    protected $appends = ['persentase_tl'];

    public function getPersentaseTlAttribute(): float
    {
        if ($this->jumlah_rekomendasi <= 0) {
            return 0;
        }

        return round(
            ($this->sesuai / $this->jumlah_rekomendasi) * 100,
            2
        );
    }
}
