<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Lapangan $lapangan)
    {
        // Ambil semua jadwal lapangan
        $jadwal = Jadwal::where('lapangan_id', $lapangan->id)
            ->orderBy('tanggal_mulai')
            ->orderBy('jam_mulai')
            ->get();

        $now = now();

        foreach ($jadwal as $j) {
            // Tentukan waktu akhir jadwal
            if (!empty($j->jam_selesai)) {
                // Gabungkan tanggal_selesai + jam_selesai
                $endTimeString = $j->tanggal_selesai . ' ' . $j->jam_selesai;
                try {
                    $end = Carbon::parse($endTimeString);
                } catch (\Exception $e) {
                    // Jika format jam_selesai error, fallback ke endOfDay
                    $end = Carbon::parse($j->tanggal_selesai)->endOfDay();
                }
            } else {
                // Jika jam_selesai kosong, anggap akhir hari
                $end = Carbon::parse($j->tanggal_selesai)->endOfDay();
            }

            // Jika jadwal sudah lewat dan masih booked, update status ke available
            if ($end->lt($now) && $j->status === 'booked') {
                $j->status = 'available';
                $j->save();
            }
        }

        return view('user.jadwal.index', compact('lapangan', 'jadwal'));
    }

}
