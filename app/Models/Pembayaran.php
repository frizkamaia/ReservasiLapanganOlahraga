<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';

    protected $fillable = [
        'reservasi_id',
        'metode', // transfer, cash
        'jumlah',
        'bukti_transfer',
        'status', // pending, valid, tidak valid
        'expired_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];
    /**
     * Relasi ke Reservasi (Pembayaran dimiliki oleh satu Reservasi)
     */
    public function reservasi(): BelongsTo
    {
        return $this->belongsTo(Reservasi::class, 'reservasi_id');
    }
}
