<?php
use Illuminate\Support\Facades\Route;
use Packages\Orders\App\Http\Controllers\cms\CheckoutController;
use Packages\Orders\App\Http\Controllers\cms\InvoiceProviderController;
use Packages\Orders\App\Http\Controllers\cms\OrdersController;

Route::middleware(['web', 'auth.cms', 'locale.cms'])->prefix('cms')->name('cms.')->group(function(){
    Route::get('order', [OrdersController::class, 'index'])->name('order.index');
    Route::get('order/create', [OrdersController::class, 'create'])->name('order.create');
    Route::get('order/{order}', [OrdersController::class, 'show'])->name('order.show');
    Route::get('order/{order}/edit', [OrdersController::class, 'edit'])->name('order.edit');
    Route::post('order', [OrdersController::class, 'store'])->name('order.store');
    Route::patch('order/{order}',[OrdersController::class, 'update'])->name('order.update');
    Route::patch('order/{order}/updateStatus', [OrdersController::class, 'updateStatus'])->name('order.update.status');

    //CHECKOUT
    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('checkout/create', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('checkout/{checkout}/edit', [CheckoutController::class, 'edit'])->name('checkout.edit');
    Route::patch('checkout/{checkout}', [CheckoutController::class, 'update'])->name('checkout.update');
    Route::post('checkout/generate_shipping_form/{checkout}', [CheckoutController::class, 'generateShippingForm'])->name('checkout.generate_shipping_form');


    //INVOICE PROVIDERS
    Route::get('provider/invoice', [InvoiceProviderController::class, 'index'])->name('provider.invoice.index');
    Route::get('provider/invoice/create', [InvoiceProviderController::class, 'create'])->name('provider.invoice.create');
    Route::post('provider/invoice', [InvoiceProviderController::class, 'store'])->name('provider.invoice.store');

});
