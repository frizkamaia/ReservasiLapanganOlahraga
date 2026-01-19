@extends('layouts.admin')

@section('content')
<div class="content py-4">

    <div class="row g-4">

        <!-- DATA USER -->
        <div class="col-md-6 col-lg-4">
            <div class="card text-white shadow-lg" style="background: linear-gradient(135deg, #1e3c72, #2a5298);">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-person-circle fs-2 me-3"></i>
                        <h5 class="card-title mb-0">Data Pemesan</h5>
                    </div>
                    <p class="mb-1"><strong>Nama:</strong> {{ $reservasi->user->nama ?? '-' }}</p>
                    <p class="mb-1"><strong>Email:</strong> {{ $reservasi->user->email ?? '-' }}</p>
                    <p class="mb-0"><strong>Tanggal Pesan:</strong> {{ $reservasi->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- DATA LAPANGAN -->
        <div class="col-md-6 col-lg-4">
            <div class="card text-white shadow-lg" style="background: linear-gradient(135deg, #11998e, #38ef7d);">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-building fs-2 me-3"></i>
                        <h5 class="card-title mb-0">Data Lapangan</h5>
                    </div>
                    <p class="mb-1"><strong>Nama:</strong> {{ $reservasi->lapangan->nama_lapangan ?? '-' }}</p>
                    <p class="mb-1"><strong>Jenis:</strong> {{ $reservasi->lapangan->jenis ?? '-' }}</p>
                    <p class="mb-0"><strong>Harga / Jam:</strong> Rp {{ number_format($reservasi->lapangan->harga_per_jam ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- JADWAL -->
        <div class="col-md-6 col-lg-4">
            <div class="card text-white shadow-lg" style="background: linear-gradient(135deg, #fc4a1a, #f7b733);">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-calendar-event fs-2 me-3"></i>
                        <h5 class="card-title mb-0">Jadwal Booking</h5>
                    </div>

                    @if($reservasi->tipe_sewa === 'harian' && $reservasi->jadwal)
                    <p class="mb-1"><strong>Tanggal:</strong>
                        {{ \Carbon\Carbon::parse($reservasi->jadwal->tanggal_mulai)->format('d M Y') }}
                        s/d
                        {{ \Carbon\Carbon::parse($reservasi->jadwal->tanggal_selesai)->format('d M Y') }}
                    </p>
                    <p class="mb-0"><strong>Tipe Sewa:</strong> Harian</p>
                    @elseif($reservasi->tipe_sewa === 'jam' && $reservasi->jadwal)
                    <p class="mb-1"><strong>Tanggal:</strong>
                        {{ \Carbon\Carbon::parse($reservasi->jadwal->tanggal)->format('d M Y') }}
                    </p>
                    <p class="mb-1"><strong>Jam:</strong>
                        {{ $reservasi->jadwal->jam_mulai ?? '-' }} - {{ $reservasi->jadwal->jam_selesai ?? '-' }}
                    </p>
                    <p class="mb-0"><strong>Tipe Sewa:</strong> Per Jam</p>
                    @else
                    <p class="mb-1"><strong>Tanggal:</strong> -</p>
                    <p class="mb-1"><strong>Jam:</strong> -</p>
                    <p class="mb-0"><strong>Tipe Sewa:</strong> -</p>
                    @endif

                </div>
            </div>
        </div>

        <!-- PEMBAYARAN -->
        <div class="col-md-6 col-lg-4">
            <div class="card text-white shadow-lg" style="background: linear-gradient(135deg, #6a11cb, #2575fc);">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-credit-card fs-2 me-3"></i>
                        <h5 class="card-title mb-0">Pembayaran</h5>
                    </div>
                    @if ($reservasi->pembayaran)
                    <span class="badge bg-success mb-2">Sudah Bayar</span>
                    <p class="mb-0"><strong>Metode:</strong> {{ ucfirst($reservasi->pembayaran->metode) }}</p>
                    @else
                    <span class="badge bg-danger">Belum Bayar</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- TOTAL & STATUS -->
        <div class="col-md-6 col-lg-8">
            <div class="card shadow-lg">
                <div class="card-body text-center py-4">
                    <h5 class="text-muted mb-2">Total Pembayaran</h5>
                    <h2 class="text-primary mb-2">Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}</h2>
                    <p class="mb-2">Status Reservasi:</p>
                    <span class="badge 
                {{ $reservasi->status === 'selesai' ? 'bg-success' : ($reservasi->status === 'pending' ? 'bg-warning text-dark' : 'bg-info') }} fs-6 py-2 px-3">
                        {{ ucfirst($reservasi->status) }}
                    </span>
                </div>
            </div>
        </div>

    </div>

    <div class="mt-4 text-end">
        <a href="{{ route('admin.reservasi.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

</div>
@endsection