<?php

namespace Database\Factories;

use App\Models\BalanceChangeCallback;
use Illuminate\Database\Eloquent\Factories\Factory;

class BalanceChangeCallbackFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BalanceChangeCallback::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'request' => $this->faker->text,
        'response' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
