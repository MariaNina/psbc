<?php

namespace Database\Seeders;

use App\Models\AboutSettings;
use Illuminate\Database\Seeder;

class AboutSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AboutSettings::factory()
            ->count(1)
            ->create();
    }
}
