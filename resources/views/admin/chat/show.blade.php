@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="fw-bold mb-3">Chat dengan {{ $user->nama }}</h4>

    <div class="card mb-3">
        <div class="card-body" style="height:400px; overflow-y:auto">
            @foreach ($messages as $msg)
                <div class="mb-2 {{ $msg->pengirim === 'admin' ? 'text-end' : '' }}">
                    <span class="badge {{ $msg->pengirim === 'admin' ? 'bg-primary' : 'bg-secondary' }}">
                        {{ $msg->pesan }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    <form method="POST" action="{{ route('admin.chat.reply', $user->id) }}">
        @csrf
        <div class="input-group">
            <input type="text" name="pesan" class="form-control" placeholder="Balas pesan..." required>
            <button class="btn btn-primary">Kirim</button>
        </div>
    </form>
</div>
@endsection
