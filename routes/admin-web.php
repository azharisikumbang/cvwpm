<?php

use App\Http\Controllers\AdminWeb\HomeController;
use App\Http\Controllers\AdminWeb\UserController;
use App\Models\Role;

// admin-web
Route::prefix('admin-web')
    ->middleware(['auth', sprintf("role:%s", Role::ID_ADMIN_WEB)])
    ->group(function () {
        Route::get('/', [HomeController::class, '__invoke'])->name('admin-web.index');

        // user management
        Route::get('/users', [UserController::class, 'index'])->name('admin-web.users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('admin-web.users.create');
        Route::post('/users', [UserController::class, 'store'])->name('admin-web.users.store');
    });