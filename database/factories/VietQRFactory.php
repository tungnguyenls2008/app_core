<?php

namespace Database\Factories;

use App\Models\VietQR;
use Illuminate\Database\Eloquent\Factories\Factory;

class VietQRFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VietQR::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ftType' => $this->faker->word,
        'amount' => $this->faker->randomDigitNotNull,
        'numberOfBeneficiary' => $this->faker->word,
        'description' => $this->faker->word,
        'qr_code' => $this->faker->word,
        'merchant_id' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
