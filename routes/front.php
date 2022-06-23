<?php
use Illuminate\Support\Facades\Route;

Route::post('/cookie/store', [\App\Http\Controllers\CookiesController::class, 'store'])->name('cookies.store');

foreach(cache('front_available_locales', []) as $locale=>$lang)
{

    Route::group(['prefix'=>$locale, 'middleware'=>['locale.front']], function() {
        Route::get('/{slug?}',  [\App\Http\Controllers\PagesController::class, 'index']);
        Route::get('/{type}/{slug}', [\App\Http\Controllers\PagesController::class, 'show']);
        Route::post('form_submit', [\App\Http\Controllers\FormsController::class, 'store'])->name('form.submit.default');
    });

}

Route::group(['prefix'=>'', 'middleware'=>['locale.front']], function() {
    Route::get('/{slug?}',  [\App\Http\Controllers\PagesController::class, 'index']);
    Route::get('/{type}/{slug}', [\App\Http\Controllers\PagesController::class, 'show']);
    Route::post('form_submit', [\App\Http\Controllers\FormsController::class, 'store'])->name('form.submit.default');
    Route::get('api/article/get', [\App\Http\Controllers\ArticleController::class, 'get'])->name('api.article.get');

    Route::get('api/category/{id}', [\App\Http\Controllers\CategoryController::class, 'show'])->name('api.category.show');
    Route::get('api/category/get_childrens/{category}', [\App\Http\Controllers\CategoryController::class, 'getChildrens']);
    Route::get('api/category/get_all_childrens/{category}',[\App\Http\Controllers\CategoryController::class, 'getAllChildrens']);
});
