@extends('layouts.admin') {{-- Sesuaikan dengan layout admin Anda --}}

@section('title', 'Edit Reservasi')

@section('content')
    <div class="container mt-5">
        <h3>Edit Reservasi #{{ $reservasi->id }}</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>❌ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.reservasi.update', $reservasi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama User</label>
                <input type="text" class="form-control" value="{{ $reservasi->user->nama ?? $reservasi->user->name }}"
                    disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Lapangan</label>
                <input type="text" class="form-control" value="{{ $reservasi->lapangan->nama_lapangan }}" disabled>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ $reservasi->tanggal_mulai }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control"
                        value="{{ $reservasi->tanggal_selesai }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="form-control"
                        value="{{ old('jam_mulai', $reservasi->jam_mulai ? \Carbon\Carbon::parse($reservasi->jam_mulai)->format('H:i') : '') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jam Selesai</label>
                    <input type="time" name="jam_selesai" class="form-control"
                        value="{{ old('jam_selesai', $reservasi->jam_selesai ? \Carbon\Carbon::parse($reservasi->jam_selesai)->format('H:i') : '') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="pending" {{ $reservasi->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="disetujui" {{ $reservasi->status === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ $reservasi->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="selesai" {{ $reservasi->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="text-end">
                <a href="{{ route('admin.reservasi.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection
