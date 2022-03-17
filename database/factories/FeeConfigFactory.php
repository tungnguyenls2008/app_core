<?php

namespace Database\Factories;

use App\Models\FeeConfig;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeeConfigFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FeeConfig::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'merchant_id' => $this->faker->word,
        'type' => $this->faker->randomDigitNotNull,
        'fixed_fee' => $this->faker->randomDigitNotNull,
        'percentage_fee' => $this->faker->randomDigitNotNull,
        'status' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
