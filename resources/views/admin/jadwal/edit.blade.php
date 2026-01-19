
@extends('layouts.admin')

@section('content')
            <div class="content">
                <div class="card bg-dark text-white">
                    <div class="card-body">

                        <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label>Lapangan</label>
                                <select name="lapangan_id" class="form-control" required>
                                    @foreach ($lapangan as $l)
                                        <option value="{{ $l->id }}"
                                            {{ $jadwal->lapangan_id == $l->id ? 'selected' : '' }}>
                                            {{ $l->nama_lapangan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Tanggal</label>
                                <input type="date"
                                       name="tanggal"
                                       value="{{ $jadwal->tanggal->format('Y-m-d') }}"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Jam Mulai</label>
                                    <input type="time"
                                           name="jam_mulai"
                                           value="{{ substr($jadwal->jam_mulai, 0, 5) }}"
                                           class="form-control"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Jam Selesai</label>
                                    <input type="time"
                                           name="jam_selesai"
                                           value="{{ substr($jadwal->jam_selesai, 0, 5) }}"
                                           class="form-control"
                                           required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label>Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="available" {{ $jadwal->status == 'available' ? 'selected' : '' }}>
                                        Available
                                    </option>
                                    <option value="booked" {{ $jadwal->status == 'booked' ? 'selected' : '' }}>
                                        Booked
                                    </option>
                                </select>
                            </div>

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
        