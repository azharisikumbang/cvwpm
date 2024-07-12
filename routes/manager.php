<?php

use App\Models\Role;

Route::prefix('manager')
    ->middleware(['auth', sprintf("role:%s", Role::ID_MANAGER)])
    ->group(function () {
        Route::get('/', function () {
            echo "manager";
        });
    });