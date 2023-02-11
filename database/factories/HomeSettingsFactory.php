<?php

namespace Database\Factories;

use App\Models\HomeSettings;
use Illuminate\Database\Eloquent\Factories\Factory;

class HomeSettingsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HomeSettings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contact_no' => '(049) 557-0184',
            'email' => ' psbc.k12hs@gmail.com',
            'facebook' => 'https://www.facebook.com/sscpsbc/?_rdc=1&_rdr',
            'carousel_title' => 'Paete Science and Business College',
            'carousel_subtitle' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur assumenda corporis, quis beatae numquam et.',
            'carousel_link1' => 'http://localhost:8000/enrollment',
            'carousel_link2' => 'http://localhost:8000/lms',
            'home_icon_title1' => 'Learn with us',
            'home_icon_subtitle1' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Libero, veniam.',
            'home_icon_title2' => 'Enroll Now',
            'home_icon_subtitle2' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Libero, veniam.',
            'home_icon_title3' => 'Entrust your future',
            'home_icon_subtitle3' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Libero, veniam.',
            'home_announcement_img_background' => '/landing_img/img_overlay_1635854086.png',
            'campus_title' => 'EXPLORE OUR CAMPUSES',
            'campus_subtitle' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum velit rem, debitis vitae autem veritatis sed praesentium cupiditate quasi saepe sint, beatae quae amet, explicabo consequuntur sunt laboriosam esse totam recusandae unde. Quod animi assumenda exercitationem quo, impedit sit iusto quasi facilis quas commodi, nisi nulla dignissimos. Excepturi, doloremque ipsa!',
            'offer_title' => 'Everything you need',
            'offer_subtitle' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quasi in impedit iure laudantium incidunt nobis! Sapiente sequi quam iusto reprehenderit?',
            'offer_list' => 'College, Senior High School, Junior High School, Elementary',
            'program_pagetitle' => 'PROGRAMS AND COURSES',
            'program_contentitle' => 'PROGRAMS OFFERED',
            'is_maintenance' => 0
        ];
    }
}
