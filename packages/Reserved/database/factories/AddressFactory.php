<?php

namespace Packages\Reserved\database\factories;

use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Region;
use Packages\Reserved\App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\pt_PT\Person;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $post_code_array = explode("-", $this->faker->postcode);

        return [
            'name'=>$this->faker->word,
            'nif'=>'239641124',
            'address'=>$this->faker->streetName,
            'post_code'=>$post_code_array[0],
            'post_code_prefix'=>$post_code_array[1] ?? '123',
            'region_id'=> Region::first()->id,
            'country_id'=>Country::first()->id,
            'city'=>$this->faker->word,
            'phone'=>$this->faker->phoneNumber,
            'email'=>$this->faker->email,
        ];
    }
}
