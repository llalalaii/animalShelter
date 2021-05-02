<?php

namespace Database\Factories;

use App\Models\Donation;
use Illuminate\Database\Eloquent\Factories\Factory;

class DonationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Donation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $is_cash = rand(0, 1);
        $unit_array = ['ml', 'pcs', 'g'];
        $unit = array_rand($unit_array);

        return [
            'name' => $this->faker->text(50),
            'value' => $this->faker->randomDigitNot(0),
            'unit' => $is_cash == 0 ? $unit_array[$unit] : null,
            'is_cash' => $is_cash,
        ];
    }
}
