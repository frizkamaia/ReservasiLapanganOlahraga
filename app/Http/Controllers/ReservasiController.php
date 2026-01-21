<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservasi = Reservasi::with([
            'user',
            'lapangan',
            'jadwal',
            'pembayaran',
        ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.reservasi.index', compact('reservasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jadwalTerbooking = [];
        $reservasi = Reservasi::with([
            'user',
            'lapangan',
            'jadwal',
            'pembayaran',
        ])->findOrFail($id);

        return view('admin.reservasi.detail', compact('reservasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservasi $reservasi)
    {
        return view('admin.reservasi.edit', compact('reservasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservasi $reservasi)
    {
        // Validasi input
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i',
            'status' => 'nullable|in:pending,disetujui,ditolak,selesai',
        ]);

        // Parse tanggal & jam
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;
        $jamMulai = $request->jam_mulai ?? '00:00';
        $jamSelesai = $request->jam_selesai ?? '23:59';

        $mulai = \Carbon\Carbon::parse("$tanggalMulai $jamMulai");
        $selesai = \Carbon\Carbon::parse("$tanggalSelesai $jamSelesai");
        $now = \Carbon\Carbon::now();

        // ===============================
        // Update data reservasi
        // ===============================
        $reservasi->update([
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai,
        ]);

        // ===============================
        // Update status otomatis jika waktunya habis
        // ===============================
        if ($selesai <= $now && $reservasi->status != 'selesai') {
            $reservasi->update(['status' => 'selesai']);

            // Jika ada jadwal, kembalikan status jadwal ke available
            if ($reservasi->jadwal) {
                $reservasi->jadwal->update(['status' => 'available']);
            }
        }

        // ===============================
        // Update status sesuai input admin
        // ===============================
        if ($request->status) {
            // Jika status baru adalah 'ditolak' atau 'selesai', kembalikan jadwal
            if (in_array($request->status, ['ditolak', 'selesai']) && $reservasi->jadwal) {
                $reservasi->jadwal->update(['status' => 'available']);
            }

            $reservasi->update(['status' => $request->status]);
        }

        return redirect()->route('admin.reservasi.index')->with('success', 'Reservasi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservasi $reservasi)
    {
        if (in_array($reservasi->status, ['disetujui', 'selesai'])) {
            return back()->with('error', 'Reservasi tidak bisa dihapus');
        }

        DB::transaction(function () use ($reservasi) {

            // 1️⃣ Kembalikan jadwal
            if ($reservasi->jadwal) {
                $reservasi->jadwal->update([
                    'status' => 'available',
                ]);
            }

            // 2️⃣ Hapus pembayaran (OPSIONAL)
            if ($reservasi->pembayaran) {
                $reservasi->pembayaran()->delete();
            }

            // 3️⃣ Hapus reservasi
            $reservasi->delete();
        });

        return back()->with('success', 'Reservasi berhasil dihapus');
    }
}
