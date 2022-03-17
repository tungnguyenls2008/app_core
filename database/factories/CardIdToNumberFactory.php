<?php

namespace Database\Factories;

use App\Models\CardIdToNumber;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardIdToNumberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CardIdToNumber::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'merchant_id' => $this->faker->word,
        'card_id' => $this->faker->word,
        'card_number' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
