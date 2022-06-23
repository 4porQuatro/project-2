<?php

namespace App\Http\Middleware;

use App\Classes\Locales\FrontLocale;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class FrontLanguage
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
        $front_locale = new FrontLocale();

        if(count($request->segments()) == 1 && $front_locale->checkIfLocaleIsAvailable($request->segment(1)))
        {
            $front_locale->setNewActiveLocaleInSession($request->segment(1));
        }

        App::setLocale($front_locale->active_locale);

        config([
           'translatable.front_locales'=>$front_locale->avaiable_locales,
            'app.locale'=>$front_locale->active_locale
        ]);

        return $next($request);
    }
}
