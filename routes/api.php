<?php

use App\Http\Controllers\Api\TindakLanjutController;

Route::prefix('tl')->group(function () {

    Route::get('bpk', [TindakLanjutController::class, 'bpk']);
    Route::get('jabar', [TindakLanjutController::class, 'jabar']);
    Route::get('kab', [TindakLanjutController::class, 'kab']);
});
