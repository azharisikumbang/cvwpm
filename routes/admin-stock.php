<?php

use App\Http\Controllers\AdminStock\BarangController;
use App\Http\Controllers\AdminStock\BarangMasukController;
use App\Http\Controllers\AdminStock\DeliveryOrderController;
use App\Http\Controllers\AdminStock\DownloadSuratPindahGudangController;
use App\Http\Controllers\AdminStock\HomeController;
use App\Http\Controllers\AdminStock\KartuStokController;
use App\Http\Controllers\AdminStock\MarkSalesCanvasDoneController;
use App\Http\Controllers\AdminStock\PengajuanPembelianController;
use App\Http\Controllers\AdminStock\PindahGudangController;
use App\Http\Controllers\AdminStock\PindahGudangTujuanController;
use App\Http\Controllers\AdminStock\PurchaseOrderController;
use App\Http\Controllers\AdminStock\SalesCanvasController;
use App\Http\Controllers\AdminStock\TokoController;
use App\Http\Controllers\DownloadSuratJalanCanvasController;
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

        // po
        Route::get('/purchase-order', [PurchaseOrderController::class, 'index'])->name('admin-stock.purchase-order.index');
        Route::get('/purchase-order/{purchase_order}', [PurchaseOrderController::class, 'show'])->name('admin-stock.purchase-order.show');
        Route::get('/purchase-order/{purchase_order}/edit', [PurchaseOrderController::class, 'edit'])->name('admin-stock.purchase-order.edit');

        // do
        Route::post('/delivery-order/{purchase_order}', [DeliveryOrderController::class, 'store'])->name('admin-stock.delivery-order.store');


        // sales canvas
        Route::post('/sales-canvas/create', [SalesCanvasController::class, 'store'])->name('admin-stock.sales-canvas.store');
        Route::get('/sales-canvas', [SalesCanvasController::class, 'index'])->name('admin-stock.sales-canvas.index');
        Route::get('/sales-canvas/create', [SalesCanvasController::class, 'create'])->name('admin-stock.sales-canvas.create');
        Route::get('/sales-canvas/{salesCanvas}', [SalesCanvasController::class, 'show'])->name('admin-stock.sales-canvas.show');
        Route::get('/sales-canvas/{salesCanvas}/edit', [SalesCanvasController::class, 'edit'])->name('admin-stock.sales-canvas.edit');
        Route::put('/sales-canvas/{salesCanvas}/done', [MarkSalesCanvasDoneController::class, '__invoke'])->name('admin-stock.sales-canvas.done');
        Route::get('/sales-canvas/{salesCanvas}/download', [DownloadSuratJalanCanvasController::class, '__invoke'])->name('admin-stock.sales-canvas.download');


        // riwayat barang masuk
        Route::get('/riwayat-barang-masuk', [BarangMasukController::class, 'index'])->name('admin-stock.riwayat-barang-masuk.index');

        // pindah gudang
        Route::resource('/pindah-gudang', PindahGudangController::class)->names('admin-stock.pindah-gudang');
        Route::get('/pindah-gudang-tujuan', [PindahGudangTujuanController::class, 'index'])->name('admin-stock.pindah-gudang-tujuan.index');
        Route::get('/pindah-gudang/{pindah_gudang}/download', [DownloadSuratPindahGudangController::class, '__invoke'])->name('admin-stock.pindah-gudang.download');

        // laporan kartu stok
        Route::get('/kartu-stok', [KartuStokController::class, 'index'])->name('admin-stock.kartu-stok.index');
        Route::get('/kartu-stok/create', [KartuStokController::class, 'create'])->name('admin-stock.kartu-stok.create');

    });
