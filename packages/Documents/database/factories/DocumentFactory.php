<?php

namespace Packages\Documents\database\factories;

use Packages\Documents\App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Document::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'paths'=>[
                ['path'=>'/path/to/file', 'alt_text'=>'ola']
            ]
        ];
    }
}
