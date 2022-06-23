<?php
namespace Packages\Country\App\Classes\Front;

use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Currency;
use Packages\Country\App\Models\Tax;

class SessionVariable {

    public static function setUserTaxes($tax)
    {
        session()->put('tax', $tax);
        session()->put('user_tax', $tax/100);
    }

    public static function setUserShippingCountry(Country $country)
    {
        session()->put('shipping_country', $country);
    }

    public static function setPriceRate(Currency $currency)
    {
        session()->put('currency', $currency);
        session()->put('user_rate', $currency->rate);
    }

    public static function getUserTaxes()
    {
        return session()->get('user_tax') ?? Tax::getDefault();
    }

    public static function getPriceRate()
    {
        return session()->get('user_rate') ?? 1  ;
    }

    public static function getUserShippingCountry()
    {
        return session()->get('shipping_country');
    }

    public function getDefaultTax()
    {
        return Tax::getDefault();
    }
}
