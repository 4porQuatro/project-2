<?php

namespace Packages\Store\database\factories;

use Packages\Store\app\Models\AttributeFamily;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeFamilyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AttributeFamily::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'=>$this->faker->word,
        ];
    }
}
