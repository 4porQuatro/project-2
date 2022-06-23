<?php

use Packages\Orders\App\Http\Controllers\CheckoutController;

Route::middleware(['web', 'locale.cms', 'locale.front'])->group(function() {
    Route::get('/i_checkout/{checkout}',  [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/i_checkout/{checkout}', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('i_payment/{order_uuid}', [\Packages\Orders\App\Http\Controllers\PaymentController::class, 'show'])->name('payment.show');

    Route::get('i_payment_success', [\Packages\Orders\App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
});

Route::middleware(['web', 'auth'])->group(function(){
    Route::get('i_orders/get', [\Packages\Orders\App\Http\Controllers\OrdersController::class, 'get'])->name('front.orders.get');
});

Route::post('payload_payment/check/{provider}', [\Packages\Orders\App\Http\Controllers\PaymentPayloadController::class, 'store']);
Route::get('payload_payment/check/{provider}', [\Packages\Orders\App\Http\Controllers\PaymentPayloadController::class, 'get']);

