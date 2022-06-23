<?php


namespace Packages\Orders\database\factories;



use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Packages\Orders\App\Models\Checkout;
use Packages\Orders\App\Models\Order;

class OrderFactory extends Factory {

    protected $model = Order::class;


    public function definition()
    {
        return [
            'user_id'=>User::factory()->create()->id,
            'checkout_id'=>Checkout::factory()->create()->id,

            'billing_address_keys'=>[],
            'billing_address_data'=>[],

            'total'=>$this->faker->randomFloat(2),
            'total_taxes'=>$this->faker->randomFloat(2),
            'total_shipping'=>$this->faker->randomFloat(2),
            'total_discount'=>$this->faker->randomFloat(2),
            'grand_total'=>$this->faker->randomFloat(2),
            'original_shipping_method'=> [],
            'original_payment_method'=>[],
            'tracking_code_url'=>$this->faker->url,
            'tracking_code'=>$this->faker->uuid
        ];
    }
}
