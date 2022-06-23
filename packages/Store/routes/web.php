<?php

use Illuminate\Support\Facades\Route;
use Packages\Store\app\Http\Controllers\CartController;
use Packages\Store\app\Http\Controllers\ProductsController;
use Packages\Store\app\Http\Controllers\FacebookCatalogExcelController;

Route::middleware(['web', 'locale.front'])->prefix('store')->group(function() {

    //Cart Routes
    Route::get('cart/{type?}', [CartController::class, 'index'])->name('store.cart.index');
    Route::post('cart/{type?}', [CartController::class, 'store'])->name('store.cart.store');
    Route::patch('cart/{type?}', [CartController::class, 'patch'])->name('store.cart.patch');
    Route::delete('cart/remove/{product_id}/{type?}', [CartController::class, 'remove'])->name('store.cart.remove');
    Route::get('share_cart/{uuid}', [CartController::class, 'share'])->name('store.cart.share');

    //Product Routes
    Route::get('products/{id}', [ProductsController::class, 'show'])->name('store.products.show');

    //AJAX_REQUEST
    Route::get('api/products', [ProductsController::class, 'get'])->name('store.products.get');

});

Route::get('facebook/catalog/download.csv', [FacebookCatalogExcelController::class, 'download']);
