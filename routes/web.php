<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'blog'], function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/{year}/{month}', [BlogController::class, 'byMonth'])->name('blog.byMonth');
    Route::get('/flush', [BlogController::class, 'flushCache'])->name('blog.flushCache');
});

Route::group(['prefix' => 'news'], function () {
    Route::get('/', [NewsController::class, 'index'])->name('news.index');
    Route::get('/{year}/{month}', [NewsController::class, 'byMonth'])->name('news.byMonth');
    Route::get('/flush', [NewsController::class, 'flushCache'])->name('news.flushCache');
});
