<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Lapangan | Lapangan Olahraga</title>

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

        /* CARD LAPANGAN */
        .card-lapangan {
            background-color: #1f2937;
            border-radius: 16px;
            overflow: hidden;
            border: none;
            transition: transform .2s, box-shadow .2s;
        }

        .card-lapangan:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
        }

        .card-lapangan img {
            height: 180px;
            object-fit: cover;
        }

        .card-body h5 {
            font-weight: 600;
            color: #f9fafb;
        }

        .card-body p {
            font-size: 14px;
            color: #d1d5db;
        }

        .btn-detail {
            background-color: #64748b;
            color: #ffffff;
            border-radius: 30px;
            padding: 8px 22px;
            font-size: 14px;
            border: none;
        }

        .btn-detail:hover {
            background-color: #94a3b8;
            color: #020617;
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Daftar Lapangan</h3>
        </div>

        <div class="row g-4">
            @foreach ($lapangan as $item)
                <div class="col-md-4">
                    <div class="card card-lapangan">

                        <img
                            src="{{ $item->foto
                                ? asset('storage/' . $item->foto)
                                : 'https://via.placeholder.com/400x200?text=Lapangan' }}"
                            alt="{{ $item->nama_lapangan }}">

                        <div class="card-body text-center">
                            <h5>{{ $item->nama_lapangan }}</h5>
                            <p>
                                Rp {{ number_format($item->harga_per_jam, 0, ',', '.') }} / Jam
                            </p>
                            <a href="{{ route('user.lapangan.show', $item->id) }}" class="btn btn-detail">
                                Lihat Detail
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
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
