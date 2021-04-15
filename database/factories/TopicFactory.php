<?php

namespace Database\Factories;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use App\Models\Vote;

class TopicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Topic::class;

    public function configure()
    {
        return $this->afterCreating(function(Topic $topic) {
            Vote::create([
                'vote' => rand(-9, 9),
                'topic_id' => $topic->id,
                'user_id' => rand(2,3)
            ]);
        });
    }
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
            'user_id' => rand(1,3),
            'created_at' => Carbon::now()->subDays(rand(1,50))->subMinutes(rand(1, 400))
        ];
    }
}
