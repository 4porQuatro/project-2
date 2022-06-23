<?php
use Illuminate\Support\Facades\Route;
use Packages\shipping_methods\App\Http\Controllers\ShippmentMethodsController;


Route::middleware(['web', 'locale.front'])->prefix('store')->group(function() {
    Route::get('api/shippment_methods/get', [ShippmentMethodsController::class, 'get'])->name('api.shipping_methods.get');
});



