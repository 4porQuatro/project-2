<?php

namespace Packages\PaymentsMethods\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Packages\PaymentsMethods\App\Models\PaymentMethod;
use Packages\PaymentsMethods\App\Models\PaymentProviders;

class PaymentMethodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentMethod::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $provider = array_rand((new PaymentProviders())->avaliable_providers);
        $provider_method = array_rand((new $provider)->avaliableMethods());
        return [
            'name'=>$this->faker->word,
            'provider'=>$provider,
            'provider_method'=>$provider_method
        ];
    }
}
