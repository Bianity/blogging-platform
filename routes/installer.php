<?php

use App\Http\Controllers\InstallController;
use Illuminate\Support\Facades\Route;

Route::name('installer.')->prefix('installer')->group(function () {
    Route::get('/', [InstallController::class, 'index'])->name('index');
    Route::get('/license', [InstallController::class, 'license'])->name('license');
    Route::post('/license', [InstallController::class, 'storeLicense'])->name('license.store');
    Route::get('/requirements', [InstallController::class, 'requirements'])->name('requirements');
    Route::get('/upgrade', [InstallController::class, 'upgrade'])->name('upgrade');
    Route::post('/upgrade', [InstallController::class, 'upgradeApp'])->name('upgrade.store');
    Route::get('/database', [InstallController::class, 'database'])->name('database');
    Route::post('/database', [InstallController::class, 'storeDatabase'])->name('database.store');
    Route::get('/account', [InstallController::class, 'account'])->name('account');
    Route::post('/account', [InstallController::class, 'storeAccount'])->name('account.store');
    Route::get('/complete', [InstallController::class, 'complete'])->name('complete');
})->middleware('installer');
