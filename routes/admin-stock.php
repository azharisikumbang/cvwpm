<?php

use App\Http\Controllers\AdminStock\BarangController;
use App\Http\Controllers\AdminStock\HomeController;
use App\Http\Controllers\AdminStock\PengajuanPembelianController;
use App\Http\Controllers\AdminStock\TokoController;
use App\Models\Role;


Route::prefix('admin-stock')
    ->middleware(['auth', sprintf("role:%s", Role::ID_ADMIN_STOCK)])
    ->group(function () {
        Route::get('/', [HomeController::class, '__invoke'])->name('admin-stock.index');

        // barang management
        Route::resource('/barang', BarangController::class)->names('admin-stock.barang');

        // toko management
        Route::resource('/toko', TokoController::class)->names('admin-stock.toko');

        // pengajuan pembelian
        Route::get('/pengajuan-pembelian', [PengajuanPembelianController::class, 'index'])->name('admin-stock.pengajuan-pembelian.index');
        Route::get('/pengajuan-pembelian/create', [PengajuanPembelianController::class, 'create'])->name('admin-stock.pengajuan-pembelian.create');
        Route::post('/pengajuan-pembelian', [PengajuanPembelianController::class, 'store'])->name('admin-stock.pengajuan-pembelian.store');
        Route::get('/pengajuan-pembelian/{pengajuanPembelian}', [PengajuanPembelianController::class, 'show'])->name('admin-stock.pengajuan-pembelian.show');

    });
