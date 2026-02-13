@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="fw-bold mb-4">Chat dari User</h4>

    <div class="card">
        <div class="list-group list-group-flush">

            @foreach ($users as $item)
            <a href="{{ route('admin.chat.show', $item->user_id) }}"
                class="list-group-item list-group-item-action">
                {{ $item->user->nama }}
                <span class="badge bg-primary float-end">Buka Chat</span>
            </a>
            @endforeach

        </div>
    </div>
</div>
@endsection