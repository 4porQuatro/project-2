<?php

namespace Packages\Store\database\factories;

use Packages\Store\app\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $price = $this->faker->randomFloat(2, 2, 200);

        return [
            'priority' => 1,
            'sku' => $this->faker->ean13,
            'ref' => $this->faker->ean8,
            'price' => $price,
            'promoted_price' => $this->faker->randomFloat(2, 1, $price - 1),
            'stock' => $this->faker->numberBetween(3, 50),
            'title' => $this->faker->unique()->words(3, true),
            'slug' => $this->faker->unique()->word,
            'small_body' => $this->faker->text,
            'body' => $this->faker->text,
            'shippment_length'=>$this->faker->numberBetween(1, 50),
            'shippment_width'=>$this->faker->numberBetween(1, 50),
            'shippment_weight'=>$this->faker->numberBetween(1, 50),
        ];
    }
}
