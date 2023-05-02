<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PremiumController;
use App\Http\Controllers\Api\MoneyBackController;
use App\Http\Controllers\Api\WholelifeController;
use App\Http\Controllers\Api\DhanBristiController;


Route::prefix('calculator')->group(function () {

    Route::prefix('moneyback')->group(function () {
        Route::get('create', [MoneyBackController::class, 'create']);
        Route::post('store', [MoneyBackController::class, 'store']);
    });

    Route::prefix('dhanbristi')->group(function () {
        Route::get('create', [DhanBristiController::class, 'create']);
        Route::post('store', [DhanBristiController::class, 'store']);
    });

    Route::prefix('premiumrate')->group(function () {
        Route::post('store', [PremiumController::class, 'store']);
        Route::post('child',[PremiumController::class, 'child']);
        Route::post('childjeevanvidya',[PremiumController::class, 'childjeevanvidya']);
        Route::post('wholelife',[WholelifeController::class, 'store']);
    });
});
