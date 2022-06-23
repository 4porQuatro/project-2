<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Packages\Store\app\Http\Controllers\api\AttributeFamilyController;
use Packages\Store\app\Http\Controllers\api\AttributeOptionsController;
use Packages\Store\app\Http\Controllers\api\AttributesController;
use Packages\Store\app\Http\Controllers\api\ProductsController;


Route::middleware(['locale.cms','auth:sanctum'])->prefix('api')->group(function(){

    Route::prefix('v1')->group(function(){
        //Attributes
        Route::post('attribute', [AttributesController::class, 'store'])->name('api.attribute.store');
        Route::put('attribute/{attribute}', [AttributesController::class, 'update'])->name('api.attribute.update');
        Route::delete('attribute/{attribute}',  [AttributesController::class, 'destroy'])->name('api.attribute.delete');


        //Attribute Values
        Route::post('attribute_option', [AttributeOptionsController::class, 'store'])->name('api.attribute_option.store');
        Route::put('attribute_option/{attribute_option}', [AttributeOptionsController::class, 'update'])->name('api.attribute_option.update');
        Route::delete('attribute_option/{attribute_option}',  [AttributeOptionsController::class, 'destroy'])->name('api.attribute_option.delete');

        //Attribute Families
        Route::post('attribute_family', [AttributeFamilyController::class, 'store'])->name('api.attribute_family.store');
        Route::put('attribute_family/{attribute_family}', [AttributeFamilyController::class, 'update'])->name('api.attribute_family.update');
        Route::delete('attribute_family/{attribute_family}',  [AttributeFamilyController::class, 'destroy'])->name('api.attribute_family.delete');

        //Products
        Route::post('product', [ProductsController::class, 'store'])->name('api.products.store');
        Route::put('product/{product}', [ProductsController::class, 'update'])->name('api.products.update');

        Route::get('product', [ProductsController::class, 'index'])->name('api.products.get');
    });


});
