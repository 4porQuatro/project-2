<?php

use Packages\Voucher\app\Http\Controllers\cms\VoucherablesController;
use Packages\Voucher\app\Http\Controllers\cms\VouchersController;

Route::middleware(['web', 'auth.cms', 'locale.cms'])->prefix('cms')->name('cms.')->group(function() {
    //Voucher
    Route::get('vouchers', [VouchersController::class, 'index'])->name('vouchers.index');
    Route::get('vouchers/create', [VouchersController::class, 'create'])->name('vouchers.create');
    Route::post('vouchers', [VouchersController::class, 'store'])->name('vouchers.store');
    Route::get('vouchers/{voucher}/edit', [VouchersController::class, 'edit'])->name('vouchers.edit');
    Route::patch('vouchers/{voucher}', [VouchersController::class, 'update'])->name('vouchers.update');
    Route::delete('vouchers/{voucher}/destroy', [VouchersController::class, 'destroy'])->name('vouchers.delete');

    //Voucherables
    Route::get('voucheralbes/{voucher}', [VoucherablesController::class, 'index'])->name('voucherables.index');


});
