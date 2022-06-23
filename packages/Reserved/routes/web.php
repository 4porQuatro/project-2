<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Packages\Reserved\App\Http\Controllers\LoginController;
use Packages\Reserved\App\Http\Controllers\PagesController;
use Packages\Reserved\App\Http\Controllers\RegisterController;
use Packages\Reserved\App\Http\Controllers\AddressesController;
use Packages\Reserved\App\Http\Controllers\ProfileController;
use Packages\Reserved\App\Http\Controllers\PasswordController;
use Packages\Reserved\App\Http\Controllers\UserDocumentsController;


if(Schema::hasTable('reserved_areas'))
{
    foreach(\Packages\Reserved\App\Models\ReservedArea::all() as $reserved)
    {
        Route::middleware(['web'])->prefix($reserved->prefix)->group(function() use ($reserved){
            Route::post('register', [RegisterController::class, 'store'] )->name($reserved->prefix.'.register');

            Route::post('login', [LoginController::class, 'store'])->name($reserved->prefix.'.login');
        });

        Route::middleware(['web', 'auth.reserved', 'locale.cms'])->prefix($reserved->prefix)->group(function() use ($reserved){
            Route::patch('/profile', [ProfileController::class, 'update'])->name($reserved->prefix.'.profile');

            Route::patch('/password', [PasswordController::class, 'update'])->name($reserved->prefix.'.new-password');

            Route::post('/address', [AddressesController::class, 'store'])->name($reserved->prefix.'.address');
            Route::patch('/address', [AddressesController::class, 'update'])->name($reserved->prefix.'.address.update');
            Route::delete('/address/{address}', [AddressesController::class, 'destroy'])->name($reserved->prefix.'.address.delete');
            Route::patch('/address/udpate/default/{address}', [AddressesController::class, 'toogleDefault'])->name($reserved->prefix.'.address.update.default');
        });

        Route::middleware(['web', 'auth.reserved', 'locale.front'])->prefix($reserved->prefix)->group(function() use ($reserved) {
            Route::get('/{slug?}', [PagesController::class, 'index']);
            Route::get('/{type}/{slug}', [PagesController::class, 'show']);
        });
    }
}

Route::middleware(['web'])->get('customers/{customer}/{identifier}/download', [UserDocumentsController::class, 'download'])->name('customers.data.download');

Route::middleware(['web','auth'])->get('address/get/{type}', [AddressesController::class, 'get'])->name('address.get');

//O ojectivo deste bloco de routes é permitir testar a ferramenta.
if(env('APP_ENV') == 'testing')
{

        Route::middleware(['web'])->prefix('prefix_test')->group(function() {
            Route::post('register', [RegisterController::class, 'store'])->name('prefix_test.register');

            Route::post('login', [LoginController::class, 'store'])->name('prefix_test.login');
        });

        Route::middleware(['web', 'auth.reserved', 'locale.cms'])->prefix('prefix_test')->group(function() {

            Route::patch('/profile', [ProfileController::class, 'update'])->name('prefix_test.profile');

            Route::patch('/password', [PasswordController::class, 'update'])->name('prefix_test.new-password');

            Route::post('/address', [AddressesController::class, 'store'])->name('prefix_test.address');
            Route::patch('/address', [AddressesController::class, 'update'])->name('prefix_test.address.update');
            Route::delete('/address/{address}', [AddressesController::class, 'destroy'])->name('prefix_test.address.delete');
            Route::patch('/address/udpate/default/{address}', [AddressesController::class, 'toogleDefault'])->name('prefix_test.address.update.default');


            Route::get('/{slug?}',  [PagesController::class, 'index']);
            Route::get('/{type}/{slug}', [PagesController::class, 'show']);
        });

}

