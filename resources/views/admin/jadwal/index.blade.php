@extends('layouts.admin')

@section('content')
    <div class="content">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Tabel Jadwal</h3>
            <a href="{{ route('admin.jadwal.create') }}" class="btn btn-success">
                + Tambah
            </a>
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
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($jadwal as $index => $j)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>
                                    {{ $j->lapangan->nama_lapangan }}
                                </td>

                                {{-- TANGGAL --}}
                                <td>
                                    @if ($j->tanggal_mulai && $j->tanggal_selesai)
                                        @if ($j->tanggal_mulai === $j->tanggal_selesai)
                                            {{ \Carbon\Carbon::parse($j->tanggal_mulai)->format('d-m-Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($j->tanggal_mulai)->format('d-m-Y') }}
                                            s/d
                                            {{ \Carbon\Carbon::parse($j->tanggal_selesai)->format('d-m-Y') }}
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                {{-- JAM --}}
                                <td>
                                    @if ($j->jam_mulai && $j->jam_selesai)
                                        {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}
                                        -
                                        {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                    @else
                                        <span class="text-white">Full sewa harian</span>
                                    @endif
                                </td>

                                {{-- TIPE --}}
                                <td>
                                    @if ($j->jam_mulai && $j->jam_selesai)
                                        <span class="badge bg-info">Per Jam</span>
                                    @else
                                        <span class="badge bg-secondary">Harian</span>
                                    @endif
                                </td>

                                {{-- STATUS --}}
                                <td>
                                    @if ($j->status === 'available')
                                        <span class="badge bg-success">Available</span>
                                    @else
                                        <span class="badge bg-danger">Booked</span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td>
                                    <a href="{{ route('admin.jadwal.edit', $j->id) }}" class="text-warning me-2">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.jadwal.destroy', $j->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus jadwal ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-link text-danger p-0 m-0">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Belum ada data jadwal
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>
        </div>

    </div>
@endsection
