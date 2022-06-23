<?php


namespace Packages\Country\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Packages\Country\App\Models\Zone;

class ZoneFactory extends Factory{

    protected $model = Zone::class;

    public function definition()
    {
        return [
            'name'=>$this->faker->name
        ];
    }
}
