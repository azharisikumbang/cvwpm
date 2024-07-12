<?php

use App\Http\Controllers\AdminStock\BarangController;
use App\Http\Controllers\AdminStock\HomeController;
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
    });
