@extends('layouts.admin')

@section('content')
<div class="content" id="print-area">

    {{-- HEADER CETAK --}}
    <div class="text-center mb-4 print-header">
        <h3 class="fw-bold mb-1">LAPORAN RESERVASI LAPANGAN</h3>
        <div class="small">
            Periode:
            {{ $bulan ? DateTime::createFromFormat('!m', $bulan)->format('F') : 'Semua Bulan' }}
            {{ $tahun ?? 'Semua Tahun' }}
        </div>
    </div>

    {{-- ACTION --}}
    <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
        <h4 class="fw-bold">Laporan Reservasi</h4>
        <button onclick="window.print()" class="btn btn-primary btn-sm">
            Cetak Laporan
        </button>
    </div>

    {{-- FILTER --}}
    <form method="GET" class="row g-2 mb-4 d-print-none">
        <div class="col-md-3">
            <select name="bulan" class="form-select form-select-sm">
                <option value="">Semua Bulan</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="col-md-3">
            <select name="tahun" class="form-select form-select-sm">
                <option value="">Semua Tahun</option>
                @for ($y = date('Y'); $y >= 2023; $y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary btn-sm w-100">Tampilkan</button>
        </div>
    </form>

    {{-- TOTAL --}}
    <div class="card bg-dark text-white mb-3">
        <div class="card-body py-2">
            <strong>Total Pendapatan:</strong>
            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
        </div>
    </div>

    {{-- TABLE (SAMA DENGAN INDEX LAIN) --}}
    <div class="card bg-dark text-white">
        <div class="card-body">
            <table class="table table-dark table-hover table-sm align-middle laporan-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Lapangan</th>
                        <th>Tipe</th>
                        <th>Durasi</th>
                        <th>Total Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporans as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                            <td>{{ $item->reservasi->lapangan->nama_lapangan ?? '-' }}</td>
                            <td>{{ ucfirst($item->reservasi->tipe_sewa) }}</td>
                            <td>
                                @if ($item->total_jam)
                                    {{ $item->total_jam }} Jam
                                @elseif ($item->total_hari)
                                    {{ $item->total_hari }} Hari
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                Rp {{ number_format($item->total_bayar, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-secondary">
                                Data laporan belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- STYLE CETAK --}}
<style>
@media print {

    body {
        font-size: 12px;
        color: #000;
        background: #fff;
    }

    nav,
    .sidebar,
    .btn,
    .d-print-none {
        display: none !important;
    }

    .card {
        background: none !important;
        color: #000 !important;
        border: none !important;
    }

    table {
        width: 100%;
        border-collapse: collapse !important;
    }

    table th,
    table td {
        border: 1px solid #000 !important;
        padding: 6px !important;
        background: #fff !important;
        color: #000 !important;
    }

    .print-header {
        margin-bottom: 20px;
    }
}
</style>
@endsection