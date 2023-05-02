<?php

use App\Http\Controllers\CompareController;
use App\Http\Controllers\CouplePlanCalcController;
use App\Http\Controllers\LifeCalculatorController;
use App\Http\Controllers\MoneyBackCalcController;
use Illuminate\Support\Facades\Route;

Route::middleware(['access:life-calculation', 'cors', 'api'])->prefix('admin')->group(function () {
        Route::get('money-back', [MoneyBackCalcController::class, 'showCalculationForm'])
            ->name('calculator.moneyBack');
        Route::post('money-back', [MoneyBackCalcController::class, 'calculate'])
            ->name('calculator.moneyBack.calculate');

        Route::get('couple-plan', [CouplePlanCalcController::class, 'showCalculationForm'])
            ->name('calculator.couplePlan');
        Route::post('couple-plan', [CouplePlanCalcController::class, 'calculate'])
            ->name('calculator.couplePlan.calculate');

        Route::get('life', [LifeCalculatorController::class, 'index'])->name('calculator.life.index');
        Route::post('life', [LifeCalculatorController::class, 'calculate'])->name('calculator.life.calculate');

        Route::get('life/validate', [LifeCalculatorController::class, 'validateData'])->name('calculator.life.validate');

        Route::get('compare', [CompareController::class, 'showCompareForm'])->name('admin.policy.form');
        Route::get('compare/add', [CompareController::class, 'addRow'])->name('admin.policy.add');
        Route::post('compare', [CompareController::class, 'compare'])->name('admin.policy.compare');
        Route::get('compare/pdf', [CompareController::class, 'generatePdf'])->name('admin.policy.compare.pdf');
    });
