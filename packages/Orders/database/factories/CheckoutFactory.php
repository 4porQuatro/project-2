<?php


namespace Packages\Orders\database\factories;


use App\Models\Form;
use Illuminate\Database\Eloquent\Factories\Factory;
use Packages\Orders\App\Models\Checkout;

class CheckoutFactory extends Factory {

    protected $model = Checkout::class;

    public function definition()
    {
        return [
            'name'=>$this->faker->name,
            'type'=>0,
        ];
    }

}
