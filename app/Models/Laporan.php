<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $fillable = [
        'reservasi_id',
        'tanggal',
        'total_jam',
        'total_hari',
        'total_bayar',
    ];

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class);
    }
}

