@extends('layouts.admin')

@section('content')

{{-- Welcome Banner --}}
<div class="p-4 mb-4 rounded shadow-sm bg-primary text-white">
    <h3 class="mb-1">👋 Welcome Back, Admin</h3>
    <p class="mb-0 opacity-75">
        Kelola data lapangan, jadwal, reservasi, dan validasi pembayaran melalui menu di samping.
    </p>
</div>

{{-- Informasi Singkat --}}
<div class="card bg-dark text-white shadow-sm border-0">
    <div class="card-body">
        <h5 class="mb-3">📌 Panduan Singkat</h5>
        <ul class="mb-0">
            <li>Gunakan menu <strong>Data Lapangan</strong> untuk mengatur lapangan</li>
            <li>Menu <strong>Data Jadwal</strong> untuk jam operasional</li>
            <li><strong>Reservasi</strong> untuk melihat booking user</li>
            <li><strong>Validasi Pembayaran</strong> untuk menyetujui pembayaran</li>
        </ul>
    </div>
</div>

@endsection