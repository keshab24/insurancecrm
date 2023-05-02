<?php

/*
|--------------------------------------------------------------------------
| Frontend Table Routes
|--------------------------------------------------------------------------
*/

//HomePage
Route::get('lang/set', [App\Http\Controllers\LocalizationController::class, 'languageChange'])->name('setLanguage');

Route::get('/', [App\Http\Controllers\FrontendController::class, 'home'])->name('frontend.home');
Route::get('/calculator', [App\Http\Controllers\FrontendController::class, 'calculatorScreen'])->name('home.calculator');
//age
Route::post('/benefit', [App\Http\Controllers\FrontendController::class, 'benefits'])->name('home.benefits');

Route::post('/compare', [App\Http\Controllers\FrontendController::class, 'compareScreen'])->name('home.compare');
Route::get('/about', [App\Http\Controllers\FrontendController::class, 'about'])->name('frontend.about');

Route::get('/confirmation/{age}/{term}/{sum}/{mop}/{product}',[App\Http\Controllers\FrontendController::class, 'confirm'])->name('front.confirmation');

Route::post('/confirm',[App\Http\Controllers\FrontendController::class, 'confirmation'])->name('front.confirm');

Route::get('get/cat/featureList', [App\Http\Controllers\FrontendController::class, 'findcatFeature'])->name('admin.get.category.feature');

Route::post('/plan/selected', [App\Http\Controllers\PlanselectedController::class, 'store'])->name('plan.selected');