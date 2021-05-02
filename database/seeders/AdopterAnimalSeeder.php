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

    private function loop($skip1, $skip2)
    {
        $adopters = Adopter::skip($skip1)->take(1)->get();
        $animals = Animal::doesntHave('sickness')->skip($skip2)->take(5)->get();
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
        $skip2 = 0;
        $this->loop($skip1, $skip2);
        // $skip1 = 1;
        // $skip2 = 5;
        // $this->loop($skip1, $skip2);
    }
}
