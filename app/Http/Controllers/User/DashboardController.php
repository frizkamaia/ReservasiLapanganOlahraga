<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // kalau nanti mau kirim data (user, lapangan, dll) tinggal tambah di sini
        return view('user.dashboard');
    }
}
