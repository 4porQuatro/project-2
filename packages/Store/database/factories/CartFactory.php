<?php

namespace Packages\Store\database\factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Packages\Store\app\Models\Cart;

class CartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cart::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'data'=>[],
            'session_id' => $this->faker->unique()->uuid,
        ];
    }

}

