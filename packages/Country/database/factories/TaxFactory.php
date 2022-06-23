<?php


namespace Packages\Country\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Tax;

class TaxFactory extends Factory{

    protected $model = Tax::class;

    public function definition()
    {
        return [
            'taxable_id'=>Country::factory()->create()->id,
            'taxable_type'=>Country::class,
            'percentage'=>$this->faker->randomFloat(2,0,100)
        ];
    }
}
