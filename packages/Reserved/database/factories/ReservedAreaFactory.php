<?php

namespace Packages\Reserved\database\factories;

use App\Models\Article;
use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Packages\Reserved\App\Models\ReservedArea;

class ReservedAreaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReservedArea::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->word,
            'prefix'=>$this->faker->word,
            'login_page_id'=>Page::factory()->create(),
        ];
    }
}
