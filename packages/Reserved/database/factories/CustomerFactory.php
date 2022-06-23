<?php

namespace Packages\Reserved\database\factories;

use Database\Factories\UserFactory;
use Packages\Reserved\App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\pt_PT\Person;
use Packages\Reserved\App\Models\Customer;

class CustomerFactory extends UserFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;
}
