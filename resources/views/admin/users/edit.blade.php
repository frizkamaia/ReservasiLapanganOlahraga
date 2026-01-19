
@extends('layouts.admin')

@section('content')
                <div class="content">
                    <div class="card bg-dark text-white">
                        <div class="card-body">

                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="nama" class="form-control"
                                        value="{{ $user->nama }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ $user->email }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password (opsional)</label>
                                    <input type="password" name="password" class="form-control">
                                    <small class="text-secondary">Kosongkan jika tidak ingin mengubah password</small>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
                                    <button class="btn btn-success">Update</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                @endsection