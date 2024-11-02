<?php

use App\Http\Controllers\Setup\AccountController;
use App\Http\Controllers\Setup\DatabaseController;
use App\Http\Controllers\Setup\InitWizardController;
use App\Http\Controllers\Setup\RequirementsController;
use Illuminate\Support\Facades\Route;

Route::prefix('setup')->group(function () {
    Route::get('start', [InitWizardController::class, 'welcome'])->name('setup.welcome');
    Route::get('requirements', [RequirementsController::class, 'index'])->name('setup.requirements');
    Route::get('database', [DatabaseController::class, 'index'])->name('setup.database');
    Route::post('database', [DatabaseController::class, 'store'])->name('setup.save-database');
    Route::get('account', [AccountController::class, 'index'])->name('setup.account');
    Route::post('account', [AccountController::class, 'store'])->name('setup.save-account');
    Route::get('complete', [InitWizardController::class, 'complete'])->name('setup.complete');
});
