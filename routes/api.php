<?php

use App\Http\Controllers\Api\TlBpkController;
use App\Http\Controllers\Api\TlJabarController;
use App\Http\Controllers\Api\TlKabController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tl/bpk', [TlBpkController::class, 'index']);
    Route::get('/tl/jabar', [TlJabarController::class, 'index']);
    Route::get('/tl/kab', [TlKabController::class, 'index']);
});
