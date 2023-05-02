<?php

/*
|--------------------------------------------------------------------------
| Travel Medical Insurance Routes
|--------------------------------------------------------------------------
*/


Route::middleware(['access:travel-calculation', 'agent:NonLife', 'cors', 'api'])->prefix('travel/calculator')->name('travel.calculator.')->group(function () {
    Route::resource('insurance', \App\Http\Controllers\TravelMedicalInsuranceController::class);
    Route::post('insurance/plans', [App\Http\Controllers\TravelMedicalInsuranceController::class, 'getPlans'])->name('medical.insurance.plans');
    Route::post('insurance/package', [App\Http\Controllers\TravelMedicalInsuranceController::class, 'getPackages'])->name('medical.insurance.package');
    Route::post('insurance/premium', [App\Http\Controllers\TravelMedicalInsuranceController::class, 'getPremium'])->name('medical.insurance.premium');
});
