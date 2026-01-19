
@extends('layouts.admin')

@section('content')
            <div class="content">

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold mb-0">Data User</h3>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-success">
                        + Tambah User
                    </a>
                </div>

                <div class="card bg-dark text-white">
                    <div class="card-body p-0">
                        <table class="table table-dark table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th width="15%">Total Reservasi</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($users as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->nama }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->reservasi_count }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-warning">
                                                Edit
                                            </a>
                                            |
                                            <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Hapus user ini?')">
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
                                        <td colspan="5" class="text-center text-secondary">
                                            Belum ada data user
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>
@endsection