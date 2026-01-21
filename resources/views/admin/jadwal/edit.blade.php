@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="card bg-dark text-white">
            <div class="card-body">

                <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- LAPANGAN --}}
                    <div class="mb-3">
                        <label>Lapangan</label>
                        <select name="lapangan_id" class="form-control" required>
                            @foreach ($lapangan as $l)
                                <option value="{{ $l->id }}"
                                    {{ old('lapangan_id', $jadwal->lapangan_id) == $l->id ? 'selected' : '' }}>
                                    {{ $l->nama_lapangan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TANGGAL MULAI --}}
                    <div class="mb-3">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai"
                            value="{{ old('tanggal_mulai', optional($jadwal->tanggal_mulai)->format('Y-m-d')) }}"
                            class="form-control" required>
                    </div>

                    {{-- TANGGAL SELESAI --}}
                    <div class="mb-3">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai"
                            value="{{ old('tanggal_selesai', optional($jadwal->tanggal_selesai)->format('Y-m-d')) }}"
                            class="form-control" required>
                    </div>

                    {{-- JAM --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Jam Mulai</label>
                            <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $jadwal->jam_mulai) }}"
                                class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Jam Selesai</label>
                            <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $jadwal->jam_selesai) }}"
                                class="form-control">
                        </div>
                    </div>

                    {{-- STATUS --}}
                    <div class="mb-4">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="available" {{ old('status', $jadwal->status) == 'available' ? 'selected' : '' }}>
                                Available
                            </option>
                            <option value="booked" {{ old('status', $jadwal->status) == 'booked' ? 'selected' : '' }}>
                                Booked
                            </option>
                        </select>
                    </div>

                    {{-- BUTTON --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                        <button class="btn btn-warning">
                            Update
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
