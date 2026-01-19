@extends('layouts.admin')

@section('content')
            <div class="content">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold">Data Lapangan</h3>
                    <a href="{{ route('admin.lapangan.create') }}" class="btn btn-success">+ Tambah</a>
                </div>

                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lapangan</th>
                                    <th>Jenis</th>
                                    <th>Harga per Jam</th>
                                    <th>Foto</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($lapangan as $index => $l)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $l->nama_lapangan }}</td>
                                    <td>{{ $l->jenis }}</td>
                                    <td>Rp {{ number_format($l->harga_per_jam, 0, ',', '.') }}</td>
                                    <td>
                                        @if($l->foto)
                                            <img src="{{ asset('storage/' . $l->foto) }}" width="70">
                                        @else
                                            <span class="text-secondary">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.lapangan.edit', $l->id) }}" class="text-warning">Edit</a>|
                                        <form action="{{ route('admin.lapangan.destroy', $l->id) }}" method="POST" onsubmit="return confirm('Hapus data?');">
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

        </main>
    </div>
</div>
@endsection
