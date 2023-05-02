<?php

/*
|--------------------------------------------------------------------------
| Rate Table Routes
|--------------------------------------------------------------------------
*/

//Admin
Route::group(['prefix' =>'admin', 'namespace' => 'auth'], function(){

    Route::get('/rate-table/endowment-rate', [App\Http\Controllers\RateTableController::class, 'endowmentRate'])->name('endowment.rate.index');
    Route::get('/rate-table/endowment-rate/all', [App\Http\Controllers\RateTableController::class, 'allEndowmentRate'])->name('all.endowment.rate');
    Route::post('/update-rate-table/endowment-rate', [App\Http\Controllers\RateTableController::class, 'updateRateEndowment'])->name('update.endowment.rate');
    Route::get('/rate-table/endowment-rates/export', [App\Http\Controllers\RateTableController::class, 'export'])->name('endowment.rates.export');
    Route::get('/rate-table/company-rates/export', [App\Http\Controllers\RateTableController::class, 'exportData'])->name('company.rates.export');
    Route::post('/rate-table/endowment-rates/bulk-upload', [App\Http\Controllers\RateTableController::class, 'importEndowment'])->name('endowment.rates.import');


    Route::get('/rate-table/term-rider-rate', [App\Http\Controllers\RateTableController::class, 'termrider'])->name('endowment.rate.term.index');
    Route::post('/rate-table/term-rates/bulk-upload', [App\Http\Controllers\RateTableController::class, 'importterm'])->name('term.rates.import');
    Route::post('/update-rate-table/term-rider-rate', [App\Http\Controllers\RateTableController::class, 'updateRateTerm'])->name('update.endowment.term');
    Route::get('/term-rate-table/company-rates/export', [App\Http\Controllers\RateTableController::class, 'exporttermData'])->name('company.term.rates.export');

    Route::get('/rate-table/adb-rate', [App\Http\Controllers\RateTableController::class, 'wholeadb'])->name('endowment.rate.adb.index');
    Route::post('/rate-table/adb-rates/bulk-upload', [App\Http\Controllers\RateTableController::class, 'importadb'])->name('adb.rates.import');
    Route::post('/update-rate-table/adb-rate', [App\Http\Controllers\RateTableController::class, 'wholeRateTerm'])->name('update.endowment.adb');
    Route::get('/adb-rate-table/company-rates/export', [App\Http\Controllers\RateTableController::class, 'exportadbData'])->name('company.adb.rates.export');


    Route::get('/rate-table/pwb-rate', [App\Http\Controllers\RateTableController::class, 'pwbrate'])->name('endowment.rate.pwb.index');
    Route::post('/rate-table/pwb-rates/bulk-upload', [App\Http\Controllers\RateTableController::class, 'importpwb'])->name('pwb.rates.import');
    Route::post('/update-rate-table/pwb-rate', [App\Http\Controllers\RateTableController::class, 'pwbRateTerm'])->name('update.endowment.pwb');
    Route::get('/pwb-rate-table/company-rates/export', [App\Http\Controllers\RateTableController::class, 'exportpwbData'])->name('company.pwb.rates.export');


    Route::get('/rate-table/feature-rate', [App\Http\Controllers\FeatureRateTableController::class, 'featurerate'])->name('rate.feature.index');
    Route::post('/rate-table/feature-rates/bulk-upload', [App\Http\Controllers\FeatureRateTableController::class, 'importfeature'])->name('feature.rates.import');
    Route::post('/update-rate-table/feature-rate', [App\Http\Controllers\FeatureRateTableController::class, 'featureRate'])->name('update.endowment.feature');
    Route::get('/feature-rate-table/company-rates/export', [App\Http\Controllers\FeatureRateTableController::class, 'exportfeatureData'])->name('company.feature.rates.export');
    Route::post('/update-rate-table/feature-rate', [App\Http\Controllers\FeatureRateTableController::class, 'updatefeatureRateEndowment'])->name('update.feature.rate');
});
