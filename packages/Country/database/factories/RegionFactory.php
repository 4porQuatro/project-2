<?php


namespace Packages\Country\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Packages\Country\App\Models\Country;

class RegionFactory extends Factory{

    protected $model = Region::class;

    public function definition()
    {
        return [
            'code'=>$this->faker->countryCode,
            'name'=>$this->faker->name
        ];
    }
}
