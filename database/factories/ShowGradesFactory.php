<?php

namespace Database\Factories;

use App\Models\ShowGrades;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShowGradesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = ShowGrades::class;

    public function definition()
    {
        return [
            'show_deped_grade' => 0,
            'show_ched_grade' => 0
        ];
    }
}
