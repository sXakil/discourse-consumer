<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'blog'], function () {
    Route::get('/', [ApiController::class, 'index'])->defaults('type', 'blog');
    Route::get('/{year}/{month}', [ApiController::class, 'byMonth'])->defaults('type', 'blog');
    Route::get('/flush', [ApiController::class, 'flushCache'])->defaults('type', 'blog');
});

Route::group(['prefix' => 'news'], function () {
    Route::get('/', [ApiController::class, 'index'])->defaults('type', 'news');
    Route::get('/{year}/{month}', [ApiController::class, 'byMonth'])->defaults('type', 'news');
    Route::get('/flush', [ApiController::class, 'flushCache'])->defaults('type', 'news');
});
