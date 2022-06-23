<?php


namespace Packages\Orders\database\factories;



use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Packages\Orders\App\Models\Checkout;
use Packages\Orders\App\Models\Order;
use Packages\Orders\App\Models\StatusHistory;

class StatusHistoryFactory extends Factory {

    protected $model = StatusHistory::class;


    public function definition()
    {
        return [
            'status'=>1,
            'text'=>$this->faker->text,
        ];
    }
}
