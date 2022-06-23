<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web','locale.front'])->prefix('countries')->group(function() {
    Route::get('/zones', [\Packages\Country\App\Http\Controllers\ZonesController::class, 'get'])->name('zones.get');
    Route::get('/regions/{country}', [\Packages\Country\App\Http\Controllers\RegionsController::class, 'getByCountry'])->name('regions.get_by_country');
    Route::patch('user_tax/set', [\Packages\Country\App\Http\Controllers\TaxesController::class, 'update'])->name('user.taxes.update');
    Route::patch('user_rate/set', [\Packages\Country\App\Http\Controllers\RatesController::class, 'update'])->name('user.rates.update');
    Route::patch('user_country/set', [\Packages\Country\App\Http\Controllers\UserCountryController::class, 'update'])->name('user.country.update');

});
