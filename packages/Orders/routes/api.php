<?php

Route::middleware(['locale.cms','auth:sanctum'])->prefix('api')->group(function(){
    Route::prefix('v1')->group(function(){
        Route::get('orders', [\Packages\Orders\App\Http\Controllers\Api\OrdersController::class, 'index'])->name('api.order.get');
        Route::put('orders/{id}', [\Packages\Orders\App\Http\Controllers\Api\OrdersController::class, 'update'])->name('api.order.update');
    });


});

