<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Reservasi | Lapangan Olahraga</title>
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
            max-width: 900px;
            margin: auto;
        }

        .section-title {
            font-size: 13px;
            color: #94a3b8;
            margin: 25px 0 10px;
            letter-spacing: .5px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #334155;
            padding: 10px 0;
            font-size: 14px;
        }

        .form-control,
        .form-select {
            background-color: #111827;
            border: 1px solid #334155;
            color: #fff;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #111827;
            color: #fff;
            border-color: #22c55e;
            box-shadow: none;
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
                    <a class="nav-link" href="{{ route('user.reservasi.index') }}">Reservasi</a>
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

            <h4 class="mb-4 text-center fw-bold">PEMBAYARAN RESERVASI</h4>

            <div class="info-row">
                <span>Nama Pemesan</span>
                <strong>{{ $reservasi->user->nama }}</strong>
            </div>

            <!-- DATA LAPANGAN -->
            <div class="section-title">DATA LAPANGAN</div>
            <div class="info-row">
                <span>Nama Lapangan</span>
                <strong>{{ $reservasi->lapangan->nama_lapangan }}</strong>
            </div>
            <div class="info-row">
                <span>Jenis</span>
                <strong>{{ $reservasi->lapangan->jenis }}</strong>
            </div>

            <!-- JADWAL -->
            <div class="section-title">JADWAL</div>
            <div class="info-row">
                <span>Tipe Sewa</span>
                <strong>{{ ucfirst($reservasi->tipe_sewa) }}</strong>
            </div>
            <div class="info-row">
                <span>Durasi</span>
                <strong>{{ $keterangan }}</strong>
            </div>

            @if($reservasi->tipe_sewa === 'harian')
                <div class="info-row">
                    <span>Tanggal</span>
                    <strong>
                        {{ \Carbon\Carbon::parse($reservasi->jadwal->tanggal)->format('d M Y') }}
                        (Full Day)
                    </strong>
                </div>
            @else
                <div class="info-row">
                    <span>Jam</span>
                    <strong>
                        {{ $reservasi->jadwal->jam_mulai }} - {{ $reservasi->jadwal->jam_selesai }}
                    </strong>
                </div>
            @endif

            <!-- PEMBAYARAN -->
            <div class="section-title">PEMBAYARAN</div>
            <div class="info-row">
                <span>Total Harga</span>
                <strong>Rp {{ number_format($reservasi->total_harga,0,',','.') }}</strong>
            </div>

            <form action="{{ route('user.pembayaran.store', $reservasi->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="mt-4">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Metode Pembayaran</label>
                    <select name="metode_pembayaran" id="metode" class="form-select" required>
                        <option value="">-- Pilih Metode --</option>
                        <option value="transfer">Transfer Bank</option>
                        <option value="cash">Cash</option>
                    </select>
                </div>

                <!-- TRANSFER -->
                <div id="transferBox" class="d-none">
                    <div class="section-title">PETUNJUK PEMBAYARAN</div>

                    <div class="alert alert-info">
                        <strong>Silakan transfer ke rekening berikut:</strong><br>
                        Bank BCA<br>
                        <strong>123456789</strong><br>
                        a.n <strong>Lapangan Sport</strong>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Bukti Transfer</label>
                        <input type="file" name="bukti_transfer" class="form-control">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success px-4">
                        Kirim Pembayaran
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<footer class="py-4 text-center">
    <div class="container">
        <small>© {{ date('Y') }} Lapangan Olahraga</small>
    </div>
</footer>

<script>
    const metode = document.getElementById('metode');
    const transferBox = document.getElementById('transferBox');

    metode.addEventListener('change', function () {
        transferBox.classList.toggle('d-none', this.value !== 'transfer');
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>