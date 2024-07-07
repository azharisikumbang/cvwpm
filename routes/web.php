<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\HomeController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

// public
Route::get('/', [HomeController::class, '__invoke'])->name('homepage');
Route::get('/login', [AuthenticationController::class, 'login'])->name('authentication.login');
Route::post('/login', [AuthenticationController::class, 'authenticate'])->name('authentication.authenticate');
Route::post('/logout', [AuthenticationController::class, 'logout'])->name('authentication.logout');


// admin-web
Route::prefix('admin-web')
    ->middleware(['auth', sprintf("role:%s", Role::ID_ADMIN_WEB)])
    ->group(function () {
        Route::get('/', function () {
            echo "admin-web";
        });
    });

// admin-stock
Route::prefix('admin-stock')
    ->middleware(['auth', sprintf("role:%s", Role::ID_ADMIN_STOCK)])
    ->group(function () {
        Route::get('/', function () {
            echo "admin-stock";
        });
    });

// admin-purchasing
Route::prefix('admin-purchasing')
    ->middleware(['auth', sprintf("role:%s", Role::ID_ADMIN_PURCHASING)])
    ->group(function () {
        Route::get('/', function () {
            echo "admin-purchasing";
        });
    });

// sales
Route::prefix('sales')
    ->middleware(['auth', sprintf("role:%s", Role::ID_SALES)])
    ->group(function () {
        Route::get('/', function () {
            echo "sales";
        });
    });

// manager
Route::prefix('manager')
    ->middleware(['auth', sprintf("role:%s", Role::ID_MANAGER)])
    ->group(function () {
        Route::get('/', function () {
            echo "manager";
        });
    });