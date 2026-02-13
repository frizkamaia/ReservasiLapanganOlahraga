<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Admin | Lapangan Olahraga</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f3f4f6;
        }

        .navbar {
            background-color: #2c3f57;
        }

        .navbar-brand,
        .nav-link {
            color: #fff !important;
        }

        .chat-box {
            max-width: 900px;
            margin: 110px auto 40px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
            padding: 20px;
        }

        .chat-body {
            height: 400px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .msg-user {
            text-align: right;
        }

        .msg-user span {
            background: #2563eb;
            color: #fff;
            padding: 8px 12px;
            border-radius: 12px;
            display: inline-block;
            margin-bottom: 8px;
        }

        .msg-admin span {
            background: #e5e7eb;
            padding: 8px 12px;
            border-radius: 12px;
            display: inline-block;
            margin-bottom: 8px;
        }

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
        <a class="navbar-brand" href="{{ route('home') }}">
            Lapangan Olahraga
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">

            <!-- MENU TENGAH -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">

                <!-- HOME / LAPANGAN (PUBLIC) -->
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}">Lapangan</a>
                </li>

                <!-- MENU KHUSUS JIKA LOGIN -->
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.dashboard') }}">Dashboard</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.reservasi.index') }}">Reservasi</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.chat.index') }}">
                            Chat Admin
                        </a>
                    </li>
                @endauth

            </ul>

            <!-- KANAN (LOGIN / LOGOUT) -->
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-light btn-sm">
                    Login
                </a>
            @endauth

        </div>
    </div>
</nav>

    <!-- CHAT -->
    <div class="chat-box">
        <h5 class="fw-bold mb-3">Chat dengan Admin</h5>

        <div class="chat-body">
            @foreach ($chats as $chat)
            <div class="{{ $chat->pengirim === 'user' ? 'msg-user' : 'msg-admin' }}">
                <span>{{ $chat->pesan }}</span>
            </div>
            @endforeach
        </div>

        <form method="POST" action="{{ route('user.chat.store') }}">
            @csrf
            <div class="input-group">
                <input type="text" name="pesan" class="form-control">
                <button class="btn btn-primary">Kirim</button>
            </div>
        </form>
    </div>

    <!-- FOOTER -->
    <footer class="py-4 text-center">
        <small>© {{ date('Y') }} Lapangan Olahraga</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>