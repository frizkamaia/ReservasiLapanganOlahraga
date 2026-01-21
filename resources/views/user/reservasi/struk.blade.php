<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Reservasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #f8fafc;
        }

        .struk {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
        }

        .struk h4 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .divider {
            border-top: 1px dashed #cbd5f5;
            margin: 20px 0;
        }

        .row-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .total {
            font-size: 16px;
            font-weight: bold;
        }

        @media print {
            body {
                background: white;
            }

            .btn-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="struk">
        <h4>LAPANGAN OLAHRAGA</h4>
        <p class="text-center text-muted mb-0">Struk Reservasi</p>

        <div class="divider"></div>

        <div class="row-info">
            <span>Nama User</span>
            <strong>{{ $reservasi->user->name }}</strong>
        </div>

        <div class="row-info">
            <span>Lapangan</span>
            <strong>{{ $reservasi->lapangan->nama_lapangan }}</strong>
        </div>

        <div class="row-info">
            <span>Jenis</span>
            <strong>{{ ucfirst($reservasi->lapangan->jenis) }}</strong>
        </div>

        <div class="row-info">
            <span>Tanggal</span>
            <strong>
                {{ \Carbon\Carbon::parse($reservasi->jadwal->tanggal)->format('d M Y') }}
            </strong>
        </div>

        @if ($reservasi->tipe_sewa === 'harian')
            <div class="row-info">
                <span>Tipe Sewa</span>
                <strong>Harian</strong>
            </div>
        @else
            <div class="row-info">
                <span>Jam</span>
                <strong>
                    {{ $reservasi->jadwal->jam_mulai }} - {{ $reservasi->jadwal->jam_selesai }}
                </strong>
            </div>
        @endif

        <div class="divider"></div>

        <div class="row-info total">
            <span>Total Bayar</span>
            <span>
                Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}
            </span>
        </div>

        <div class="row-info">
            <span>Metode Pembayaran</span>
            <strong>{{ ucfirst($reservasi->pembayaran->metode) }}</strong>
        </div>

        <div class="row-info">
            <span>Status</span>
            <strong class="text-success">LUNAS</strong>
        </div>

        <div class="divider"></div>

        <p class="text-center text-muted mb-3">
            Terima kasih telah melakukan reservasi 🙏
        </p>

        <div class="text-center">
            <button onclick="window.print()" class="btn btn-success btn-print">
                Cetak
            </button>
        </div>
    </div>

</body>

</html>
