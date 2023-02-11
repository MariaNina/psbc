<?php

namespace Database\Seeders;

use App\Models\ShowGrades;
use Illuminate\Database\Seeder;

class ShowGradesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShowGrades::factory()
            ->count(1)
            ->create();
    }
}
