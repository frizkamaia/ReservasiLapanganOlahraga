<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Lapangan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Tampilkan daftar jadwal
     */
    public function index()
    {
        $now = Carbon::today();

        $jadwal = Jadwal::with('lapangan')
            ->orderBy('tanggal_mulai')
            ->orderBy('jam_mulai')
            ->get()
            ->map(function ($j) use ($now) {
                // Tandai jadwal yang sudah lewat (opsional untuk UI)
                $j->is_expired = Carbon::parse($j->tanggal_selesai)->lt($now);

                return $j;
            });

        return view('admin.jadwal.index', compact('jadwal'));
    }

    /**
     * Form tambah jadwal
     */
    public function create()
    {
        $lapangan = Lapangan::orderBy('nama_lapangan')->get();

        return view('admin.jadwal.create', compact('lapangan'));
    }

    /**
     * Simpan jadwal baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'tanggal_mulai' => 'required|date',

            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',

            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i',

            'status' => 'required|in:available,booked',
        ]);

        $isJam = $request->filled('jam_mulai') && $request->filled('jam_selesai');

        if ($isJam) {
            $start = Carbon::parse($request->tanggal_mulai.' '.$request->jam_mulai);
            $end = Carbon::parse($request->tanggal_mulai.' '.$request->jam_selesai);

            // 🔥 LEWAT TENGAH MALAM
            if ($end->lte($start)) {
                $end->addDay();
            }

            // contoh validasi tambahan
            if ($start->diffInHours($end) < 1) {
                return back()
                    ->withErrors(['jam_selesai' => 'Durasi minimal 1 jam'])
                    ->withInput();
            }

            $tanggalSelesai = $end->toDateString();
        } else {
            // HARiAN
            if (! $request->filled('tanggal_selesai')) {
                return back()
                    ->withErrors(['tanggal_selesai' => 'Tanggal selesai wajib diisi untuk sewa harian'])
                    ->withInput();
            }

            $tanggalSelesai = $request->tanggal_selesai;
        }

        Jadwal::create([
            'lapangan_id' => $request->lapangan_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $tanggalSelesai,
            'jam_mulai' => $isJam ? $request->jam_mulai : null,
            'jam_selesai' => $isJam ? $request->jam_selesai : null,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan');
    }

    /**
     * Form edit jadwal
     */
    public function edit(Jadwal $jadwal)
    {
        $lapangan = Lapangan::orderBy('nama_lapangan')->get();

        // pastikan nilai jam berupa H:i atau null (biar aman di blade)
        $jadwal->jam_mulai = $jadwal->jam_mulai ? substr($jadwal->jam_mulai, 0, 5) : null;
        $jadwal->jam_selesai = $jadwal->jam_selesai ? substr($jadwal->jam_selesai, 0, 5) : null;

        return view('admin.jadwal.edit', compact('jadwal', 'lapangan'));
    }

    /**
     * Update jadwal
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        $validated = $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',

            // JAM opsional
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i',

            // enum harus sesuai DB
            'status' => 'required|in:available,booked',
        ]);

        /**
         * ============================
         * LOGIKA JAM (lintas hari)
         * ============================
         */
        if ($validated['jam_mulai'] && $validated['jam_selesai']) {
            // jika jam selesai < jam mulai → berarti lintas hari
            if ($validated['jam_selesai'] < $validated['jam_mulai']) {
                // pastikan tanggal_selesai MINIMAL besok
                if ($validated['tanggal_selesai'] == $validated['tanggal_mulai']) {
                    return back()
                        ->withErrors([
                            'jam_selesai' => 'Jam selesai lebih kecil dari jam mulai, tanggal selesai harus berbeda (lintas hari)',
                        ])
                        ->withInput();
                }
            }
        }

        // kalau salah satu jam kosong → anggap sewa harian
        if (! $validated['jam_mulai'] || ! $validated['jam_selesai']) {
            $validated['jam_mulai'] = null;
            $validated['jam_selesai'] = null;
        }

        $jadwal->update($validated);

        return redirect()
            ->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui');
    }

    /**
     * Hapus jadwal
     */
    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return redirect()
            ->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus');
    }
}
