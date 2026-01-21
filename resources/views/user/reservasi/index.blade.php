<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Reservasi | Lapangan Olahraga</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background-color: #0f172a;
            color: #e5e7eb;
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
            color: #cbd5f5 !important;
            font-weight: 500;
        }

        .nav-link.active,
        .nav-link:hover {
            color: #ffffff !important;
        }

        /* CONTENT */
        .content {
            padding-top: 120px;
            padding-bottom: 60px;
        }

        .reservasi-card {
            background-color: #1f2937;
            border-radius: 20px;
            padding: 32px;
        }

        /* TABLE THEME */
        .table-custom {
            --border: #334155;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 14px;
        }

        .table-custom thead th {
            background-color: #020617;
            color: #e5e7eb;
            font-weight: 600;
            border-bottom: 1px solid var(--border);
            padding: 14px;
        }

        .table-custom tbody td {
            background-color: #020617;
            border-bottom: 1px solid var(--border);
            color: #e5e7eb;
            padding: 14px;
            vertical-align: middle;
        }

        .table-custom tbody tr:hover td {
            background-color: #0f172a;
        }

        .table-custom th:first-child,
        .table-custom td:first-child {
            border-top-left-radius: 12px;
        }

        .table-custom th:last-child,
        .table-custom td:last-child {
            border-top-right-radius: 12px;
        }

        /* BADGE */
        .badge-status {
            font-size: 12px;
            padding: 6px 10px;
            border-radius: 12px;
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
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.lapangan.index') }}">Lapangan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('user.reservasi.index') }}">Reservasi</a>
                    </li>
                </ul>

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
            <div class="reservasi-card">

                <h4 class="mb-4 text-center fw-bold">DAFTAR RESERVASI SAYA</h4>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if ($reservasi->count())
                    <div class="table-responsive">
                        <table class="table table-custom w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Lapangan</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Total Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reservasi as $res)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $res->lapangan->nama_lapangan ?? '-' }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($res->jadwal->tanggal_mulai)->format('d M Y') }}
                                            @if ($res->jadwal->tanggal_mulai != $res->jadwal->tanggal_selesai)
                                                -
                                                {{ \Carbon\Carbon::parse($res->jadwal->tanggal_selesai)->format('d M Y') }}
                                            @endif
                                        </td>

                                        <td>
                                            @if ($res->jadwal->jam_mulai && $res->jadwal->jam_selesai)
                                                {{ $res->jadwal->jam_mulai }} - {{ $res->jadwal->jam_selesai }}
                                            @else
                                                <span class=" text-white">Harian</span>
                                            @endif
                                        </td>

                                        <td>Rp {{ number_format($res->total_harga, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($res->status === 'pending')
                                                <span class="badge bg-warning text-dark badge-status">Pending</span>
                                            @elseif($res->status === 'lunas')
                                                <span class="badge bg-success badge-status">Lunas</span>
                                            @else
                                                <span class="badge bg-secondary badge-status">
                                                    {{ ucfirst($res->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('user.reservasi.show', $res->id) }}"
                                                class="btn btn-sm btn-outline-info mb-1">
                                                Detail
                                            </a>

                                            @if ($res->status === 'pending')
                                                <a href="{{ route('user.pembayaran.create', $res->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    Bayar
                                                </a>
                                            @elseif($res->status === 'lunas')
                                                <a href="{{ route('user.reservasi.struk', $res->id) }}"
                                                    class="btn btn-sm btn-success mt-1">
                                                    Struk
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        Anda belum memiliki reservasi.
                    </div>
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
</body>

</html>
