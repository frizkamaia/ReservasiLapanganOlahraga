@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="card bg-dark text-white">
            <div class="card-body">

                <form action="{{ route('admin.jadwal.store') }}" method="POST">
                    @csrf

                    {{-- LAPANGAN --}}
                    <div class="mb-3">
                        <label class="form-label">Lapangan</label>
                        <select name="lapangan_id" class="form-control" required>
                            <option value="">-- Pilih Lapangan --</option>
                            @foreach ($lapangan as $l)
                                <option value="{{ $l->id }}">
                                    {{ $l->nama_lapangan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TANGGAL --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control" required>
                        </div>
                    </div>

                    {{-- JAM (OPSIONAL) --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Jam Mulai <small class="text-muted">(opsional)</small>
                            </label>
                            <input type="time" name="jam_mulai" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Jam Selesai <small class="text-muted">(opsional)</small>
                            </label>
                            <input type="time" name="jam_selesai" class="form-control">
                        </div>
                    </div>

                    <small class="text-warning d-block mb-3">
                        Kosongkan jam jika ingin membuat jadwal sewa harian
                    </small>

                    {{-- STATUS --}}
                    <div class="mb-4">
                        <label class="form-label">Status Jadwal</label>
                        <select name="status" class="form-control" required>
                            <option value="available">Available</option>
                            <option value="booked">Booked</option>
                        </select>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    {{-- BUTTON --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                        <button class="btn btn-success">
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
