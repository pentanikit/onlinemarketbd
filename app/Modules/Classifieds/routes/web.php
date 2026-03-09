<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Classifieds\Http\Controllers\AdController;
use App\Modules\Classifieds\Http\Controllers\CategoryController;
use App\Modules\Classifieds\Http\Controllers\DashboardController;
use App\Modules\Classifieds\Http\Middleware\ClassifiedAuth;

Route::middleware(['web'])->prefix(config('classifieds.route_prefix', 'classifieds'))
    ->name('classifieds.')
    ->group(function () {
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

        Route::get('/post/ads', [AdController::class, 'create'])->name('ads.create');
        Route::post('/post/ads', [AdController::class, 'store'])->name('ads.store');

        Route::get('/ad/{ad:slug}', [AdController::class, 'show'])->name('ads.show');

        Route::middleware([ClassifiedAuth::class])->group(function () {
            Route::get('/my-ads', [DashboardController::class, 'myAds'])->name('ads.my');
        });
    });