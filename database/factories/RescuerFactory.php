<?php

namespace Database\Factories;

use App\Models\Rescuer;
use Illuminate\Database\Eloquent\Factories\Factory;

class RescuerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rescuer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'description' => $this->faker->text(200),
        ];
    }
}
