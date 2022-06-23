<?php
use Illuminate\Support\Facades\Route;

if(env('APP_ENV') == 'testing')
{
    $locales = [
        'pt',
        'en'
    ];

    foreach ($locales as $locale)
    {
        Route::group(['prefix'=>$locale, 'middleware'=>['locale.front']], function() {
            Route::get('/{slug?}',  [\App\Http\Controllers\PagesController::class, 'index']);
            Route::get('/{type}/{slug}', [\App\Http\Controllers\PagesController::class, 'show']);
            Route::post('form_submit', [\App\Http\Controllers\FormsController::class, 'store'])->name('form.submit.default');
        });
    }
}
