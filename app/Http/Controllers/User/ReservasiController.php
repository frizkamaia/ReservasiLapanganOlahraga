<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Lapangan;
use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservasiController extends Controller
{
    // ===============================
    // LIST RESERVASI USER
    // ===============================
    public function index()
    {

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

        return view('user.reservasi.create', compact('lapangan'));
    }

    // ===============================
    // SIMPAN RESERVASI
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'tipe_sewa' => 'required|in:harian,jam',
        ]);

        $lapangan = Lapangan::findOrFail($request->lapangan_id);

        // ===============================
        // SEWA HARIAN
        // ===============================
        if ($request->tipe_sewa === 'harian') {

            $request->validate([
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            ]);

            $mulai = Carbon::parse($request->tanggal_mulai);
            $selesai = Carbon::parse($request->tanggal_selesai);

            // Cari jadwal admin yang membungkus reservasi
            $jadwal = Jadwal::where('lapangan_id', $lapangan->id)
                ->where('status', 'available')
                ->whereDate('tanggal_mulai', '<=', $mulai)
                ->whereDate('tanggal_selesai', '>=', $selesai)
                ->first();

            if (! $jadwal) {
                return back()->with('error', 'Jadwal tidak tersedia antara '.$mulai->format('d M Y').' s/d '.$selesai->format('d M Y'));
            }

            // Cek bentrok reservasi
            $bentrok = Reservasi::where('lapangan_id', $lapangan->id)
                ->where('tipe_sewa', 'harian')
                ->whereIn('status', ['pending', 'disetujui'])
                ->where(function ($q) use ($mulai, $selesai) {
                    $q->whereBetween('tanggal_mulai', [$mulai->toDateString(), $selesai->toDateString()])
                        ->orWhereBetween('tanggal_selesai', [$mulai->toDateString(), $selesai->toDateString()])
                        ->orWhere(function ($q2) use ($mulai, $selesai) {
                            $q2->where('tanggal_mulai', '<=', $mulai->toDateString())
                                ->where('tanggal_selesai', '>=', $selesai->toDateString());
                        });
                })->exists();

            if ($bentrok) {
                return back()->with('error', 'Tanggal sudah dibooking');
            }

            $totalHari = $mulai->diffInDays($selesai) + 1;
            $totalHarga = $totalHari * 24 * $lapangan->harga_per_jam;

            // ===============================
            // Potong jadwal sesuai reservasi
            // ===============================
            $jadwalAwal = Carbon::parse($jadwal->tanggal_mulai);
            $jadwalAkhir = Carbon::parse($jadwal->tanggal_selesai);

            // 1️⃣ Buat jadwal sebelum reservasi
            if ($mulai->gt($jadwalAwal)) {
                Jadwal::create([
                    'lapangan_id' => $jadwal->lapangan_id,
                    'tanggal_mulai' => $jadwalAwal->toDateString(),
                    'tanggal_selesai' => $mulai->copy()->subDay()->toDateString(),
                    'status' => 'available',
                ]);
            }

            // 2️⃣ Buat jadwal setelah reservasi
            if ($selesai->lt($jadwalAkhir)) {
                Jadwal::create([
                    'lapangan_id' => $jadwal->lapangan_id,
                    'tanggal_mulai' => $selesai->copy()->addDay()->toDateString(),
                    'tanggal_selesai' => $jadwalAkhir->toDateString(),
                    'status' => 'available',
                ]);
            }

            // 3️⃣ Update jadwal yang dipakai menjadi booked
            $jadwal->update([
                'tanggal_mulai' => $mulai->toDateString(),
                'tanggal_selesai' => $selesai->toDateString(),
                'status' => 'booked',
            ]);

            // 4️⃣ Simpan reservasi
            $reservasi = Reservasi::create([
                'user_id' => Auth::id(),
                'lapangan_id' => $lapangan->id,
                'jadwal_id' => $jadwal->id,
                'tipe_sewa' => 'harian',
                'tanggal_mulai' => $mulai->toDateString(),
                'tanggal_selesai' => $selesai->toDateString(),
                'jam_mulai' => '00:00',
                'jam_selesai' => '23:59',
                'total_harga' => $totalHarga,
                'status' => 'pending',
            ]);

        } else {
            // ===============================
            // SEWA PER JAM
            // ===============================
            $request->validate([
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'jam_mulai' => 'required|date_format:H:i',
                'jam_selesai' => 'required|date_format:H:i',
            ]);

            $tanggalMulai = Carbon::parse($request->tanggal_mulai);
            $tanggalSelesai = Carbon::parse($request->tanggal_selesai);

            $jamMulai = Carbon::parse($request->jam_mulai);
            $jamSelesai = Carbon::parse($request->jam_selesai);

            $mulai = Carbon::parse($tanggalMulai->toDateString().' '.$request->jam_mulai);
            $selesai = Carbon::parse($tanggalSelesai->toDateString().' '.$request->jam_selesai);

            if ($selesai <= $mulai) {
                return back()
                    ->withErrors(['jam_selesai' => 'Jam selesai harus setelah jam mulai'])
                    ->withInput();
            }

            // Cari jadwal admin harian (jam kosong)
            $jadwal = Jadwal::where('lapangan_id', $lapangan->id)
                ->where('status', 'available')
                ->whereNull('jam_mulai')
                ->whereNull('jam_selesai')
                ->whereDate('tanggal_mulai', '<=', $selesai->toDateString())
                ->whereDate('tanggal_selesai', '>=', $mulai->toDateString())
                ->first();

            if (! $jadwal) {
                return back()->with('error', 'Jadwal harian tidak tersedia');
            }

            // Cek bentrok jam
            $bentrok = Reservasi::where('lapangan_id', $lapangan->id)
                ->where('tipe_sewa', 'jam')
                ->whereIn('status', ['pending', 'disetujui'])
                ->where(function ($q) use ($mulai, $selesai) {
                    $q->whereRaw('? < CONCAT(tanggal_selesai, " ", jam_selesai)', [$mulai])
                        ->whereRaw('? > CONCAT(tanggal_mulai, " ", jam_mulai)', [$selesai]);
                })->exists();

            if ($bentrok) {
                return back()->with('error', 'Jam sudah dibooking');
            }

            $durasiJam = $mulai->diffInHours($selesai);
            $totalHarga = $durasiJam * $lapangan->harga_per_jam;

            $reservasi = Reservasi::create([
                'user_id' => Auth::id(),
                'lapangan_id' => $lapangan->id,
                'jadwal_id' => $jadwal->id,
                'tipe_sewa' => 'jam',
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'total_harga' => $totalHarga,
                'status' => 'pending',
            ]);

            $jadwal->update([
                'status' => 'booked',
            ]);
        }

        return redirect()
            ->route('user.pembayaran.create', $reservasi->id)
            ->with('success', 'Reservasi berhasil dibuat, silakan lakukan pembayaran.');
    }

    // ===============================
    // DETAIL RESERVASI
    // ===============================
    public function show($id)
    {
        $reservasi = Reservasi::with('lapangan', 'jadwal', 'pembayaran')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        if ($reservasi->tipe_sewa === 'harian') {
            $durasi = Carbon::parse($reservasi->tanggal_mulai)
                ->diffInDays(Carbon::parse($reservasi->tanggal_selesai)) + 1;
            $keterangan = $durasi.' hari';
        } else {
            $durasi = Carbon::parse($reservasi->jam_mulai)
                ->diffInHours(Carbon::parse($reservasi->jam_selesai));
            $keterangan = $durasi.' jam';
        }

        return view('user.reservasi.show', compact('reservasi', 'durasi', 'keterangan'));
    }

    // ===============================
    // STRUK RESERVASI
    // ===============================
    public function struk($id)
    {
        $reservasi = Reservasi::with('user', 'lapangan', 'jadwal', 'pembayaran')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        if (! $reservasi->pembayaran || $reservasi->pembayaran->status !== 'valid') {
            abort(403);
        }

        return view('user.reservasi.struk', compact('reservasi'));
    }
}
