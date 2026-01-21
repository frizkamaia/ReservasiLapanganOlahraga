<?php

// app/Models/Reservasi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservasis';

    protected $fillable = [
        'user_id',
        'jadwal_id',
        'lapangan_id',
        'tipe_sewa', // harian, jam
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_mulai',
        'jam_selesai',
        'total_harga',
        'status', // pending, disetujui, ditolak, selesai
    ];

    // --- Relasi BelongsTo (Foreign Keys) ---

    /**
     * Relasi ke User (Reservasi dimiliki oleh satu User)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Jadwal (Reservasi merujuk ke satu Jadwal)
     */
    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }

    /**
     * Relasi ke Lapangan (Reservasi merujuk ke satu Lapangan)
     */
    public function lapangan(): BelongsTo
    {
        return $this->belongsTo(Lapangan::class, 'lapangan_id');
    }

    // --- Relasi HasOne ---

    /**
     * Relasi ke Pembayaran (Reservasi memiliki satu Pembayaran)
     */
    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class, 'reservasi_id');
    }
}
