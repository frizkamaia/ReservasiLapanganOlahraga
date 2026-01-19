@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold mb-4">Tambah Lapangan</h3>

    <form action="{{ route('admin.lapangan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Lapangan</label>
            <input type="text" name="nama_lapangan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis</label>
            <input type="text" name="jenis" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga per Jam</label>
            <input type="number" name="harga_per_jam" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Foto (Opsional)</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.lapangan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>

</div>
@endsection
