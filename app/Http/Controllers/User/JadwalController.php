<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Lapangan;

class JadwalController extends Controller
{
    public function index(Lapangan $lapangan)
    {
        // Ambil semua jadwal lapangan
        $jadwal = Jadwal::where('lapangan_id', $lapangan->id)
            ->get();

        // Update status jadwal booked → available
        foreach ($jadwal as $j) {
            if ($j->status === 'booked') {
                // Hanya contoh, tanpa tanggal/jam
                $j->status = 'available';
                $j->save();
            }
        }

        return view('user.jadwal.index', compact('lapangan', 'jadwal'));
    }
}
