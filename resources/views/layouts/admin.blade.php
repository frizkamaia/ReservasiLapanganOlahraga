<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Lapangan Olahraga</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #343a40;
            color: #f8f9fa;
        }

        /* ================= SIDEBAR ================= */
        .sidebar {
            height: 100vh;
            background: linear-gradient(180deg, #1f2933, #111827);
            padding: 20px 12px;
            position: sticky;
            top: 0;
            box-shadow: 4px 0 15px rgba(0,0,0,.25);
        }

        .sidebar h4 {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 24px;
            text-align: center;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #cbd5e1;
            padding: 10px 14px;
            margin-bottom: 8px;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link:hover {
            background-color: #334155;
            color: #ffffff;
        }

        .sidebar .nav-link.active {
            background-color: #2563eb;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }

        /* ================= HEADER ================= */
        .navbar-header {
            background-color: #212529;
            color: #f8f9fa;
            padding: 14px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #495057;
        }

        /* ================= CONTENT ================= */
        .content {
            padding: 32px;
            min-height: calc(100vh - 64px);
        }

        /* Batasi lebar konten biar rapi di layar besar */
        .content > * {
            max-width: 1100px;
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <nav class="col-md-3 col-lg-2 d-md-block sidebar">
            <div class="d-flex flex-column h-100">

                <h4 class="text-white">Lapangan Olahraga </h4>

                <ul class="nav flex-column mt-3">

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                           href="{{ route('admin.dashboard') }}">
                            <i class="fa-solid fa-chart-line"></i>
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}"
                           href="{{ route('admin.users.index') }}">
                            <i class="fa-solid fa-users"></i>
                            Data User
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/lapangan*') ? 'active' : '' }}"
                           href="{{ route('admin.lapangan.index') }}">
                            <i class="fa-solid fa-futbol"></i>
                            Data Lapangan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/jadwal*') ? 'active' : '' }}"
                           href="{{ route('admin.jadwal.index') }}">
                            <i class="fa-solid fa-calendar-days"></i>
                            Data Jadwal
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/reservasi*') ? 'active' : '' }}"
                           href="{{ route('admin.reservasi.index') }}">
                            <i class="fa-solid fa-bookmark"></i>
                            Reservasi
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/validasi*') ? 'active' : '' }}"
                           href="{{ route('admin.validasi.index') }}">
                            <i class="fa-solid fa-circle-check"></i>
                            Validasi Pembayaran
                        </a>
                    </li>

                </ul>

                <div class="mt-auto text-center text-secondary small">
                    © 2026 Lapangan Olahraga
                </div>

            </div>
        </nav>

        <!-- MAIN -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-0">

            {{-- HEADER PER HALAMAN --}}
            @hasSection('header')
                @yield('header')
            @else
                <div class="navbar-header">
                    <h5 class="mb-0">Admin Panel</h5>
                <form action="/logout" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-outline-light">
                        Logout
                    </button>
                </form>
                </div>
            @endif

            {{-- CONTENT --}}
            <div class="content">
                @yield('content')
            </div>

        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>