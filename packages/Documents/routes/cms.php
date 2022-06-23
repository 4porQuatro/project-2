<?php

use Illuminate\Support\Facades\Route;
use Packages\Documents\App\Http\Controllers\cms\DocumentsController;

Route::middleware(['web', 'auth.cms', 'locale.cms'])->prefix('cms')->name('cms.')->group(function(){

    //Documents
    Route::get('documents', [DocumentsController::class, 'index'])->name('documents.index');
    Route::get('documents/create', [DocumentsController::class, 'create'])->name('documents.create');
    Route::post('documents', [DocumentsController::class, 'store'])->name('documents.store');
    Route::get('documents/{document}', [DocumentsController::class, 'edit'])->name('documents.edit');
    Route::patch('documents/{document}', [DocumentsController::class, 'update'])->name('documents.update');
});
