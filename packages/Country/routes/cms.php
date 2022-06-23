<?php

use Illuminate\Support\Facades\Route;
use Packages\Country\App\Http\Controllers\cms\CountriesController;
use Packages\Country\App\Http\Controllers\cms\CurrenciesController;
use Packages\Country\App\Http\Controllers\cms\ZoneablesController;
use Packages\Country\App\Http\Controllers\cms\ZonesController;

Route::middleware(['web', 'auth.cms', 'locale.cms'])->prefix('cms')->name('cms.')->group(function(){
    //COUNTRIES
    Route::get('country', [CountriesController::class, 'index'])->name('country.index');
    Route::get('country/create', [CountriesController::class, 'create'])->name('country.create');
    Route::get('country/{country}', [CountriesController::class, 'show'])->name('country.show');
    Route::get('country/{country}/edit', [CountriesController::class, 'edit'])->name('country.edit');
    Route::post('country', [CountriesController::class, 'store'])->name('country.store');
    Route::patch('country/{country}',[CountriesController::class, 'update'])->name('country.update');

    //REGIONS
    Route::get('country/{country}/region', [\Packages\Country\App\Http\Controllers\cms\RegionsController::class, 'index'])->name('country.region.index');

    //Zones
    Route::get('zone', [ZonesController::class, 'index'])->name('zones.index');
    Route::get('zone/create', [ZonesController::class, 'create'])->name('zones.create');
    Route::get('zone/{zone}/edit', [ZonesController::class, 'edit'])->name('zones.edit');
    Route::post('zone', [ZonesController::class, 'store'])->name('zones.store');
    Route::patch('zone', [ZonesController::class, 'update'])->name('zones.update');

    //Zoneableas
    Route::get('zoneables/{zone}', [ZoneablesController::class, 'index'])->name('zoneables.index');
    Route::get('zoneables/{zone}/edit', [ZoneablesController::class, 'edit'])->name('zoneables.edit');

    //Currencies
    Route::get('currency', [CurrenciesController::class, 'index'])->name('currency.index');

});
