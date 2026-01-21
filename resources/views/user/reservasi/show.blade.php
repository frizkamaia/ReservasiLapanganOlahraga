<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Reservasi | Lapangan Olahraga</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background-color: #0f172a;
            color: #e5e7eb;
        }

        .navbar {
            background-color: #1e293b;
        }

        .navbar-brand {
            font-weight: bold;
            color: #ffffff !important;
        }

        .nav-link {
            color: #cbd5f5 !important;
            font-weight: 500;
        }

        .nav-link.active,
        .nav-link:hover {
            color: #ffffff !important;
        }

        .content {
            padding-top: 120px;
            padding-bottom: 60px;
        }

        .card-custom {
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s;
        }

        .card-custom:hover {
            transform: translateY(-3px);
        }

        /* WARNA SOFT */
        .card-lapangan {
            background-color: #4db6ac;
            /* soft teal */
            color: #fff;
        }

        .card-jadwal {
            background-color: #ffb74d;
            /* soft amber */
            color: #fff;
        }

        .card-pembayaran {
            background-color: #9575cd;
            /* soft lavender */
            color: #fff;
        }

        .section-title {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            color: #e0e0e0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 14px;
        }

        .badge {
            font-size: 13px;
        }

        footer {
            background-color: #020617;
            color: #9ca3af;
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('user.dashboard') }}">Lapangan Olahraga</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('user.lapangan.index') }}">Lapangan</a></li>
                    <li class="nav-item"><a class="nav-link active"
                            href="{{ route('user.reservasi.index') }}">Reservasi</a></li>
                </ul>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="content">
        <div class="container">
            <h4 class="mb-4 text-center fw-bold">DETAIL RESERVASI</h4>

            @php $p = $reservasi->pembayaran; @endphp

            <div class="row g-4">

                <!-- KIRI : Data Lapangan -->
                <div class="col-md-6">
                    <div class="card card-custom" style="background-color:#1f2937; color:#e5e7eb; min-height:220px;">
                        <div class="section-title">Data Lapangan</div>
                        <div class="info-row">
                            <span>Nama Pemesan</span>
                            <strong>{{ optional($reservasi->user)->nama ?? (optional($reservasi->user)->name ?? '-') }}</strong>
                        </div>
                        <div class="info-row">
                            <span>Nama Lapangan</span>
                            <strong>{{ $reservasi->lapangan->nama_lapangan ?? '-' }}</strong>
                        </div>
                        <div class="info-row">
                            <span>Jenis</span>
                            <strong>{{ $reservasi->lapangan->jenis ?? '-' }}</strong>
                        </div>
                        <div class="info-row">
                            <span>Harga / Jam</span>
                            <strong>Rp {{ number_format($reservasi->lapangan->harga_per_jam ?? 0, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>

                <!-- KANAN : Jadwal Booking -->
                <div class="col-md-6">
                    <div class="card card-custom" style="background-color:#1f2937; color:#e5e7eb; min-height:220px;">
                        <div class="section-title">Jadwal Booking</div>
                        @if ($reservasi->tipe_sewa === 'harian')
                            @php
                                $jadwal = $reservasi->jadwal;
                                $tanggalMulai = $jadwal->tanggal_mulai;
                                $tanggalSelesai = $jadwal->tanggal_selesai;
                                $durasiHari = $tanggalMulai->diffInDays($tanggalSelesai);
                            @endphp
                            <div class="info-row">
                                <span>Tanggal</span>
                                <strong>{{ $tanggalMulai->format('d M Y') }} -
                                    {{ $tanggalSelesai->format('d M Y') }}</strong>
                            </div>
                            <div class="info-row">
                                <span>Durasi</span>
                                <strong>{{ $durasiHari }} Hari (Full Day)</strong>
                            </div>
                        @else
                            <div class="info-row">
                                <span>Tanggal</span>
                                <strong>{{ \Carbon\Carbon::parse($reservasi->jadwal->tanggal)->format('d M Y') }}</strong>
                            </div>
                            <div class="info-row">
                                <span>Jam</span>
                                <strong>{{ $reservasi->jadwal->jam_mulai ?? '-' }} -
                                    {{ $reservasi->jadwal->jam_selesai ?? '-' }}</strong>
                            </div>
                        @endif
                        <div class="info-row">
                            <span>Status Jadwal</span>
                            @if ($reservasi->jadwal->status === 'booked')
                                <span class="badge bg-warning text-dark">Booked</span>
                            @elseif($reservasi->jadwal->status === 'completed')
                                <span class="badge bg-success">Completed</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($reservasi->jadwal->status) }}</span>
                            @endif
                        </div>
                        <div class="info-row">
                            <span>Tipe Sewa</span>
                            <strong>{{ $reservasi->tipe_sewa ?? '-' }}</strong>
                        </div>
                    </div>
                </div>

                <!-- PEMBAYARAN : Full Width -->
                <div class="col-12">
                    <div class="card card-custom" style="background-color:#1f2937; color:#e5e7eb;">
                        <div class="section-title">Pembayaran</div>
                        <div class="info-row">
                            <span>Total Harga</span>
                            <strong>Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}</strong>
                        </div>
                        <div class="info-row">
                            <span>Metode Pembayaran</span>
                            <strong>{{ ucfirst($p->metode ?? '-') }}</strong>
                        </div>
                        <div class="info-row">
                            <span>Status Pembayaran</span>
                            @if (!$p)
                                <span class="badge bg-danger">Belum Bayar</span>
                            @elseif ($p->status === 'pending' && $p->expired_at)
                                <span class="badge bg-warning text-dark">
                                    Menunggu Validasi <span id="countdown"></span>
                                </span>
                            @elseif ($p->status === 'valid')
                                <span class="badge bg-success">Valid</span>
                            @elseif ($p->status === 'expired')
                                <span class="badge bg-secondary">Kedaluwarsa</span>
                            @elseif ($p->status === 'tidak valid')
                                <span class="badge bg-danger">Belum Valid</span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            <!-- ACTION -->
            <div class="mt-4 d-flex justify-content-end gap-2">
                <a href="{{ route('user.reservasi.index') }}" class="btn btn-secondary">Kembali</a>
                @if (optional($p)->status === 'valid')
                    <a href="{{ route('user.reservasi.struk', $reservasi->id) }}" target="_blank"
                        class="btn btn-success">Cetak Struk</a>
                @elseif(in_array(optional($p)->status, ['expired', null]))
                    <a href="{{ route('user.pembayaran.create', $reservasi->id) }}" class="btn btn-warning">Bayar
                        Ulang</a>
                @endif
            </div>

        </div>
    </div>

    <!-- FOOTER -->
    <footer class="py-4 text-center">
        <div class="container">
            <small>© {{ date('Y') }} Lapangan Olahraga. All rights reserved.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- COUNTDOWN -->
    @if ($p && $p->status === 'pending' && $p->expired_at)
        <script>
            const countdownEl = document.getElementById("countdown");
            const expired = new Date("{{ $p->expired_at->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s') }}").getTime();
            const x = setInterval(function() {
                const now = new Date().getTime();
                const distance = expired - now;
                if (distance <= 0) {
                    clearInterval(x);
                    countdownEl.innerHTML = " (Waktu Habis)";
                    location.reload();
                } else {
                    const minutes = Math.floor(distance / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    countdownEl.innerHTML = ` (${minutes}m ${seconds}s tersisa)`;
                }
            }, 1000);
        </script>
    @endif

</body>

</html>
