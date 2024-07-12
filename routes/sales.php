<?php

use App\Models\Role;

Route::prefix('sales')
    ->middleware(['auth', sprintf("role:%s", Role::ID_SALES)])
    ->group(function () {
        Route::get('/', function () {
            echo "sales";
        });
    });