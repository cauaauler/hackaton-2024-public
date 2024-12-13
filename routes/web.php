<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceOrderController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RankingController;
Route::view('/', 'welcome');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    Route::get('ranking', [RankingController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('ranking');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::controller(ServiceOrderController::class)
    ->middleware('auth')
    ->as('serviceOrder.')
    ->group(function () {
        Route::get('/serviceOrder/create', 'create')->name('create');
        Route::post('/serviceOrder/store', 'store')->name('store');
        Route::get('/serviceOrder/{id}/verificar', 'verificar')->name('verificar');
        Route::get('/serviceOrder/{id}/coletar', 'coletar')->name('coletar');
    });

Route::controller(MapController::class)
    ->as('map.')
    ->group(function () {
        Route::get('/map/store/coordinates/{latitude}/{longitude}', 'store')->name('store');
});
require __DIR__.'/auth.php';
