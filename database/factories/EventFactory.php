<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'branch_id' => rand(1, 2),
            'title' => rtrim($this->faker->sentence(rand(3, 6)), '.'),
            'body' => $this->faker->paragraphs(rand(1, 2), true),
            'image' => $this->faker->imageUrl('940', '650'),
            'upcoming_at' => $this->faker->dateTime
        ];
    }
}
