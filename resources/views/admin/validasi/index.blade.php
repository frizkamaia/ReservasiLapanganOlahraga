
@extends('layouts.admin')

@section('content')
            <div class="content">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold">Data Pembayaran</h3>
                </div>

                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <table class="table table-dark table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Lapangan</th>
                                    <th>Total Bayar</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($pembayaran as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $p->reservasi->user->nama ?? '-' }}</td>
                                    <td>{{ $p->reservasi->lapangan->nama_lapangan ?? '-' }}</td>
                                    <td>
                                        Rp {{ number_format($p->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td>{{ ucfirst($p->metode) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $p->status == 'valid' ? 'success' : 'warning text-dark' }}">
                                            {{ ucfirst($p->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.validasi.show', $p->id) }}" class="text-info">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-secondary">
                                        Data pembayaran belum tersedia
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>
            @endsection
