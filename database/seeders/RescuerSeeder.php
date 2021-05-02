<?php

namespace Database\Seeders;

use App\Models\Rescuer;
use Illuminate\Database\Seeder;

class RescuerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rescuer::factory()
            ->count(50)
            ->create();
    }
}
