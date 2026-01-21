<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    // ===============================
    // HALAMAN PEMBAYARAN
    // ===============================
    public function create($reservasiId)
    {
        $reservasi = Reservasi::with('lapangan', 'jadwal', 'pembayaran')
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($reservasiId);

        // HITUNG DURASI
        if ($reservasi->tipe_sewa === 'harian') {
            $tanggalMulai = Carbon::parse($reservasi->tanggal_mulai);
            $tanggalSelesai = Carbon::parse($reservasi->tanggal_selesai);
            $durasi = $tanggalMulai->diffInDays($tanggalSelesai);
            $keterangan = $durasi.' hari';
        } else {
            $jamMulai = Carbon::parse($reservasi->jam_mulai);
            $jamSelesai = Carbon::parse($reservasi->jam_selesai);
            $durasi = $jamMulai->diffInHours($jamSelesai);
            $keterangan = $durasi.' jam';
        }

        return view('user.pembayaran.create', compact('reservasi', 'durasi', 'keterangan'));
    }

    // ===============================
    // SIMPAN PEMBAYARAN
    // ===============================
    public function store(Request $request, $reservasiId)
    {
        // VALIDASI
        $request->validate([
            'metode_pembayaran' => 'required|in:cash,transfer',
            'bukti_transfer' => $request->metode_pembayaran === 'transfer'
                ? 'required|image|mimes:jpg,jpeg,png|max:2048'
                : 'nullable',
        ]);

        $reservasi = Reservasi::where('id', $reservasiId)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $buktiPath = null;
        if ($request->metode_pembayaran === 'transfer') {
            $buktiPath = $request->file('bukti_transfer')
                ->store('bukti_transfer', 'public');
        }

        // HAPUS PEMBAYARAN LAMA (EXPIRED / TIDAK VALID)
        Pembayaran::where('reservasi_id', $reservasi->id)
            ->whereIn('status', ['expired', 'tidak valid'])
            ->delete();

        // SIMPAN PEMBAYARAN BARU
        Pembayaran::create([
            'reservasi_id' => $reservasi->id,
            'metode' => $request->metode_pembayaran,
            'jumlah' => $reservasi->total_harga,
            'bukti_transfer' => $buktiPath,
            'status' => 'tidak valid',
            'expired_at' => Carbon::now()->addMinutes(30), // 30 menit
        ]);

        return redirect()
            ->route('user.reservasi.index')
            ->with('success', 'Pembayaran berhasil dikirim. Menunggu validasi admin.');
    }
}
