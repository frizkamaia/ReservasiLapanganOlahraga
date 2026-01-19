<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayaran = Pembayaran::with([
            'reservasi.user',
            'reservasi.lapangan',
            'reservasi.jadwal'
        ])->latest()->get();

        return view('admin.validasi.index', compact('pembayaran'));
    }

    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load([
            'reservasi.user',
            'reservasi.lapangan',
            'reservasi.jadwal'
        ]);

        // 🔒 Validasi data sebelum ke view
        if (
            !$pembayaran->reservasi ||
            !$pembayaran->reservasi->user ||
            !$pembayaran->reservasi->lapangan ||
            !$pembayaran->reservasi->jadwal
        ) {
            return redirect()
                ->route('admin.validasi.index')
                ->with('error', 'Data pembayaran atau reservasi tidak lengkap');
        }

        return view('admin.validasi.detail', compact('pembayaran'));
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'status' => 'required|in:valid,tidak valid'
        ]);

        DB::transaction(function () use ($request, $pembayaran) {

            // 🔒 Validasi relasi WAJIB
            if (
                !$pembayaran->reservasi ||
                !$pembayaran->reservasi->jadwal
            ) {
                throw new \Exception('Data reservasi atau jadwal tidak lengkap');
            }

            $reservasi = $pembayaran->reservasi;
            $jadwal    = $reservasi->jadwal;

            // Update status pembayaran
            $pembayaran->update([
                'status' => $request->status
            ]);

            if ($request->status === 'valid') {

                // ✅ DISETUJUI
                $reservasi->update([
                    'status' => 'disetujui'
                ]);

                $jadwal->update([
                    'status' => 'booked'
                ]);

            } else {

                // ❌ DITOLAK
                $reservasi->update([
                    'status' => 'ditolak'
                ]);

                $jadwal->update([
                    'status' => 'available'
                ]);
            }
        });

        return redirect()
            ->route('admin.validasi.index')
            ->with('success', 'Status pembayaran berhasil diperbarui');
    }
}