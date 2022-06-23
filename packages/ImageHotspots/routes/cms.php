<?php
use Illuminate\Support\Facades\Route;
use Packages\ImageHotspots\App\Http\Controllers\cms\ImageHotpostController;

Route::middleware(['web', 'auth.cms', 'locale.cms'])->prefix('cms')->name('cms.')->group(function(){

    Route::get('/image-hotspots/{hotspot_image}', [ImageHotpostController::class, 'index'])->name('image-hotspots.index');
    Route::get('/image-hotspots/{hotspot_image}/create', [ImageHotpostController::class, 'create'])->name('image-hotspots.create');
    Route::post('/image-hotspots/{hotspot_image}', [ImageHotpostController::class, 'store'])->name('image-hotspots.store');
    Route::get('/image-hotspots/{hotspot_image}/{hotspot}/edit', [ImageHotpostController::class, 'edit'])->name('image-hotspots.edit');
    Route::patch('/image-hotspots/{hotspot}', [ImageHotpostController::class, 'update'])->name('image-hotspots.update');
    Route::delete('/image-hotspots/{hotspot}', [ImageHotpostController::class, 'destroy'])->name('image-hotspots.delete');
});
