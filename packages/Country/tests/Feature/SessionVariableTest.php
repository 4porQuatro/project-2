<?php

namespace Packages\Country\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Packages\Country\App\Classes\Front\SessionVariable;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Currency;
use Tests\TestCase;

class SessionVariableTest extends TestCase {

    use DatabaseMigrations;

    /** @test */
    public function its_possible_to_set_the_current_session_rate()
    {
        $currency = Currency::first();
        $currency->rate = 20;
        $currency->save();
        SessionVariable::setPriceRate($currency);
        $this->assertEquals($currency, session()->get('currency'));
        $this->assertEquals($currency->rate, session()->get('user_rate'));
    }

    /** @test */
    public function its_possible_set_the_session_shipping_country()
    {
        $country = Country::first();
        SessionVariable::setUserShippingCountry($country);

        $this->assertEquals($country, session()->get('shipping_country'));
    }

    /** @test */
    public function its_possible_to_set_the_session_taxes()
    {
        SessionVariable::setUserTaxes(30);
        $this->assertEquals(.3, session()->get('user_tax'));
        $this->assertEquals(30, session()->get('tax'));
    }

    /** @test */
    public function its_possible_to_get_the_current_session_rate()
    {
        $currency = Currency::first();
        $currency->rate = 20;
        $currency->save();
        SessionVariable::setPriceRate($currency);
        $this->assertEquals($currency->rate, SessionVariable::getPriceRate());
    }

    /** @test */
    public function its_possible_get_the_session_shipping_country()
    {
        $country = Country::first();
        SessionVariable::setUserShippingCountry($country);
        $this->assertEquals($country, SessionVariable::getUserShippingCountry());
    }

    /** @test */
    public function its_possible_to_get_the_session_taxes()
    {
        $currency = Currency::first();
        $currency->rate = 20;
        $currency->save();
        SessionVariable::setPriceRate($currency);

        $this->assertEquals(20, SessionVariable::getPriceRate());
    }


}
