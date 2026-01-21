@extends('layouts.admin')

@section('content')
    <div class="content py-4">

        @if ($pembayaran && $pembayaran->reservasi)
            <div class="row g-4">

                <!-- KOLOM KIRI -->
                <div class="col-md-6">

                    <!-- DATA PEMESAN -->
                    <div class="card shadow-sm mb-4"
                        style="background: linear-gradient(135deg, #1e3c72, #2a5298); color: #fff;">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bi bi-person-circle me-2"></i>Data Pemesan
                            </h5>

                            <p class="mb-1"><strong>Nama:</strong>
                                {{ optional($pembayaran->reservasi->user)->nama ?? '-' }}
                            </p>

                            <p class="mb-1"><strong>Email:</strong>
                                {{ optional($pembayaran->reservasi->user)->email ?? '-' }}
                            </p>

                            @php
                                $reservasi = $pembayaran->reservasi;
                                $jadwal = $reservasi->jadwal ?? null;
                            @endphp

                            {{-- TANGGAL MULAI SEWA --}}
                            <p class="mb-1"><strong>Tanggal Mulai:</strong>
                                @if ($reservasi && $jadwal)
                                    @if ($reservasi->tipe_sewa === 'harian')
                                        {{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('d-m-Y') }}
                                    @elseif ($reservasi->tipe_sewa === 'jam')
                                        {{ \Carbon\Carbon::parse($jadwal->tanggal . ' ' . $reservasi->jam_mulai)->format('d-m-Y H:i') }}
                                    @else
                                        -
                                    @endif
                                @else
                                    -
                                @endif
                            </p>

                            {{-- TANGGAL SELESAI SEWA --}}
                            <p class="mb-1"><strong>Tanggal Selesai:</strong>
                                @if ($reservasi && $jadwal)
                                    @if ($reservasi->tipe_sewa === 'harian')
                                        {{ \Carbon\Carbon::parse($jadwal->tanggal_selesai)->format('d-m-Y') }}
                                    @elseif ($reservasi->tipe_sewa === 'jam')
                                        {{ \Carbon\Carbon::parse($jadwal->tanggal . ' ' . $reservasi->jam_selesai)->format('d-m-Y H:i') }}
                                    @else
                                        -
                                    @endif
                                @else
                                    -
                                @endif
                            </p>

                            {{-- WAKTU PESAN (OPSIONAL) --}}
                            <p class="mb-0"><strong>Waktu Pesan:</strong>
                                {{ optional($reservasi->created_at)->format('d-m-Y H:i') ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- DATA LAPANGAN -->
                    <div class="card shadow-sm mb-4"
                        style="background: linear-gradient(135deg, #11998e, #38ef7d); color: #fff;">
                        <div class="card-body">
                            <h5 class="card-title mb-3"><i class="bi bi-building me-2"></i>Data Lapangan</h5>
                            <p class="mb-1"><strong>Nama:</strong>
                                {{ optional($pembayaran->reservasi->lapangan)->nama_lapangan ?? '-' }}</p>
                            <p class="mb-1"><strong>Jenis:</strong>
                                {{ optional($pembayaran->reservasi->lapangan)->jenis ?? '-' }}</p>
                            <p class="mb-0"><strong>Harga / Jam:</strong> Rp
                                {{ number_format(optional($pembayaran->reservasi->lapangan)->harga_per_jam ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <!-- JADWAL BOOKING -->
                    <div class="card shadow-sm mb-4"
                        style="background: linear-gradient(135deg, #fc4a1a, #f7b733); color: #fff;">
                        <div class="card-body">
                            <h5 class="card-title mb-3"><i class="bi bi-calendar-event me-2"></i>Jadwal Booking</h5>

                            @php $reservasi = $pembayaran->reservasi; @endphp

                            @if ($reservasi->tipe_sewa === 'harian' && $reservasi->jadwal)
                                @php
                                    $mulai = \Carbon\Carbon::parse($reservasi->jadwal->tanggal_mulai);
                                    $selesai = \Carbon\Carbon::parse($reservasi->jadwal->tanggal_selesai);
                                    $durasiHari = max(1, $mulai->diffInDays($selesai));
                                @endphp
                                <p class="mb-1"><strong>Tanggal:</strong> {{ $mulai->format('d M Y') }} s/d
                                    {{ $selesai->format('d M Y') }}</p>
                                <p class="mb-1"><strong>Durasi:</strong> {{ $durasiHari }} Hari (Full Day)</p>
                                <p class="mb-0"><strong>Tipe Sewa:</strong> Harian</p>
                            @elseif($reservasi->tipe_sewa === 'jam' && $reservasi->jadwal)
                                <p class="mb-1"><strong>Tanggal:</strong>
                                    {{ \Carbon\Carbon::parse($reservasi->jadwal->tanggal)->format('d M Y') }}</p>
                                <p class="mb-1"><strong>Jam:</strong> {{ $reservasi->jadwal->jam_mulai ?? '-' }} -
                                    {{ $reservasi->jadwal->jam_selesai ?? '-' }}</p>
                                <p class="mb-0"><strong>Tipe Sewa:</strong> Per Jam</p>
                            @else
                                <p class="mb-1"><strong>Tanggal:</strong> -</p>
                                <p class="mb-1"><strong>Jam:</strong> -</p>
                                <p class="mb-0"><strong>Tipe Sewa:</strong> -</p>
                            @endif

                        </div>
                    </div>

                    <!-- RINGKASAN -->
                    <div class="card shadow-sm">
                        <div class="card-body text-center py-3">
                            <h5 class="card-title mb-2"><i class="bi bi-receipt me-2"></i>Ringkasan</h5>
                            <h3 class="text-primary mb-2">Rp {{ number_format($pembayaran->jumlah ?? 0, 0, ',', '.') }}
                            </h3>
                            <p class="mb-0"><strong>Status Reservasi:</strong> <span
                                    class="badge bg-info">{{ ucfirst($pembayaran->reservasi->status ?? 'menunggu') }}</span>
                            </p>
                        </div>
                    </div>

                </div>

                <!-- KOLOM KANAN -->
                <div class="col-md-6">

                    <!-- DETAIL PEMBAYARAN + VALIDASI -->
                    <div class="card shadow-sm" style="background: linear-gradient(135deg, #6a11cb, #2575fc); color: #fff;">
                        <div class="card-body">
                            <h5 class="card-title mb-3"><i class="bi bi-credit-card me-2"></i>Detail Pembayaran</h5>

                            <p class="mb-1"><strong>Metode:</strong> {{ ucfirst($pembayaran->metode ?? '-') }}</p>
                            <p class="mb-2"><strong>Status:</strong>
                                @if ($pembayaran->status === 'valid')
                                    <span class="badge bg-success">Valid</span>
                                @elseif ($pembayaran->status === 'tidak_valid')
                                    <span class="badge bg-danger">Tidak Valid</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </p>

                            @if ($pembayaran->bukti_transfer)
                                <p class="mb-2"><strong>Bukti Transfer:</strong></p>
                                <img src="{{ asset('storage/' . $pembayaran->bukti_transfer) }}"
                                    class="img-fluid rounded mb-3" width="300">
                            @else
                                <p class="text-light">Tidak ada bukti transfer</p>
                            @endif

                            @if ($pembayaran->reservasi->status === 'pending')
                                <div class="d-flex gap-2 mt-4">

                                    <!-- SETUJUI -->
                                    <form action="{{ route('admin.validasi.update', $pembayaran->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin SETUJUI pembayaran dan booking jadwal ini?')">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="valid">
                                        <button class="btn btn-success w-100">
                                            <i class="bi bi-check-circle me-1"></i> Setujui
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.validasi.update', $pembayaran->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin TOLAK pembayaran ini? Jadwal akan dibuka kembali.')">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="status" value="tidak valid">

                                        <button class="btn btn-danger w-100">
                                            <i class="bi bi-x-circle me-1"></i> Tolak
                                        </button>
                                    </form>

                                </div>
                            @endif

                        </div>
                    </div>

                </div>

            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('admin.validasi.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        @else
            <div class="alert alert-warning">
                Data pembayaran atau reservasi tidak lengkap
            </div>
        @endif

    </div>
@endsection
