<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return view('app'); // 👈 loads Vue SPA
})->where('any', '.*');
