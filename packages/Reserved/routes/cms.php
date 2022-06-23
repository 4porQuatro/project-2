<?php
use Illuminate\Support\Facades\Route;
use Packages\Reserved\App\Http\Controllers\cms\ReservedAreaController;
use Packages\Reserved\App\Http\Controllers\cms\CustomersController;


Route::middleware(['web', 'auth.cms', 'locale.cms'])->prefix('cms')->name('cms.')->group(function(){
  Route::get('reserved_area', [ReservedAreaController::class, 'index'])->name('reserved_area.index');
  Route::get('reserved_area/create', [ReservedAreaController::class, 'create'])->name('reserved_area.create');
  Route::get('reserved_area/{reserved_area}', [ReservedAreaController::class, 'show'])->name('reserved_area.show');
  Route::get('reserved_area/{reserved_area}/edit', [ReservedAreaController::class, 'edit'])->name('reserved_area.edit');
  Route::post('reserved_area', [ReservedAreaController::class, 'store'])->name('reserved_area.store');
  Route::patch('reserved_area/{reserved_area}',[ReservedAreaController::class, 'update'])->name('reserved_area.update');

  Route::get('customers/{customer}', [CustomersController::class, 'show'])->name('customers.show');
  Route::get('customers/{customer}/{identifier}/download', [CustomersController::class, 'download'])->name('customers.data.download');
});
