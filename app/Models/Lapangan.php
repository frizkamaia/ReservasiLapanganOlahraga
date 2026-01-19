<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lapangan extends Model
{
    use HasFactory;

    protected $table = 'lapangans';

    protected $fillable = [
        'nama_lapangan',
        'jenis',
        'foto',
        'harga_per_jam',
        'deskripsi',
    ];

    /**
     * Relasi ke Jadwal (Satu Lapangan punya banyak Jadwal)
     */
    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'lapangan_id');
    }

    /**
     * Relasi ke Reservasi (Satu Lapangan punya banyak Reservasi)
     */
    public function reservasi(): HasMany
    {
        return $this->hasMany(Reservasi::class, 'lapangan_id');
    }
}
