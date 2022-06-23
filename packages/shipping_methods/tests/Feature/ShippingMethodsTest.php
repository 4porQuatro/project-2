<?php

namespace Packages\shipping_methods\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Zone;
use Packages\shipping_methods\App\Models\ShippingMethod;
use Packages\shipping_methods\App\Models\ShippingPrice;
use Packages\Store\app\Classes\Front\Shoppingcart\Cart;
use Packages\Store\app\Models\Product;
use Tests\TestCase;

class ShippingMethodsTest extends TestCase {

    use DatabaseMigrations;



    public function setUp() :void
    {
        parent::setUp();
        $product = Product::factory()->create(['shippment_weight'=>10, 'shippment_length'=>10, 'shippment_height'=>10, 'shippment_width'=>10]);
        $cart = new Cart(session());
        $cart->add($product, 1);

        $zone = Zone::factory()->create();
        $zone->countries()->attach(Country::where('code', 'pt')->first());

    }

    /** @test */
    public function its_possible_retrieve_the_avaliable_shippment_methods_for_a_given_country()
    {
        $zone = Zone::factory()->create();
        $shipping_method = ShippingMethod::factory()->create(['default_price'=>10, 'default_free_order_price'=>500]);
        $shipping_method->zones()->attach($zone);
        $shipping_price = ShippingPrice::factory()->create([
            'shipping_method_id'=>$shipping_method->id,
            'priceable_type'=>Zone::class,
            'priceable_id'=>$zone->id,
            'price'=>20,
            'free_order_price'=>1000,
            'min_volume'=>10*10*10-1,
            'max_volume'=>10*10*10+2,
            'min_weight'=>10-1,
            'max_weight'=>10+2
        ]);

        $zone->countries()->attach(Country::where('code', 'pt')->first());
        $response = $this->get(route('api.shipping_methods.get', ['country'=>Country::where('code', 'pt')->first()->id]));

        $response->assertStatus(200);
        $this->assertEquals(20, $response->json()[0]['price']);
        $this->assertEquals(1000, $response->json()[0]['default_free_order_price']);
        $this->assertEquals($shipping_method->name, $response->json()[0]['name']);
    }

    /** @test */
    public function its_possible_retrieve_the_avaliable_shippment_methods_for_a_given_region()
    {

        $zone = Zone::factory()->create();
        $zone_2 = Zone::factory()->create();
        $shipping_method = ShippingMethod::factory()->create(['default_price'=>10, 'default_free_order_price'=>500]);
        $shipping_method->zones()->attach($zone);
        $shipping_price_2 = ShippingPrice::factory()->create([
            'shipping_method_id'=>$shipping_method->id,
            'priceable_type'=>Zone::class,
            'priceable_id'=>$zone_2->id,
            'price'=>30,
            'free_order_price'=>2000,
            'min_volume'=>10*10*10-1,
            'max_volume'=>10*10*10+2,
            'min_weight'=>10-1,
            'max_weight'=>10+2
        ]);
        $shipping_price = ShippingPrice::factory()->create([
            'shipping_method_id'=>$shipping_method->id,
            'priceable_type'=>Zone::class,
            'priceable_id'=>$zone->id,
            'price'=>20,
            'free_order_price'=>1000,
            'min_volume'=>10*10*10-1,
            'max_volume'=>10*10*10+2,
            'min_weight'=>10-1,
            'max_weight'=>10+2
        ]);

        $country = Country::where('code', 'pt')->first();
        $zone->countries()->attach($country);
        $zone_2->regions()->attach($country->regions->first());

        $response = $this->get(route('api.shipping_methods.get', ['country'=>Country::where('code', 'pt')->first()->id, 'region'=>$country->regions->first()->id]));

        $response->assertStatus(200);
        $this->assertEquals(30, $response->json()[0]['price']);
        $this->assertEquals(2000, $response->json()[0]['default_free_order_price']);
        $this->assertEquals($shipping_method->name, $response->json()[0]['name']);
    }



}
