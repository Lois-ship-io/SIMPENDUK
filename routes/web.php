<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

use App\Http\Controllers\WilayahController;
use App\Http\Controllers\KematianController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PendudukController;

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::delete('penduduk/bulk', [PendudukController::class, 'bulkDestroy'])->name('penduduk.bulkDestroy');
    Route::resource('penduduk', PendudukController::class);
    
    // Admin & SuperAdmin Only
    Route::middleware('can:manage-wilayah')->group(function () {
        Route::delete('wilayah/bulk', [WilayahController::class, 'bulkDestroy'])->name('wilayah.bulkDestroy');
        Route::resource('wilayah', WilayahController::class);
    });

    Route::delete('kematian/bulk', [KematianController::class, 'bulkDestroy'])->name('kematian.bulkDestroy');
    Route::resource('kematian', KematianController::class);

    // SuperAdmin Only
    Route::middleware('can:manage-users')->group(function () {
        Route::delete('pengguna/bulk', [UserController::class, 'bulkDestroy'])->name('pengguna.bulkDestroy');
        Route::resource('pengguna', UserController::class);
    });
});
