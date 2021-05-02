<?php

namespace Database\Seeders;

use App\Models\Sickness;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class SicknessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sickness::factory()
            ->count(50)
            ->state(new Sequence(
                ['is_injury' => 0],
                ['is_injury' => 1],
            ))
            ->create();
    }
}
