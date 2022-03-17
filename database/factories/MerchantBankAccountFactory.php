<?php

namespace Database\Factories;

use App\Models\MerchantBankAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class MerchantBankAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MerchantBankAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'merchant_id' => $this->faker->randomDigitNotNull,
        'account_number' => $this->faker->word,
        'bank_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
