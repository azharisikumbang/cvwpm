<?php

use App\Http\Controllers\AdminStock\KartuStokController;
use App\Http\Controllers\LaporanPersediaanController;
use App\Http\Controllers\Manager\HomeController;
use App\Models\Role;

Route::prefix('manager')
    ->middleware(['auth', sprintf("role:%s", Role::ID_MANAGER)])
    ->group(function () {

        Route::get('/', HomeController::class)
            ->name('manager.home');

        Route::get('laporan-kartu-stok', [KartuStokController::class, 'index'])
            ->name('manager.laporan-kartu-stok.index');

        Route::post('laporan-kartu-stok', [KartuStokController::class, 'show'])
            ->name('manager.laporan-kartu-stok.show');

        Route::get('laporan-persediaan', [LaporanPersediaanController::class, 'create'])
            ->name('manager.laporan-persediaan.create');

        Route::post('laporan-persediaan', [LaporanPersediaanController::class, 'show'])
            ->name('manager.laporan-persediaan.show');

    });