<?php

namespace Database\Seeders;

use App\Models\Adopter;
use Illuminate\Database\Seeder;

class AdopterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Adopter::factory()
            ->count(50)
            ->create();
    }
}
