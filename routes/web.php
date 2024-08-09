<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanFakturPenjualanCanvasController;
use App\Http\Controllers\LaporanKartuStokController;
use App\Http\Controllers\LaporanPersediaanController;
use App\Http\Controllers\User\ChangePasswordController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

// public
Route::get('/daftar-supplier', function () {
    echo "INi pendaftaran untuk supplier";

    return;
});

Route::get('/', [AuthenticationController::class, 'login'])->name('homepage');
Route::get('/login', [AuthenticationController::class, 'login'])->name('authentication.login');
Route::post('/login', [AuthenticationController::class, 'authenticate'])->name('authentication.authenticate');
Route::post('/logout', [AuthenticationController::class, 'logout'])->name('authentication.logout');

Route::get('laporan-persediaan', [LaporanPersediaanController::class, 'create'])
    ->name('laporan-persediaan.create');

Route::get('laporan-persediaan/{gudang}/{year}/{month}', [LaporanPersediaanController::class, 'show'])
    ->name('laporan-persediaan.show');


// authenticated
Route::prefix('user')
    ->middleware('auth')
    ->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile.index');
        Route::put('/profile', [ProfileController::class, 'update'])->name('user.profile.update');
        Route::get('/password', [ChangePasswordController::class, 'index'])->name('user.password.index');
        Route::put('/password', [ChangePasswordController::class, 'update'])->name('user.password.update');
    });


// role based routes
require __DIR__ . '/admin-web.php';
require __DIR__ . '/admin-stock.php';
require __DIR__ . '/admin-purchasing.php';
require __DIR__ . '/sales.php';
require __DIR__ . '/manager.php';