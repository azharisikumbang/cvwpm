<?php

use App\Models\Role;

Route::prefix('admin-purchasing')
    ->middleware(['auth', sprintf("role:%s", Role::ID_ADMIN_PURCHASING)])
    ->group(function () {
        Route::get('/', function () {
            echo "admin-purchasing";
        });
    });