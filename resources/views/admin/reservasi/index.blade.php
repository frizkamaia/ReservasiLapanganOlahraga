@extends('layouts.admin')

@section('content')
<div class="content">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Data Reservasi</h3>
    </div>

    <div class="card bg-dark text-white">
        <div class="card-body">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Lapangan</th>
                        <th>Tanggal</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($reservasi as $index => $r)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $r->user->nama ?? '-' }}</td>
                        <td>{{ $r->lapangan->nama_lapangan ?? '-' }}</td>
                        <td>
                            @if($r->tipe_sewa === 'harian' && $r->jadwal)
                            {{ \Carbon\Carbon::parse($r->jadwal->tanggal_mulai)->format('d M Y') }}
                            s/d
                            {{ \Carbon\Carbon::parse($r->jadwal->tanggal_selesai)->format('d M Y') }}
                            @elseif($r->tipe_sewa === 'jam' && $r->jadwal)
                            {{ \Carbon\Carbon::parse($r->jadwal->tanggal)->format('d M Y') }}
                            {{ $r->jadwal->jam_mulai ?? '-' }} - {{ $r->jadwal->jam_selesai ?? '-' }}
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            Rp {{ number_format($r->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="status-{{ $r->status }}">
                            {{ ucfirst($r->status) }}
                        </td>
                        <td>
                            @if ($r->pembayaran)
                            <span class="badge bg-success">Sudah Bayar</span>
                            @else
                            <span class="badge bg-warning text-dark">Belum Bayar</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.reservasi.show', $r->id) }}" class="text-info">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-secondary">
                            Data reservasi belum tersedia
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection