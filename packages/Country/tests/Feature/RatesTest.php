<?php

namespace Packages\Country\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Packages\Country\App\Classes\Front\SessionVariable;
use Packages\Country\App\Models\Currency;
use Tests\TestCase;

class RatesTest extends TestCase {

    use DatabaseMigrations;

    /** @test */
    public function a_user_can_set_a_currency()
    {
        $currency = Currency::first();
        $currency->active = true;
        $currency->save();

        $response = $this->patch(route('user.rates.update'), ['currency_id'=>$currency->id]);
        $response->assertStatus(200);
        $this->assertEquals($currency->rate, SessionVariable::getPriceRate());
    }
}
