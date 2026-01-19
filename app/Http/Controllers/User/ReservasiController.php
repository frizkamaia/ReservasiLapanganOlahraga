<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use App\Models\Jadwal;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    // ===============================
    // AUTO RELEASE JADWAL HABIS
    // ===============================
    private function releaseExpiredJadwal()
    {
        $now = Carbon::now();
        $today = $now->toDateString();
        $currentTime = $now->toTimeString();

        Jadwal::where('status', 'booked')
            ->where(function ($q) use ($today, $currentTime) {

                // PER JAM → JAM SUDAH LEWAT
                $q->where(function ($q1) use ($today, $currentTime) {
                    $q1->whereDate('tanggal', $today)
                        ->whereTime('jam_selesai', '<', $currentTime);
                })

                    // HARIAN → TANGGAL SUDAH LEWAT
                    ->orWhere(function ($q2) use ($today) {
                        $q2->whereDate('tanggal', '<', $today);
                    });
            })
            ->update(['status' => 'available']);
    }

    // ===============================
    // LIST RESERVASI USER
    // ===============================
    public function index()
    {
        $this->cekExpiredPembayaran();
        $this->releaseExpiredJadwal();

        $reservasi = Reservasi::with('lapangan', 'jadwal')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.reservasi.index', compact('reservasi'));
    }

    // ===============================
    // HALAMAN BUAT RESERVASI
    // ===============================
    public function create(Lapangan $lapangan)
    {
        $this->releaseExpiredJadwal();

        return view('user.reservasi.create', compact('lapangan'));
    }

    // ===============================
    // SIMPAN RESERVASI
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'tipe_sewa'   => 'required|in:harian,jam',
        ]);

        $lapangan = Lapangan::findOrFail($request->lapangan_id);

        // ===============================
        // SEWA HARIAN (MULTI HARI)
        // ===============================
        if ($request->tipe_sewa === 'harian') {

            $request->validate([
                'tanggal_mulai'   => 'required|date',
                'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            ]);

            $mulai   = Carbon::parse($request->tanggal_mulai);
            $selesai = Carbon::parse($request->tanggal_selesai);
            $totalHari = $mulai->diffInDays($selesai);

            if ($totalHari < 1) {
                return back()->with('error', 'Reservasi minimal 1 hari');
            }

            // CEK BENTROK RANGE TANGGAL
            $bentrok = Jadwal::where('lapangan_id', $lapangan->id)
                ->where('status', 'booked')
                ->whereBetween('tanggal', [
                    $mulai->toDateString(),
                    $selesai->copy()->subDay()->toDateString()
                ])
                ->exists();

            if ($bentrok) {
                return back()->with('error', 'Tanggal sudah dibooking');
            }

            // ===============================
            // HITUNG HARGA NORMAL (24 JAM)
            // ===============================
            $hargaNormal = $totalHari * 24 * $lapangan->harga_per_jam;

            // ===============================
            // DISKON BERTINGKAT
            // ===============================
            if ($totalHari >= 10) {
                $diskonPersen = 0.50; // 50%
            } elseif ($totalHari >= 5) {
                $diskonPersen = 0.30; // 30%
            } elseif ($totalHari >= 2) {
                $diskonPersen = 0.20; // 20%
            } elseif ($totalHari >= 1) {
                $diskonPersen = 0.10; // 10%
            } else {
                $diskonPersen = 0; // tanpa diskon
            }

            // ===============================
            // TOTAL HARGA SETELAH DISKON
            // ===============================
            $diskon = $hargaNormal * $diskonPersen;
            $totalHarga = $hargaNormal - $diskon;

            // BUAT JADWAL PER HARI
            $jadwalUtama = null;

            for ($i = 0; $i < $totalHari; $i++) {
                $jadwal = Jadwal::create([
                    'lapangan_id' => $lapangan->id,
                    'tanggal'     => $mulai->copy()->addDays($i)->toDateString(),
                    'jam_mulai'   => '00:00',
                    'jam_selesai' => '23:59',
                    'status'      => 'booked',
                ]);

                if ($i === 0) {
                    $jadwalUtama = $jadwal;
                }
            }
        }

        // ===============================
        // SEWA PER JAM
        // ===============================
        // ===============================
        // SEWA PER JAM
        // ===============================
        else {

            $request->validate([
                'jam_mulai'   => 'required',
                'jam_selesai' => 'required|after:jam_mulai',
            ]);

            $mulai   = Carbon::parse($request->jam_mulai);
            $selesai = Carbon::parse($request->jam_selesai);
            $durasiJam = $mulai->diffInHours($selesai);

            if ($durasiJam < 1) {
                return back()->with('error', 'Minimal sewa 1 jam');
            }

            // CEK BENTROK JAM
            $bentrok = Jadwal::where('lapangan_id', $lapangan->id)
                ->where('status', 'booked')
                ->where('tanggal', Carbon::today()->toDateString()) // gunakan tanggal hari ini
                ->where(function ($q) use ($request) {
                    $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhere(function ($q2) use ($request) {
                            $q2->where('jam_mulai', '<=', $request->jam_mulai)
                                ->where('jam_selesai', '>=', $request->jam_selesai);
                        });
                })
                ->exists();

            if ($bentrok) {
                return back()->with('error', 'Jam sudah dibooking');
            }

            $totalHarga = $durasiJam * $lapangan->harga_per_jam;

            // Buat jadwal utama
            $jadwalUtama = Jadwal::create([
                'lapangan_id' => $lapangan->id,
                'tanggal'     => Carbon::today()->toDateString(), // tanggal hari ini otomatis
                'jam_mulai'   => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'status'      => 'booked',
            ]);
        }

        // ===============================
        // SIMPAN RESERVASI
        // ===============================
        $reservasi = Reservasi::create([
            'user_id'         => Auth::id(),
            'lapangan_id'     => $lapangan->id,
            'jadwal_id'       => $jadwalUtama->id,
            'tipe_sewa'       => $request->tipe_sewa,
            'tanggal_mulai'   => $request->tipe_sewa === 'harian'
                ? $request->tanggal_mulai
                : Carbon::today()->toDateString(), // otomatis hari ini untuk sewa per jam
            'tanggal_selesai' => $request->tipe_sewa === 'harian'
                ? $request->tanggal_selesai
                : Carbon::today()->toDateString(),
            'jam_mulai'       => $request->tipe_sewa === 'jam'
                ? $request->jam_mulai
                : '00:00',
            'jam_selesai'     => $request->tipe_sewa === 'jam'
                ? $request->jam_selesai
                : '23:59',
            'total_harga'     => $totalHarga,
            'status'          => 'pending',
        ]);

        return redirect()
            ->route('user.pembayaran.create', $reservasi->id)
            ->with('success', 'Reservasi berhasil dibuat, silakan lakukan pembayaran.');
    }

    // ===============================
    // JADWAL TERBOOKING (AJAX)
    // ===============================
    public function jadwalTerbooking(Request $request)
    {
        $this->releaseExpiredJadwal();

        $request->validate([
            'lapangan_id' => 'required',
            'tanggal'     => 'required|date',
            'tipe_sewa'   => 'required|in:harian,jam',
        ]);

        // ===============================
        // SEWA HARIAN
        // ===============================
        if ($request->tipe_sewa === 'harian') {

            // Ambil reservasi harian yang aktif
            $reservasi = Reservasi::where('lapangan_id', $request->lapangan_id)
                ->where('tipe_sewa', 'harian')
                ->where('status', '!=', 'expired')
                ->whereDate('tanggal_mulai', '<=', $request->tanggal)
                ->whereDate('tanggal_selesai', '>', $request->tanggal)
                ->orderBy('tanggal_mulai')
                ->first();

            if (!$reservasi) {
                return response()->json([
                    'bentrok' => false
                ]);
            }

            return response()->json([
                'bentrok'         => true,
                'tanggal_mulai'   => $reservasi->tanggal_mulai,
                'tanggal_selesai' => $reservasi->tanggal_selesai,
            ]);
        }

        // ===============================
        // SEWA PER JAM
        // ===============================
        $jadwal = Jadwal::where('lapangan_id', $request->lapangan_id)
            ->where('status', 'booked')
            ->where('tanggal', $request->tanggal)
            ->orderBy('jam_mulai')
            ->get(['jam_mulai', 'jam_selesai']);

        return response()->json([
            'tanggal' => $request->tanggal,
            'jadwal'  => $jadwal
        ]);
    }

    private function cekExpiredPembayaran()
    {
        Pembayaran::where('status', 'pending')
            ->where('expired_at', '<', now())
            ->update(['status' => 'expired']);
    }

    // ===============================
    // DETAIL RESERVASI
    // ===============================
    public function show($id)
    {
        $reservasi = Reservasi::with('lapangan', 'jadwal', 'pembayaran')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        // ===============================
        // HITUNG DURASI & KETERANGAN
        // ===============================
        if ($reservasi->tipe_sewa === 'harian') {

            $tanggalMulai   = Carbon::parse($reservasi->tanggal_mulai);
            $tanggalSelesai = Carbon::parse($reservasi->tanggal_selesai);

            $durasi = $tanggalMulai->diffInDays($tanggalSelesai);

            $keterangan = $durasi . ' hari';
        } else {

            $jamMulai   = Carbon::parse($reservasi->jam_mulai);
            $jamSelesai = Carbon::parse($reservasi->jam_selesai);

            $durasi = $jamMulai->diffInHours($jamSelesai);

            $keterangan = $durasi . ' jam';
        }

        return view('user.reservasi.show', compact(
            'reservasi',
            'durasi',
            'keterangan'
        ));
    }

    // ===============================
    // STRUK RESERVASI
    // ===============================
    public function struk($id)
    {
        $reservasi = Reservasi::with('user', 'lapangan', 'jadwal', 'pembayaran')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        if (!$reservasi->pembayaran || $reservasi->pembayaran->status !== 'valid') {
            abort(403);
        }

        return view('user.reservasi.struk', compact('reservasi'));
    }
}
