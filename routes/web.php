<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('filament.admin.pages.dashboard');
    }

    return redirect()->route('filament.admin.auth.login');
});
