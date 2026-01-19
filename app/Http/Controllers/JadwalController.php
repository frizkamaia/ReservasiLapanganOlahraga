<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Carbon\Carbon;
use App\Models\Lapangan;

use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $now = Carbon::now();

        $jadwal = Jadwal::with('lapangan')
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        foreach ($jadwal as $j) {

            /**
             * ============================
             * 1️⃣ HAPUS DATA JADWAL LAMA
             * ============================
             */
            if ($j->tanggal) {
                $tanggalOnly = Carbon::parse($j->tanggal)->toDateString();

                if (Carbon::parse($tanggalOnly)->lt($now->toDateString())) {
                    $j->delete();
                    continue;
                }
            }

            /**
             * ============================
             * 2️⃣ SEWA PER JAM
             * ============================
             */
            if ($j->jam_selesai && $j->tanggal) {

                $tanggalOnly = Carbon::parse($j->tanggal)->toDateString();
                $end = Carbon::parse($tanggalOnly . ' ' . $j->jam_selesai);

                if ($end->lt($now) && $j->status === 'booked') {
                    $j->update(['status' => 'available']);
                }

                continue;
            }

            /**
             * ============================
             * 3️⃣ SEWA HARIAN
             * ============================
             */
            if ($j->tanggal_selesai) {

                $end = Carbon::parse($j->tanggal_selesai)->endOfDay();

                if ($end->lt($now) && $j->status === 'booked') {
                    $j->update(['status' => 'available']);
                }
            }
        }

        return view('admin.jadwal.index', compact('jadwal'));
    }




    /**
     * Tampilkan form tambah jadwal
     */
    public function create()
    {
        $lapangan = Lapangan::orderBy('nama_lapangan')->get();
        return view('admin.jadwal.create', compact('lapangan'));
    }

    /**
     * Simpan data jadwal baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',

            // Tanggal untuk multi-hari
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',

            // Jam-an opsional
            'jam_mulai' => 'nullable',
            'jam_selesai' => 'nullable',

            'status' => 'required|in:available,booked',
        ]);

        Jadwal::create([
            'lapangan_id' => $request->lapangan_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan');
    }

    /**
     * Tampilkan form edit jadwal
     */
    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $lapangan = Lapangan::orderBy('nama_lapangan')->get();

        return view('admin.jadwal.edit', compact('jadwal', 'lapangan'));
    }

    /**
     * Update data jadwal
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jam_mulai' => 'nullable',
            'jam_selesai' => 'nullable',
            'status' => 'required|in:available,booked',
        ]);

        $jadwal = Jadwal::findOrFail($id);

        $jadwal->update([
            'lapangan_id' => $request->lapangan_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui');
    }

    /**
     * Hapus data jadwal
     */
    public function destroy($id)
    {
        Jadwal::findOrFail($id)->delete();

        return redirect()
            ->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus');
    }
}
