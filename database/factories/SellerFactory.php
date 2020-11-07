<?php

namespace Database\Factories;

use App\Seller;
use App\Account;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SellerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Seller::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_id' => Account::factory()->create()->id,
            'cnpj' => $this->faker->cnpj(false),
            'fantasy_name' => $this->faker->company,
            'social_name' => $this->faker->company,
        ];
    }
}
