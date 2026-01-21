<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwals';

    protected $fillable = [
        'lapangan_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    // Pastikan casting untuk tanggal dan waktu
    protected $casts = [
        // jam
        'tanggal' => 'date',
        'jam_mulai' => 'string',
        'jam_selesai' => 'string',

        // harian
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    /**
     * Relasi ke Lapangan (Jadwal dimiliki oleh satu Lapangan)
     */
    public function lapangan(): BelongsTo
    {
        return $this->belongsTo(Lapangan::class, 'lapangan_id');
    }

    /**
     * Relasi ke Reservasi (Satu Jadwal dapat dimiliki oleh banyak Reservasi)
     */
    public function reservasi(): HasMany
    {
        return $this->hasMany(Reservasi::class, 'jadwal_id');
    }
}
