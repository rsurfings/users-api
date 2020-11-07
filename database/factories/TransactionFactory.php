<?php

namespace Database\Factories;

use App\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'payee_id' => $this->faker->randomNumber(),
            'payer_id' => $this->faker->randomNumber(),
            'value' => $this->faker->randomFloat(),
        ];
    }
}
