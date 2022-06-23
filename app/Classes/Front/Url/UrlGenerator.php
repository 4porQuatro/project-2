<?php


namespace App\Classes\Front\Url;


class UrlGenerator
{
    public static function get()
    {
//        //TODO:: check this
//        return env('APP_URL').'/'.config('app.locale').'/';


        $browser_lang = substr(\Request::server('HTTP_ACCEPT_LANGUAGE'), 0, 2);

        if($browser_lang == config('app.locale'))
        {
            return env('APP_URL').'/';
        }

        return env('APP_URL').'/'.config('app.locale').'/';
    }
}
