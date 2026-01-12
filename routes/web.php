<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::domain('{type}.laravel.test')->group(function () {
    Route::get('/', [ApiController::class, 'index']);
    Route::get('/flush', [ApiController::class, 'flushCache']);
});

Route::get('*', function () {
    return response('Not Found', 404);
});
