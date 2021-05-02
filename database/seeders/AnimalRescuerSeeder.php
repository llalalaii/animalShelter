<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\AnimalRescuer;
use App\Models\Rescuer;
use Illuminate\Database\Seeder;

class AnimalRescuerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // AnimalRescuer::factory()
        //     ->count(50)
        //     ->create();
        $animals = Animal::paginate(10);
        $rescuers = Rescuer::paginate(10);

        foreach ($rescuers as $rescuer) {
            foreach ($animals as $animal) {
                AnimalRescuer::firstOrCreate([
                    'rescuer_id' => $rescuer->id,
                    'animal_id' => $animal->id,
                ]);
            }
        }
    }
}
