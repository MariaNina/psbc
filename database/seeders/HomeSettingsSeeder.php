<?php

namespace Database\Seeders;

use App\Models\HomeSettings;
use Illuminate\Database\Seeder;

class HomeSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HomeSettings::factory()
            ->count(1)
            ->create();
    }
}
