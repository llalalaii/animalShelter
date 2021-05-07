<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdopterSeeder::class,
            AnimalSeeder::class,
            RescuerSeeder::class,
            SicknessSeeder::class,
            UserSeeder::class,
            AnimalRescuerSeeder::class,
            AnimalSicknessSeeder::class,
            AdopterAnimalSeeder::class,
            ContactSeeder::class,
        ]);

        DB::table('users')->insert([
            'first_name' => 'Super',
            'last_name' => 'User',
            'email' => 'user@gmail.com',
            'position' => 'Veterinarian',
            'password' => Hash::make('qweasd'),
        ]);
    }
}
