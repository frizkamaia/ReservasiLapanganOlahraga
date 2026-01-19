<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Jadwal Lapangan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #0f172a;
            color: #ffffff;
        }

        .sidebar {
            width: 230px;
            height: 100vh;
            background-color: #2c3f57;
            position: fixed;
        }

        .sidebar h4 {
            padding: 20px;
            font-weight: bold;
        }

        .sidebar a {
            display: block;
            color: #e5e7eb;
            padding: 12px 20px;
            text-decoration: none;
        }

        .sidebar a:hover,
        .sidebar .active {
            background-color: #3b5170;
        }

        .content {
            margin-left: 230px;
            min-height: 100vh;
            padding: 50px;
            background-color: #111827;
        }

        .jadwal-wrapper {
            background-color: #1f2937;
            border-radius: 18px;
            padding: 35px;
            max-width: 900px;
            margin: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #334155;
        }

        th,
        td {
            padding: 14px;
            text-align: center;
            border-bottom: 1px solid #475569;
            font-size: 14px;
        }

        .status-available {
            background-color: #22c55e;
            color: #022c22;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-booked {
            background-color: #ef4444;
            color: #450a0a;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h4>Lapangan Olahraga</h4>
        <a href="{{ route('user.dashboard') }}">Dashboard</a>
        <a href="{{ route('user.lapangan.index') }}">Lihat Lapangan</a>
        <a href="#">Reservasi</a>
        <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link btn btn-link p-0" style="text-decoration: none;">
                    Logout
                </button>
            </form>
    </div>

    <div class="content">
        <div class="jadwal-wrapper">
            <h4 class="mb-4 text-center">
                JADWAL LAPANGAN – {{ $lapangan->nama_lapangan }}
            </h4>

            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jadwal as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $item->jam_mulai }} - {{ $item->jam_selesai }}</td>
                        <td>
                            @if ($item->status === 'available')
                            <a href="{{ route('user.reservasi.create', [
                                    'lapangan'    => $lapangan->id,
                                    'tanggal'     => \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d'),
                                    'jam_mulai'   => \Carbon\Carbon::parse($item->jam_mulai)->format('H:i'),
                                    'jam_selesai' => \Carbon\Carbon::parse($item->jam_selesai)->format('H:i')
                                ]) }}"
                                class="status-available text-decoration-none">
                                Pesan Sekarang
                            </a>

                            @else
                            <span class="status-booked">Tidak Tersedia</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">Belum ada jadwal</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>