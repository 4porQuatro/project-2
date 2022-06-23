<?php

use Illuminate\Support\Facades\Route;
use Packages\Store\app\Http\Controllers\cms\AttributesController;
use Packages\Store\app\Http\Controllers\cms\AttributeOptionsController;
use Packages\Store\app\Http\Controllers\cms\AttributeFamiliesController;
use Packages\Store\app\Http\Controllers\cms\ProductsController;
use Packages\Store\app\Http\Controllers\cms\ProductVariantsController;

Route::middleware(['web', 'auth.cms', 'locale.cms'])->prefix('cms')->name('cms.')->group(function(){

    //Products
    Route::get('products', [ProductsController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductsController::class, 'create'])->name('products.create');
    Route::post('products', [ProductsController::class, 'store'])->name('products.store');
    Route::get('products/{product}', [ProductsController::class, 'edit'])->name('products.edit');
    Route::patch('products/{product}', [ProductsController::class, 'update'])->name('products.update');

    //Product Variants
    Route::get('product-variants/create/{product}', [ProductVariantsController::class, 'create'])->name('product-variants.create');
    Route::post('product-variants/{product}', [ProductVariantsController::class, 'store'])->name('product-variants.store');
    Route::get('product-variants/{product}/{variant}', [ProductVariantsController::class, 'edit'])->name('product-variants.edit');
    Route::patch('product-variants/{product}/{variant}', [ProductVariantsController::class, 'update'])->name('product-variants.update');

    //Attributes
    Route::get('attributes', [AttributesController::class, 'index'])->name('attributes.index');
    Route::get('attributes/create', [AttributesController::class, 'create'])->name('attributes.create');
    Route::post('attributes', [AttributesController::class, 'store'])->name('attributes.store');
    Route::get('attributes/{attribute}', [AttributesController::class, 'edit'])->name('attributes.edit');
    Route::patch('attributes/{attribute}', [AttributesController::class, 'update'])->name('attributes.update');

    //Attribute Options
    Route::get('attribute-options/{attribute}', [AttributeOptionsController::class, 'index'])->name('attribute-options.index');
    Route::get('attribute-options/create/{attribute}', [AttributeOptionsController::class, 'create'])->name('attribute-options.create');
    Route::post('attribute-options/{attribute}', [AttributeOptionsController::class, 'store'])->name('attribute-options.store');
    Route::get('attribute-options/{attribute}/{attribute_option}', [AttributeOptionsController::class, 'edit'])->name('attribute-options.edit');
    Route::patch('attribute-options/{attribute}/{attribute_option}', [AttributeOptionsController::class, 'update'])->name('attribute-options.update');

    //Attribute Families
    Route::get('attribute-families', [AttributeFamiliesController::class, 'index'])->name('attribute-families.index');
    Route::get('attribute-families/create', [AttributeFamiliesController::class, 'create'])->name('attribute-families.create');
    Route::post('attribute-families', [AttributeFamiliesController::class, 'store'])->name('attribute-families.store');
    Route::get('attribute-families/{attribute_family}', [AttributeFamiliesController::class, 'edit'])->name('attribute-families.edit');
    Route::patch('attribute-families/{attribute_family}', [AttributeFamiliesController::class, 'update'])->name('attribute-families.update');
});
