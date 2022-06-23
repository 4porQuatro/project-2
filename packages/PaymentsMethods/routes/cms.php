<?php

use Illuminate\Support\Facades\Route;
use Packages\PaymentsMethods\App\Http\Controllers\cms\PaymentMethodsController;
use Packages\PaymentsMethods\App\Http\Controllers\cms\PaymentProvidersController;


Route::middleware(['web', 'auth.cms', 'locale.cms'])->prefix('cms')->name('cms.')->group(function(){
    Route::get('providers_payments', [PaymentProvidersController::class, 'index'])->name('payment_methods.providers.index');
    Route::get('providers_payments/create', [PaymentProvidersController::class, 'create'])->name('payment_methods.providers.create');
    Route::post('providers_payments', [PaymentProvidersController::class, 'store'])->name('payment_methods.providers.store');

    Route::get('payment_methods', [PaymentMethodsController::class, 'index'])->name('payment_methods.index');
    Route::get('payment_methods/create', [PaymentMethodsController::class, 'create'])->name('payment_methods.create');
    Route::post('payment_methods', [PaymentMethodsController::class, 'store'])->name('payment_methods.store');
    Route::get('payment_methods/{payment_method}/edit', [PaymentMethodsController::class, 'edit'])->name('payment_methods.edit');
    Route::patch('payment_methods/{payment_method}', [PaymentMethodsController::class, 'update'])->name('payment_methods.update');

});
