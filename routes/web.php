<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/

// ================= ADMIN =================
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\Admin\ChatAdminController;

// ================= USER ==================
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\LapanganController as UserLapanganController;
use App\Http\Controllers\User\JadwalController as UserJadwalController;
use App\Http\Controllers\User\ReservasiController as UserReservasiController;
use App\Http\Controllers\User\PembayaranController as UserPembayaranController;
use App\Http\Controllers\User\ChatUserController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/register', [RegisteredUserController::class, 'show'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// HALAMAN AWAL TANPA LOGIN
Route::get('/', [UserLapanganController::class, 'index'])
    ->name('home');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');
        Route::get('/laporan', [LaporanController::class, 'index'])
            ->name('laporan.index');
        Route::get('/chat', [ChatAdminController::class, 'index'])
            ->name('chat.index');
        Route::get('/chat/{user}', [ChatAdminController::class, 'show'])
            ->name('chat.show');
        Route::post('/chat/{user}', [ChatAdminController::class, 'reply'])
            ->name('chat.reply');

        Route::resource('users', UsersController::class);
        Route::resource('lapangan', LapanganController::class);
        Route::resource('jadwal', JadwalController::class);
        Route::resource('reservasi', ReservasiController::class);
        Route::resource('validasi', PembayaranController::class)
            ->only(['index', 'show', 'update'])
            ->parameters(['validasi' => 'pembayaran']);
    });
/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('user')
    ->name('user.')
    ->middleware(['auth', 'role:user'])
    ->group(function () {

        Route::get('/dashboard', [UserDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/lapangan', [UserLapanganController::class, 'index'])
            ->name('lapangan.index');

        Route::get('/lapangan/{lapangan}', [UserLapanganController::class, 'show'])
            ->name('lapangan.show');

        Route::get('/lapangan/{lapangan}/jadwal', [UserJadwalController::class, 'index'])
            ->name('jadwal.index');

        Route::get('/reservasi/{lapangan}', [UserReservasiController::class, 'create'])
            ->name('reservasi.create');

        Route::post('/reservasi', [UserReservasiController::class, 'store'])
            ->name('reservasi.store');
        Route::get('/reservasi', [UserReservasiController::class, 'index'])
            ->name('reservasi.index');

        Route::get('/reservasi/detail/{id}', [UserReservasiController::class, 'show'])
            ->name('reservasi.show');

        Route::get('/reservasi/{id}/struk', [UserReservasiController::class, 'struk'])
            ->name('reservasi.struk');

        Route::post('/reservasi/jadwal-terbooking', [UserReservasiController::class, 'jadwalTerbooking'])
            ->name('reservasi.jadwalTerbooking');

        Route::get('/pembayaran/{reservasi}', [UserPembayaranController::class, 'create'])
            ->name('pembayaran.create');

        Route::post('/pembayaran/{reservasi}', [UserPembayaranController::class, 'store'])
            ->name('pembayaran.store');

        Route::get('/chat', [ChatUserController::class, 'index'])
            ->name('chat.index');

        Route::post('/chat/kirim', [ChatUserController::class, 'store'])
            ->name('chat.store');
    });


/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
