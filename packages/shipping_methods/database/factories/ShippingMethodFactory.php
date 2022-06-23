<?php

namespace Packages\shipping_methods\database\factories;

use Packages\shipping_methods\App\Models\ShippingMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShippingMethodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShippingMethod::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'default_price' => $this->faker->randomFloat(2, 1, 10),
            'default_free_order_price'=>$this->faker->randomFloat(2),
        ];
    }
}
