<?php

use App\Http\Controllers\AdminPurchasing\HomeController;
use App\Http\Controllers\AdminPurchasing\PurchasingOrderController;
use App\Http\Controllers\AdminPurchasing\PengajuanPembelianController;
use App\Models\Role;

Route::prefix('admin-purchasing')
    ->middleware(['auth', sprintf("role:%s", Role::ID_ADMIN_PURCHASING)])
    ->group(function () {
        Route::get('/', [HomeController::class, '__invoke'])
            ->name('admin-purchasing.index');

        Route::resource('/purchase-orders', PurchasingOrderController::class)
            ->names('admin-purchasing.purchase-orders');


        // list pengajuan pembelian
        // Route::get('/pengajuan-pembelian', [PengajuanPembelianController::class, 'index'])
        //     ->name('admin-purchasing.pengajuan-pembelian.index');
        // Route::get('/pengajuan-pembelian/{pengajuanPembelian}', [PengajuanPembelianController::class, 'show'])
        //     ->name('admin-purchasing.pengajuan-pembelian.show');
    
        // Pengajuan PO
        // Route::get('/purchasing-orders', [PurchasingOrderController::class, 'index'])
        //     ->name('admin-purchasing.purchasing-orders.index');
        // Route::get('/purchasing-orders/create/{pengajuanPembelian}', [PurchasingOrderController::class, 'create'])
        //     ->name('admin-purchasing.purchasing-orders.create');
        // Route::post('/purchasing-orders/create/{pengajuanPembelian}', [PurchasingOrderController::class, 'store'])
        //     ->name('admin-purchasing.purchasing-orders.store');
    });