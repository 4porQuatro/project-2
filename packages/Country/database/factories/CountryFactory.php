<?php


namespace Packages\Country\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Packages\Country\App\Models\Country;

class CountryFactory extends Factory{

    protected $model = Country::class;

    public function definition()
    {
        return [
            'code'=>$this->faker->unique()->countryCode,
            'name'=>$this->faker->name
        ];
    }
}
