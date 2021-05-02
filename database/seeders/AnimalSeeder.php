<?php

namespace Database\Seeders;

use App\Models\Animal;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Animal::factory()
            ->count(25)
            ->state(new Sequence(
                ['breed' => 'Aspin'],
                ['breed' => 'Golden Retriver'],
                ['breed' => 'Chihuahua'],
            ))
            ->state(new Sequence(
                ['gender' => 'Male'],
                ['gender' => 'Female'],
            ))
            ->state(new Sequence(
                ['type' => 'Dog'],
                ['type' => 'Cat'],
            ))
            ->create();
    }
}
