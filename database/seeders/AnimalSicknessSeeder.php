<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\AnimalSickness;
use App\Models\Sickness;
use Illuminate\Database\Seeder;

class AnimalSicknessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $animals = Animal::paginate(10);
        $sicknesses = Sickness::paginate(10);

        foreach ($animals as $animal) {
            foreach ($sicknesses as $sickness) {
                AnimalSickness::firstOrCreate([
                    'sickness_id' => $sickness->id,
                    'animal_id' => $animal->id,
                ]);
            }
        }
    }
}
