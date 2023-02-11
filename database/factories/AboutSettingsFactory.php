<?php

namespace Database\Factories;

use App\Models\AboutSettings;
use Illuminate\Database\Eloquent\Factories\Factory;

class AboutSettingsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AboutSettings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'page_title' => 'About Us',
            'page_subtitle' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Veritatis, aspernatur.',
            'about_title' => 'Who We Are',
            'about_content' => 'Paete Science and Business College, Inc. (formerly Eastern Laguna Colleges, Inc.) is a private school in Paete, Laguna. It was founded in 2009 and currently has two campuses in the province—the Main Campus, with programs from kindergarten to the graduate level, and the Pagsanjan Annex, with a K-12 program. For Senior High School (SHS) students, PSBC provides the ABM, GAS, HUMSS, STEM, and HE strands.',
            'vision' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis rerum repudiandae ab, reprehenderit veritatis atque molestias provident totam minima quia, maiores quidem ducimus eligendi neque incidunt ex ut unde. Voluptates fugiat vitae nulla quibusdam, accusantium minima molestias libero natus esse voluptatum officiis ex dolore sit quas enim eos veniam soluta!',
            'mission' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Odit est, laboriosam ut et recusandae quae iste praesentium voluptates quod nobis. At saepe officia dolorum explicabo fugiat cum nulla eaque. Sequi fugiat nobis laborum deleniti, labore corporis deserunt quam. Sequi, qui.',
        ];
    }
}
