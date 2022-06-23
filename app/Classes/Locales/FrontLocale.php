<?php


namespace App\Classes\Locales;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class FrontLocale
{
    public $avaiable_locales = [];
    public $active_locale = null;

    public function __construct()
    {
        $this->setAvaiableLocales();
        $this->setActiveLocale();
    }

    private function setAvaiableLocales()
    {
        $this->avaiable_locales = Cache::rememberForever('front_available_locales', function (){
            return Setting::byName('front_available_locales')->exists() ?
               Setting::getByName('front_available_locales')->data :
               [] ;
        });
        if(empty($this->avaiable_locales))
        {
            throw new \Exception('You must have at least one language active');
        }
    }

    public function checkIfLocaleIsAvailable($locale)
    {
        if(array_key_exists($locale, $this->avaiable_locales)){
            return true;
        }

        return false;
        //TODO: Throw exception here case doent exist?
    }

    public function setNewActiveLocaleInSession($locale)
    {
        session()->put('locale', $locale);
        $this->active_locale = session('locale');
    }

    private function setActiveLocale()
    {
        //The lang is defined by the browser
        $lang = substr(\Request::server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
        //Check if locale exist in session
        if( session()->has( 'locale' ) && array_key_exists(session()->get('locale'), $this->avaiable_locales))
        {
            $lang = session()->get('locale');
        }

        //Check if locale is null on the request
        if(request()->segment(1) === null && array_key_exists($lang, $this->avaiable_locales))
        {
            $this->active_locale = $lang;
        }
        //Check if locale is defined on the request
        elseif(array_key_exists(request()->segment(1), $this->avaiable_locales))
        {
            $this->active_locale = request()->segment(1);
        }
        else
        {
            $this->active_locale = !empty($lang) && array_key_exists($lang, $this->avaiable_locales) ? $lang : array_key_first($this->avaiable_locales);
        }
    }
}
