<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Lapangan Olahraga</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        /* NAVBAR */
        .navbar {
            background-color: #2c3f57;
        }

        .navbar-brand {
            font-weight: bold;
            color: #fff !important;
        }

        .nav-link {
            color: #d1d5db !important;
            font-weight: 500;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #fff !important;
        }

        /* HERO */
        .hero {
            min-height: 90vh;
            background: url('https://images.unsplash.com/photo-1546519638-68e109498ffc') center / cover no-repeat;
            position: relative;
        }

        .hero-overlay {
            background-color: rgba(0, 0, 0, 0.55);
            min-height: 90vh;
            display: flex;
            align-items: center;
        }

        .hero-text h1 {
            font-size: 42px;
            font-weight: bold;
        }

        .btn-custom {
            background-color: #cfd6df;
            color: #1f2937;
            border-radius: 30px;
            padding: 12px 32px;
            font-weight: 600;
            border: none;
        }

        .btn-custom:hover {
            background-color: #e5e7eb;
        }

        /* INFO CARD */
        .info-card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: transform .2s;
        }

        .info-card:hover {
            transform: translateY(-5px);
        }

        /* FOOTER */
        footer {
            background-color: #1f2937;
            color: #d1d5db;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <!-- Brand -->
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
                        <a class="nav-link active" href="{{ route('user.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.lapangan.index') }}">Lapangan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.reservasi.index') }}">Reservasi</a>
                    </li>
                </ul>

                <!-- LOGOUT KANAN -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-overlay">
            <div class="container text-white">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="hero-text">
                            <h1>Selamat Datang 👋</h1>
                            <p class="mt-3 mb-4 fs-5">
                                Pesan lapangan olahraga favoritmu dengan mudah, cepat, dan praktis.
                            </p>
                            <a href="{{ route('user.lapangan.index') }}" class="btn btn-custom">
                                Lihat Lapangan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- INFO SECTION -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <div class="card info-card p-4">
                        <h5 class="fw-bold">Lapangan Lengkap</h5>
                        <p class="text-muted mt-2">
                            Berbagai pilihan lapangan sesuai kebutuhan olahraga kamu.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card info-card p-4">
                        <h5 class="fw-bold">Reservasi Mudah</h5>
                        <p class="text-muted mt-2">
                            Proses cepat, tanpa ribet, bisa kapan saja.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card info-card p-4">
                        <h5 class="fw-bold">Pembayaran Aman</h5>
                        <p class="text-muted mt-2">
                            Tunai maupun transfer dengan validasi admin.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

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