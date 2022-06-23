<?php


Route::middleware(['web', 'locale.front'])->prefix('voucher')->group(function() {
    Route::post('verify', [\Packages\Voucher\app\Http\Controllers\VouchersController::class, 'store'])->name('voucher.post');
    Route::get('discount', [\Packages\Voucher\app\Http\Controllers\VouchersController::class, 'get'])->name('voucher.get');
});
