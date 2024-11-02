<?php

use App\Services\PWAManifestService;
use Illuminate\Support\Facades\Route;

// PWA
Route::get('/manifest.json', function () {
    $output = (new PWAManifestService())->generate();

    return response()->json($output);
})->name('pwa.manifest');
