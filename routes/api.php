<?php

use App\Http\Controllers\api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ContactsController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->patch('/api/sant/new_items/{type}', [\App\Http\Controllers\api\ApiPatchDataController::class, 'store'])->name('api.items.store');

Route::middleware('auth:sanctum')->prefix('api')->group(function(){

    //Categories
    Route::post('v1/category/{type}', [CategoryController::class, 'store'])->name('api.category.store');
    Route::put('v1/category/{type}/{category}', [CategoryController::class, 'update'])->name('api.category.update');
    Route::delete('v1/category/{type}/{identifier}',  [CategoryController::class, 'destroy'])->name('api.category.delete');

});


Route::middleware('auth:sanctum')->post('/api/user_test', function (Request $request) {
    return $request->user();
});

Route::middleware('web')->prefix('api')->group(function(){
   Route::post('contact', [ContactsController::class, 'store']);
});
