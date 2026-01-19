@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold mb-4">Edit Lapangan</h3>

    <form action="{{ route('admin.lapangan.update', $lapangan->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Lapangan</label>
            <input type="text" name="nama_lapangan" class="form-control" value="{{ $lapangan->nama_lapangan }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis</label>
            <input type="text" name="jenis" class="form-control" value="{{ $lapangan->jenis }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga per Jam</label>
            <input type="number" name="harga_per_jam" class="form-control" value="{{ $lapangan->harga_per_jam }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4">{{ $lapangan->deskripsi }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Foto Baru (Opsional)</label>
            <input type="file" name="foto" class="form-control">
        </div>

        @if($lapangan->foto)
        <div class="mb-3">
            <label class="form-label">Foto Lama</label><br>
            <img src="{{ asset('storage/' . $lapangan->foto) }}" width="120">
        </div>
        @endif

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.lapangan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>

</div>
@endsection
