<?php

namespace Packages\Country\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Packages\Country\App\Classes\Front\SessionVariable;
use Packages\Country\App\Models\Country;
use Tests\TestCase;

class UserCountryTest extends TestCase {
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_set_the_country_where_the_delivery_will_happens_and_set_the_taxes()
    {
        $country = Country::first();
        $country->active = 1;
        $country->save();

        $response = $this->patch(route('user.country.update'), ['country_id'=>$country->id]);

        $response->assertStatus(200);

        $this->assertEquals($country, SessionVariable::getUserShippingCountry());
    }

    /** @test */
    public function its_possible_set_the_rate_when_user_changes_the_shipping_country()
    {
        $country = Country::first();
        $country->active = 1;
        $country->save();

        $response = $this->patch(route('user.country.update'), ['country_id'=>$country->id, 'set_rate'=>1]);

        $response->assertStatus(200);
        //$this->assertEquals($country, SessionVariable::getUserShippingCountry());
        $this->assertEquals($country->currency->rate, SessionVariable::getPriceRate());
    }

    /** @test */
    public function its_possible_set_the_taxes_when_user_changes_the_shipping_country()
    {
        $country = Country::first();
        $country->active = 1;
        $country->save();

        $response = $this->patch(route('user.country.update'), ['country_id'=>$country->id, 'set_tax'=>1]);

        $response->assertStatus(200);
        //$this->assertEquals($country, SessionVariable::getUserShippingCountry());
        $this->assertEquals($country->defaultTax()/100, SessionVariable::getUserTaxes());
    }



}
