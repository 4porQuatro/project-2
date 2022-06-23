<?php

namespace Packages\Store\database\factories;

use Packages\Store\app\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attribute::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'admin_title' => $this->faker->unique()->word,
            'title' => $this->faker->unique()->word,
        ];
    }
}
