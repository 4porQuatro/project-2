<?php

use Illuminate\Support\Facades\Route;
use Packages\shipping_methods\App\Http\Controllers\cms\ShippingZonesController;
use Packages\shipping_methods\App\Http\Controllers\cms\ShippingMethodsController;
use Packages\shipping_methods\App\Http\Controllers\cms\ShippingPricesController;

Route::middleware(['web', 'auth.cms', 'locale.cms'])->prefix('cms')->name('cms.')->group(function(){
    Route::get('shipping_methods', [ShippingMethodsController::class, 'index'])->name('shipping_methods.index');
    Route::get('shipping_methods/create', [ShippingMethodsController::class, 'create'])->name('shipping_methods.create');
    Route::get('shipping_methods/{shipping_method}', [ShippingMethodsController::class, 'edit'])->name('shipping_methods.edit');
    Route::post('shipping_methods', [ShippingMethodsController::class, 'store'])->name('shipping_methods.store');
    Route::patch('shipping_methods/{shipping_method}', [ShippingMethodsController::class, 'update'])->name('shipping_methods.update');

    //SHIPPING ZONES
    Route::get('shipping_methods/zones/{shipping_method}', [ShippingZonesController::class, 'index'])->name('shipping_methods.zones.index');
    Route::get('shipping_methdos/zones/{shipping_method}/edit', [ShippingZonesController::class, 'edit'])->name('shipping_methods.zones.edit');

    Route::get('shipping_methods/{shipping_method}/price_definition', [ShippingPricesController::class, 'index'])->name('shipping_prices.index');
    Route::get('shipping_methods/{shipping_method}/price_definition/create', [ShippingPricesController::class, 'create'])->name('shipping_prices.create');
    Route::post('shipping_methods/{shipping_method}/price_definition', [ShippingPricesController::class, 'store'])->name('shipping_prices.store');
    Route::get('shipping_methods/{shipping_method}/price_definition/{shipping_price}', [ShippingPricesController::class, 'edit'])->name('shipping_prices.edit');
    Route::patch('shipping_methods/{shipping_method}/price_definition/{shipping_price}', [ShippingPricesController::class, 'update'])->name('shipping_prices.update');




});
