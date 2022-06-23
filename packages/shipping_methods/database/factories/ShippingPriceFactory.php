<?php

namespace Packages\shipping_methods\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Packages\shipping_methods\App\Models\ShippingMethod;
use Packages\shipping_methods\App\Models\ShippingPrice;

class ShippingPriceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShippingPrice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'shipping_method_id'=>ShippingMethod::factory()->create()->id,
            'min_volume'=>$this->faker->numberBetween(1, 10),
            'max_volume'=>$this->faker->numberBetween(10,20),
            'min_weight'=>$this->faker->numberBetween(1, 10),
            'max_weight'=>$this->faker->numberBetween(10,20),
            'price'=>$this->faker->numberBetween(10,200),
            'free_order_price'=>$this->faker->numberBetween(10, 200)


        ];
    }
}
