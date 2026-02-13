<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $laporans = Laporan::with('reservasi.lapangan')
            ->when($bulan, fn ($q) =>
                $q->whereMonth('tanggal', $bulan)
            )
            ->when($tahun, fn ($q) =>
                $q->whereYear('tanggal', $tahun)
            )
            ->orderBy('tanggal', 'desc')
            ->get();

        $totalPendapatan = $laporans->sum('total_bayar');

        return view('admin.laporan.index', compact(
            'laporans',
            'totalPendapatan',
            'bulan',
            'tahun'
        ));
    }
}
