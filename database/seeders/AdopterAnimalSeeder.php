<?php

namespace Database\Seeders;

use App\Models\Adopter;
use App\Models\AdopterAnimal;
use App\Models\Animal;
use Illuminate\Database\Seeder;

class AdopterAnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private function loop($take1, $skip1, $take2, $skip2)
    {
        $adopters = Adopter::skip($skip1)->take($take1)->get();
        $animals = Animal::skip($skip2)->take($take2)->get();
        foreach ($adopters as $adopter) {
            foreach ($animals as $animal) {
                AdopterAnimal::firstOrCreate([
                    'adopter_id' => $adopter->id,
                    'animal_id' => $animal->id,
                ]);
                Animal::find($animal->id)->update([
                    'is_adopted' => 1
                ]);
            }
        }
    }
    public function run()
    {
        $skip1 = 0;
        $take1 = 1;
        $skip2 = 0;
        $take2 = 5;
        $this->loop($take1, $skip1, $take2, $skip2);
        $skip1 = 1;
        $skip2 = 5;
        $this->loop($take1, $skip1, $take2, $skip2);
    }
}
