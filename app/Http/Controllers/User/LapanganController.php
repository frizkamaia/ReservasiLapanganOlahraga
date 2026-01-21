<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\Reservasi;

class LapanganController extends Controller
{
    public function index()
    {
        $lapangan = Lapangan::all();

        return view('user.lapangan.index', compact('lapangan'));
    }

    public function show(Lapangan $lapangan)
    {
        $now = now();

        // Ambil semua jadwal lapangan
        $jadwal = Jadwal::where('lapangan_id', $lapangan->id)
            ->orderBy('tanggal_mulai')
            ->orderBy('jam_mulai')
            ->get();

        // Update status jadwal yang sudah lewat menjadi available
        foreach ($jadwal as $j) {
            try {
                // Gunakan tanggal_selesai apa adanya (DATETIME), jangan gabungkan jam lagi
                $end = Carbon::parse($j->tanggal_selesai);
            } catch (\Exception $e) {
                // fallback ke endOfDay jika parsing gagal
                $end = Carbon::parse($j->tanggal_selesai)->endOfDay();
            }

            if ($end->lt($now) && $j->status === 'booked') {
                $j->status = 'available';
                $j->save();
            }
        }

        // Ambil jadwal yang masih booked untuk ditampilkan
        $jadwalTerbooking = Jadwal::where('lapangan_id', $lapangan->id)
            ->where('status', 'booked')
            ->orderBy('tanggal_mulai')
            ->orderBy('jam_mulai')
            ->get();

        return view('user.lapangan.show', compact('lapangan', 'jadwalTerbooking'));
    }
}