
@extends('layouts.admin')

@section('content')
            <div class="content">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold">Tabel Jadwal</h3>
                    <a href="{{ route('admin.jadwal.create') }}" class="btn btn-success">+ Tambah</a>
                </div>

                <div class="card bg-dark text-white">
                    <div class="card-body">

                        <table class="table table-dark table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Lapangan</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($jadwal as $index => $j)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $j->lapangan->nama_lapangan }}</td>
                                    <td>{{ \Carbon\Carbon::parse($j->tanggal)->format('d-m-Y') }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}
                                        -
                                        {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                    </td>
                                    <td>
                                        @if ($j->status == 'available')
                                            <span class="badge badge-available">Available</span>
                                        @else
                                            <span class="badge badge-booked">Booked</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.jadwal.edit', $j->id) }}" class="text-warning me-2">Edit</a>

                                        <form action="{{ route('admin.jadwal.destroy', $j->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Hapus jadwal ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-link text-danger p-0 m-0">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>

                    </div>
                </div>

            </div>
            @endsection
