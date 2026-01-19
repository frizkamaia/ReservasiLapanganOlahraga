<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;  // Sudah di-import
use App\Models\Reservasi; // Sudah di-import

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin dengan data statistik.
     */
    public function index()
    {
        // 1. Ambil Total Lapangan
        // Pastikan Model Lapangan sudah ada dan tabel 'lapangan' sudah terdefinisi
        $totalLapangan = Lapangan::count(); 

        // 2. Ambil Reservasi Pending
        // Asumsi: reservasi pending memiliki status = 'pending'
        $reservasiPending = Reservasi::where('status', 'pending')->count(); 

        // 3. Ambil Validasi Pembayaran
        // Asumsi: reservasi yang menunggu validasi pembayaran memiliki status_pembayaran = 'menunggu'
        $validasiPembayaran = Reservasi::where('status', 'menunggu')->count(); 

        $stats = [
            'total_lapangan' => $totalLapangan,
            'reservasi_pending' => $reservasiPending,
            'validasi_pembayaran' => $validasiPembayaran,
        ];

        // Mengirim data ke view
        return view('admin.dashboard', [
            'stats' => $stats,
        ]);
    }
}