<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lapangan | Lapangan Olahraga</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #0f172a;
            color: #ffffff;
        }

        /* NAVBAR */
        .navbar {
            background-color: #2c3f57;
        }

        .navbar-brand {
            font-weight: bold;
            color: #ffffff !important;
        }

        .nav-link {
            color: #d1d5db !important;
            font-weight: 500;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #ffffff !important;
        }

        /* CONTENT */
        .content {
            padding-top: 120px;
            padding-bottom: 60px;
        }

        .detail-wrapper {
            background-color: #1f2937;
            border-radius: 18px;
            padding: 28px;
        }

        .lapangan-img {
            width: 100%;
            height: 320px;
            object-fit: cover;
            border-radius: 16px;
        }

        .badge-jenis {
            background-color: #334155;
            color: #e5e7eb;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            display: inline-block;
            margin-bottom: 10px;
        }

        .harga {
            font-size: 16px;
            color: #cbd5f5;
            margin-bottom: 14px;
        }

        .deskripsi {
            color: #d1d5db;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 18px;
        }

        .action-group {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-jadwal {
            background-color: #334155;
            color: #e5e7eb;
            border-radius: 30px;
            padding: 8px 24px;
            font-weight: 500;
            border: none;
            font-size: 14px;
        }

        .btn-jadwal:hover {
            background-color: #475569;
        }

        .btn-kembali {
            background-color: transparent;
            color: #e5e7eb;
            border: 1px solid #475569;
            border-radius: 30px;
            padding: 8px 22px;
            font-weight: 500;
            font-size: 14px;
            text-decoration: none;
        }

        .btn-kembali:hover {
            background-color: #334155;
            color: #ffffff;
        }

        /* TABLE */
        .table-dark {
            --bs-table-bg: #020617;
            --bs-table-border-color: #334155;
        }

        /* FOOTER */
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
            <a class="navbar-brand" href="{{ route('user.dashboard') }}">
                Lapangan Olahraga
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">
                <!-- MENU TENGAH -->
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('user.lapangan.index') }}">Lapangan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.reservasi.index') }}">Reservasi</a>
                    </li>
                </ul>

                <!-- LOGOUT -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="content">
        <div class="container">
            <div class="detail-wrapper">

                <div class="row g-4 align-items-center">

                    <!-- FOTO -->
                    <div class="col-md-6">
                        <img src="{{ $lapangan->foto ? asset('storage/' . $lapangan->foto) : 'https://via.placeholder.com/900x500?text=Lapangan' }}"
                            alt="{{ $lapangan->nama_lapangan }}" class="lapangan-img">
                    </div>

                    <!-- DETAIL -->
                    <div class="col-md-6">
                        <span class="badge-jenis">{{ $lapangan->jenis }}</span>

                        <h4 class="mb-1">{{ $lapangan->nama_lapangan }}</h4>

                        <div class="harga">
                            Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }} / jam
                        </div>

                        <p class="deskripsi">
                            {{ $lapangan->deskripsi ?? 'Deskripsi lapangan belum tersedia.' }}
                        </p>

                        {{-- JADWAL TERBOOKING --}}
                        @if ($jadwalTerbooking->count())
                            <div class="mt-3">
                                <h6 class="text-warning mb-2">
                                    Jadwal Sudah Terbooking
                                </h6>

                                <div class="table-responsive">
                                    <table class="table table-dark table-bordered table-sm align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Waktu</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($jadwalTerbooking as $item)
                                                @php
                                                    // relasi aman
                                                    $reservasi = $item->reservasi->first() ?? null;

                                                    // HARlAN
                                                    $tanggalMulaiHarian = $item->tanggal_mulai
                                                        ? \Carbon\Carbon::parse($item->tanggal_mulai)
                                                        : null;

                                                    $tanggalSelesaiHarian = $item->tanggal_selesai
                                                        ? \Carbon\Carbon::parse($item->tanggal_selesai)
                                                        : null;

                                                    // JAM
                                                    $tanggalJam = $item->tanggal
                                                        ? \Carbon\Carbon::parse($item->tanggal)
                                                        : null;
                                                @endphp

                                                <tr>
                                                    {{-- TANGGAL --}}
                                                    <td>
                                                        @if ($reservasi && $reservasi->tipe_sewa === 'harian')
                                                            <span class="fw-semibold">
                                                                {{ $tanggalMulaiHarian?->format('d M Y') }}
                                                            </span>
                                                            <br>
                                                            <small class="text-warning fw-semibold">
                                                                s/d {{ $tanggalSelesaiHarian?->format('d M Y') }}
                                                            </small>
                                                        @elseif($reservasi && $reservasi->tipe_sewa === 'jam')
                                                            <span class="fw-semibold">
                                                                {{ $tanggalJam?->format('d M Y') }}
                                                            </span>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    {{-- WAKTU --}}
                                                    <td>
                                                        @if ($reservasi && $reservasi->tipe_sewa === 'harian')
                                                            Full Day
                                                        @elseif($reservasi && $reservasi->tipe_sewa === 'jam')
                                                            {{ $item->jam_mulai }} – {{ $item->jam_selesai }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    {{-- KETERANGAN --}}
                                                    <td>
                                                        @if ($reservasi && $reservasi->tipe_sewa === 'harian')
                                                            📅
                                                            {{ $tanggalMulaiHarian && $tanggalSelesaiHarian
                                                                ? $tanggalMulaiHarian->diffInDays($tanggalSelesaiHarian)
                                                                : 0 }}
                                                            hari
                                                        @elseif($reservasi && $reservasi->tipe_sewa === 'jam')
                                                            ⏰
                                                            {{ \Carbon\Carbon::parse($item->jam_mulai)->diffInHours(\Carbon\Carbon::parse($item->jam_selesai)) }}
                                                            jam
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>

                                <small class="text-muted d-block mt-2">
                                    Silakan pilih jadwal lain yang masih tersedia.
                                </small>
                            </div>
                        @endif

                        <div class="action-group mt-4">
                            <a href="{{ route('user.lapangan.index') }}" class="btn btn-kembali">
                                ← Kembali
                            </a>

                            <a href="{{ route('user.reservasi.create', ['lapangan' => $lapangan->id]) }}"
                                class="btn btn-jadwal">
                                Reservasi
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="py-4 text-center">
        <div class="container">
            <small>
                © {{ date('Y') }} Lapangan Olahraga. All rights reserved.
            </small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
