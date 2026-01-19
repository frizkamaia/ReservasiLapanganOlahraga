<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Reservasi Lapangan | Lapangan Olahraga</title>
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

        /* CONTENT */
        .content {
            padding-top: 120px;
            padding-bottom: 60px;
        }

        /* CARD SOFT */
        .card-soft {
            background-color: #1f2937;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        }

        .card-soft:hover {
            transform: translateY(-2px);
            transition: 0.2s;
        }

        .section-title {
            font-size: 12px;
            color: #94a3b8;
            margin-bottom: 8px;
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #334155;
            font-size: 14px;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .total-box {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            margin-top: 15px;
            border-top: 1px solid #334155;
            font-size: 14px;
        }

        .total-box strong {
            font-size: 16px;
            color: #22c55e;
        }

        .btn-submit {
            background: linear-gradient(135deg, #22c55e, #4ade80);
            color: #022c22;
            border-radius: 30px;
            padding: 10px 36px;
            font-weight: 600;
            border: none;
        }

        footer {
            background-color: #020617;
            color: #9ca3af;
        }
    </style>
</head>

<body data-harga="{{ $lapangan->harga_per_jam }}">

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
                    <li class="nav-item"><a class="nav-link active" href="{{ route('user.reservasi.index') }}">Reservasi</a></li>
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
            <h4 class="text-center fw-bold mb-4">FORM PEMBUATAN RESERVASI</h4>

            <div class="row g-4">

                <!-- KIRI: Data User & Lapangan -->
                <div class="col-lg-5">
                    <div class="card-soft">
                        <div class="section-title">Data User</div>
                        <div class="info-row">
                            <span>Nama</span>
                            <strong>{{ auth()->user()->nama ?? auth()->user()->name }}</strong>
                        </div>

                        <div class="section-title mt-3">Detail Lapangan</div>
                        <div class="info-row">
                            <span>Nama</span>
                            <strong>{{ $lapangan->nama_lapangan }}</strong>
                        </div>
                        <div class="info-row">
                            <span>Jenis</span>
                            <strong>{{ $lapangan->jenis }}</strong>
                        </div>
                        <div class="info-row">
                            <span>Harga / Jam</span>
                            <strong class="text-success">Rp {{ number_format($lapangan->harga_per_jam,0,',','.') }}</strong>
                        </div>

                        <div class="alert alert-info mt-3 small">
                            💡 Pilih tipe sewa untuk melihat jadwal yang tersedia
                        </div>

                        <div class="total-box">
                            <span>Total Bayar (<span id="durasiText">0</span>)</span>
                            <strong>Rp <span id="totalBayar">0</span></strong>
                        </div>
                    </div>
                </div>

                <!-- KANAN: Form Reservasi -->
                <div class="col-lg-7">
                    <form action="{{ route('user.reservasi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="lapangan_id" value="{{ $lapangan->id }}">

                        <div class="card-soft">

                            <div class="mb-3">
                                <label class="form-label">Tipe Sewa</label>
                                <select name="tipe_sewa" id="tipeSewa" class="form-select" required>
                                    <option value="">-- Pilih Tipe Sewa --</option>
                                    <option value="harian">Harian</option>
                                    <option value="jam">Per Jam</option>
                                </select>
                            </div>

                            <div id="alertBentrok" class="alert alert-danger d-none small">
                                ❌ Jadwal yang kamu pilih sudah dibooking.
                            </div>

                            <!-- SEWA HARIAN -->
                            <div id="formHarian" class="d-none">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="form-control"
                                        value="{{ old('tanggal_mulai') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai" class="form-control"
                                        value="{{ old('tanggal_selesai') }}">
                                </div>
                            </div>

                            <!-- SEWA PER JAM -->
                            <div id="formJam" class="d-none">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai_display" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai_display" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Jam Mulai</label>
                                        <input type="time" name="jam_mulai" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Jam Selesai</label>
                                        <input type="time" name="jam_selesai" class="form-control">
                                    </div>
                                </div>

                                <!-- Hidden input agar dikirim ke controller -->
                                <input type="hidden" name="tanggal_mulai" id="tanggalMulaiHidden" value="{{ date('Y-m-d') }}">
                                <input type="hidden" name="tanggal_selesai" id="tanggalSelesaiHidden" value="{{ date('Y-m-d') }}">
                            </div>



                            <div class="text-end mt-4">
                                <button type="button" class="btn btn-outline-light px-4"
                                    onclick="if(confirm('Yakin ingin kembali? Data yang sudah diisi akan hilang.')) history.back()">
                                    ← Kembali
                                </button>
                                <button type="submit" class="btn btn-submit">
                                    Buat Reservasi
                                </button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="py-4 text-center">
        <div class="container">
            <small>© {{ date('Y') }} Lapangan Olahraga. All rights reserved.</small>
        </div>
    </footer>

    <script>
        // Toggle Form Tipe Sewa
        const tipeSewa = document.getElementById('tipeSewa');
        const formHarian = document.getElementById('formHarian');
        const formJam = document.getElementById('formJam');
        const durasiText = document.getElementById('durasiText');
        const totalBayar = document.getElementById('totalBayar');
        const hargaPerJam = parseInt(document.body.dataset.harga);
        const today = new Date().toISOString().split('T')[0];
        const btnSubmit = document.getElementById('btnSubmit');
        const alertWaktuLewat = document.getElementById('alertWaktuLewat');


        // toggle tipe sewa
        tipeSewa.addEventListener('change', () => {
            durasiText.innerText = '0';
            totalBayar.innerText = '0';

            if (tipeSewa.value === 'harian') {
                formHarian.classList.remove('d-none');
                formJam.classList.add('d-none');
                formHarian.querySelectorAll('input').forEach(i => i.disabled = false);
                formJam.querySelectorAll('input').forEach(i => i.disabled = true);
            } else if (tipeSewa.value === 'jam') {
                formJam.classList.remove('d-none');
                formHarian.classList.add('d-none');
                formJam.querySelectorAll('input').forEach(i => i.disabled = false);
                formHarian.querySelectorAll('input').forEach(i => i.disabled = true);

                // set default display input & hidden
                formJam.querySelector('input[name="tanggal_mulai_display"]').value = today;
                formJam.querySelector('input[name="tanggal_selesai_display"]').value = today;
                document.getElementById('tanggalMulaiHidden').value = today;
                document.getElementById('tanggalSelesaiHidden').value = today;
            } else {
                formHarian.classList.add('d-none');
                formJam.classList.add('d-none');
            }
        });

        // Hitung total bayar

        // sinkron hidden input saat user ubah display input
        formJam.querySelector('input[name="tanggal_mulai_display"]').addEventListener('change', e => {
            document.getElementById('tanggalMulaiHidden').value = e.target.value;
        });
        formJam.querySelector('input[name="tanggal_selesai_display"]').addEventListener('change', e => {
            document.getElementById('tanggalSelesaiHidden').value = e.target.value;
        });

        // Hitung total bayar
        function hitungTotal() {
            if (tipeSewa.value === 'harian') {
                const mulai = formHarian.querySelector('input[name="tanggal_mulai"]');
                const selesai = formHarian.querySelector('input[name="tanggal_selesai"]');
                if (!mulai.value || !selesai.value) return;
                const diffHari = Math.ceil((new Date(selesai.value) - new Date(mulai.value)) / (1000 * 60 * 60 * 24)) + 1;
                if (diffHari <= 0) return;
                const total = diffHari * 24 * hargaPerJam;
                durasiText.innerText = `${diffHari} hari`;
                totalBayar.innerText = total.toLocaleString('id-ID');
            }
            if (tipeSewa.value === 'jam') {
                const tglMulai = formJam.querySelector('input[name="tanggal_mulai_display"]').value;
                const tglSelesai = formJam.querySelector('input[name="tanggal_selesai_display"]').value;
                const jmMulai = formJam.querySelector('input[name="jam_mulai"]').value;
                const jmSelesai = formJam.querySelector('input[name="jam_selesai"]').value;
                if (!tglMulai || !tglSelesai || !jmMulai || !jmSelesai) return;

                const mulai = new Date(`${tglMulai}T${jmMulai}`);
                const selesai = new Date(`${tglSelesai}T${jmSelesai}`);
                const diffJam = (selesai - mulai) / (1000 * 60 * 60);
                if (diffJam <= 0) return;

                const total = diffJam * hargaPerJam;
                durasiText.innerText = `${diffJam} jam`;
                totalBayar.innerText = total.toLocaleString('id-ID');

                // selalu update hidden input
                document.getElementById('tanggalMulaiHidden').value = tglMulai;
                document.getElementById('tanggalSelesaiHidden').value = tglSelesai;
            }
        }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>