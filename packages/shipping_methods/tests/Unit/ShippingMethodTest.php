<?php

namespace Packages\shipping_methods\tests\Unit;


use App\Models\Article;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Zone;
use Packages\shipping_methods\App\Models\ShippingMethod;
use Packages\shipping_methods\App\Models\ShippingPrice;
use Tests\TestCase;

class ShippingMethodTest extends TestCase
{
    use DatabaseMigrations;

    public $shipping_method;

    public function setUp(): void
    {
        parent::setUp();
        $this->shipping_method = ShippingMethod::factory()->create();
    }

    /** @test */
    public function has_a_default_price()
    {
        $this->assertArrayHasKey('default_price', $this->shipping_method->toArray());
    }

    /** @test */
    public function has_a_default_free_order_price()
    {
        $this->assertArrayHasKey('default_free_order_price', $this->shipping_method->toArray());
    }

    /** @test */
    public function has_a_name()
    {
        $this->assertArrayHasKey('name', $this->shipping_method->toArray());
    }

    /** @test */
    public function can_have_a_article()
    {
        $this->assertNull($this->shipping_method->article);
        Article::factory()->create(['articlable_id'=>$this->shipping_method->id, 'articlable_type'=>ShippingMethod::class]);
        $this->assertInstanceOf(Article::class, $this->shipping_method->fresh()->article);
    }

    /** @test */
    public function has_a_priority()
    {
        $this->assertArrayHasKey('priority', $this->shipping_method->toArray());
        $this->assertIsInt($this->shipping_method->priority);
    }

    /** @test */
    public function a_shipping_method_can_have_multiple_shipping_prices()
    {
        ShippingPrice::factory(4)->create(['shipping_method_id' => $this->shipping_method->id]);

        $this->assertInstanceOf(ShippingPrice::class, $this->shipping_method->shippingPrices()->first());
        $this->assertCount(4, $this->shipping_method->shippingPrices);

    }

    /** @test */
    public function a_shipping_mehtod_has_allowed_locations()
    {
        $zone = Zone::factory(3)->create();
        $this->shipping_method->zones()->sync($zone->pluck('id')->toArray());

        $this->assertCount(3, $this->shipping_method->zones);

    }

    /** @test */
    public function a_shipping_method_has_countries()
    {
        $zone = Zone::factory()->create();
        $countries = Country::limit(4)->get();
        $zone->countries()->attach($countries);

        $zone2 = Zone::factory()->create();
        $countries2 = Country::limit(4)->get();
        $zone2->countries()->attach($countries2);

        $this->shipping_method->zones()->sync([$zone->id, $zone2->id]);

        $this->assertCount(2, $this->shipping_method->zones);
        $this->assertCount(4, $this->shipping_method->avaliableCountries());
    }

    /** @test */
    public function the_avaliable_countries_for_a_given_shipping_methods_also_consider_regions()
    {
        $zone = Zone::factory()->create();
        $country = Country::first();
        $zone->regions()->attach($country->regions);
        $this->shipping_method->zones()->sync([$zone->id]);

        $this->assertCount(1, $this->shipping_method->avaliableCountries());


    }

    /** @test */
    public function its_possible_retrieve_the_the_prices_for_a_given_country_volume_and_weight()
    {
        $zone1 = Zone::factory()->create();
        $shipping_method = ShippingMethod::factory()->create(['default_price'=>5, 'default_free_order_price'=>30]);
        $shipping_method->zones()->attach($zone1);
        $country_france = Country::where('code', 'fr')->first();
        $zone1->countries()->attach($country_france->id);
        $shipping_price = ShippingPrice::factory()
            ->create(['min_volume'=>5, 'max_volume'=>10,'min_weight'=>30, 'max_weight'=>50, 'price'=>10, 'free_order_price'=>100, 'priceable_type'=>Zone::class, 'priceable_id'=>$zone1->id, 'shipping_method_id'=>$shipping_method->id]);

        $shipping_method->setShippingPriceByAttributesAndCountry([$zone1->id], 7, 500);

        $this->assertEquals(5, $shipping_method->price);
        $this->assertEquals(30, $shipping_method->default_free_order_price);

    }

    /** @test */
    public function has_a_email_receiver_for_the_orders()
    {
        $this->assertArrayHasKey('emails', $this->shipping_method->fresh()->toArray());
    }

}
