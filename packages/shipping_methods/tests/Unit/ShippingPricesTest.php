<?php


namespace Packages\shipping_methods\tests\Unit;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Region;
use Packages\Country\App\Models\Zone;
use Packages\shipping_methods\App\Models\ShippingMethod;
use Packages\shipping_methods\App\Models\ShippingPrice;
use Tests\TestCase;

class ShippingPricesTest extends TestCase {

    use DatabaseMigrations;

    public $shipping_price;
    public $shipping_method;

    public function setUp(): void
    {
        parent::setUp();
        $this->shipping_method = ShippingMethod::factory()->create();
        $this->shipping_price = ShippingPrice::factory()->create(['shipping_method_id'=>$this->shipping_method->id]);
    }

    /** @test */
    public function belongs_to_a_shipping_method()
    {
        $this->assertNotEmpty($this->shipping_price->shippingMethod);
        $this->assertInstanceOf(ShippingMethod::class, $this->shipping_price->shippingMethod);
    }

    /** @test */
    public function has_a_interval_of_volume()
    {
        $this->assertArrayHasKey('min_volume', $this->shipping_price->toArray());
        $this->assertArrayHasKey('max_volume', $this->shipping_price->toArray());
    }

    /** @test */
    public function has_a_interval_of_weight()
    {
        $this->assertArrayHasKey('min_weight', $this->shipping_price->toArray());
        $this->assertArrayHasKey('max_weight', $this->shipping_price->toArray());
    }

    /** @test */
    public function has_a_price()
    {
        $this->assertArrayHasKey('price', $this->shipping_price->toArray());
    }

    /** @test */
    public function has_a_free_order_price()
    {
        $this->assertArrayHasKey('free_order_price', $this->shipping_price->toArray());
    }

    /** @test */
    public function can_belongs_to_a_zone()
    {
        $this->assertNull($this->shipping_price->country_id);
        $zone = Zone::factory()->create();
        $this->shipping_price->priceable_id = $zone->id;
        $this->shipping_price->priceable_type = Zone::class;
        $this->shipping_price->save();

        $this->assertInstanceOf(Zone::class, $this->shipping_price->priceable);
    }

    /** @test */
    public function can_belongs_to_a_region()
    {
        $this->assertNull($this->shipping_price->region_id);

        $this->shipping_price->priceable_id = Region::first()->id;
        $this->shipping_price->priceable_type = Region::class;
        $this->shipping_price->save();

        $this->assertInstanceOf(Region::class, $this->shipping_price->priceable);
    }

}
