<?php

namespace Database\Factories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Announcement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'branch_id' => rand(1, 2),
            'announcement_title' => rtrim($this->faker->sentence(rand(3, 6)), '.'),
            'announcement_body' => $this->faker->paragraphs(rand(1, 2), true),
            'announcement_image' => $this->faker->imageUrl('940', '650'),
        ];
    }
}
