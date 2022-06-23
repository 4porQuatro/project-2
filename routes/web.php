<?php

use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\SitemapGenerator;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('/linkstorage', function () {
//    $exitCode = Artisan::call('storage:link', [] );
//    echo $exitCode; // 0 exit code for no errors.
//});


Route::get('sitemap.xml', function(){
    //return SitemapGenerator::create('http://localhost')->getSitemap();
});

Route::group(['middleware'=>['locale.front']], function() {
    Auth::routes();
});

Route::get('register', function(){
    abort(404, 'Not allowed');
});
Route::post('register', function(){
    abort(404, 'Not allowed');
});

Route::get('payment_test', function(){
    return view('payment_methods::front.examples.layout_test');
});



require('api.php');
require('cms.php');
require('tests.php');
require('front.php');



//Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');


