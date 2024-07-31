<?php

use App\Http\Controllers\DownloadSuratJalanCanvasController;
use App\Http\Controllers\Sales\CanvasController;
use App\Http\Controllers\Sales\HomeController;
use App\Http\Controllers\Sales\PenjualanController;
use App\Models\Role;

Route::prefix('sales')
    ->middleware(['auth', sprintf("role:%s", Role::ID_SALES)])
    ->group(function () {
        Route::get('/', [HomeController::class, '__invoke'])->name('sales.index');

        Route::get('/canvas', [CanvasController::class, 'index'])->name('sales.canvas.index');
        Route::get('/canvas/{canvas}', [CanvasController::class, 'show'])->name('sales.canvas.show');
        Route::get('/canvas/{canvas}/download', [DownloadSuratJalanCanvasController::class, '__invoke'])->name('sales.canvas.download');


        Route::get('/penjualan', [PenjualanController::class, 'index'])->name('sales.penjualan.index');
        Route::post('/penjualan', [PenjualanController::class, 'store'])->name('sales.penjualan.store');
    });