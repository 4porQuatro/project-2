<?php

namespace Packages\Voucher\database\factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Packages\Voucher\app\Models\Voucher;

class VoucherFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Voucher::class;

    public function definition()
    {
        return [
            'name'=>$this->faker->name,
            'code'=>'',
            'discount_value'=>$this->faker->randomFloat(),
            'percentage_discount'=>$this->faker->randomFloat(),
            'expires_at'=>Carbon::now()->addDays(rand(1, 3))

        ];
    }
}
