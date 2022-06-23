<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Classes\Locales\CmsLocale;

class CmsLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $cms_locale = new CmsLocale();

        App::setLocale($cms_locale->active_locale);

        config([
            'translatable.locales'=>array_keys($cms_locale->available_locales),
            'app.locale'=>$cms_locale->active_locale
        ]);

        return $next($request);
    }
}
