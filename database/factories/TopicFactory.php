<?php

namespace Database\Factories;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

class TopicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Topic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->paragraph(1),
            'body' => $this->faker->paragraph(rand(1,5)),
            'views' => rand(0, 1000),
            'category_id' => rand(1, 7),
            'user_id' => rand(1,10)
        ];
    }
}
