<?php

namespace Database\Factories;

use App\Models\Sickness;
use Illuminate\Database\Eloquent\Factories\Factory;

class SicknessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sickness::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(50),
            'description' => $this->faker->text(200),
        ];
    }
}
