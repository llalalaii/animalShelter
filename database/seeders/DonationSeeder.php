<?php

namespace Database\Seeders;

use App\Models\Donation;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Donation::factory()
            ->count(50)
            ->create();
    }
}
