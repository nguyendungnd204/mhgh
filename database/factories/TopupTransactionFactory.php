<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserCharacter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TopupTransaction>
 */
class TopupTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_code' => strtoupper(fake()->unique()->bothify('TXN###??')),
            'user_id' => User::factory(),
            'user_character_id' => UserCharacter::factory(),
            'card_type' => fake()->randomElement(['viettel', 'mobifone', 'vinaphone', 'vietnamobile', 'garena']),
            'amount' => fake()->randomElement([10000, 20000, 50000, 100000]),
            'serial' => fake()->numerify('####-####-####'),
            'card_code' => fake()->numerify('####-####-####'),
            'status' => fake()->randomElement(['pending', 'success', 'failed']),
            'response_content' => fake()->optional()->sentence(),
            'submitted_at' => now(),
            'verified_at' => fake()->optional()->dateTime(),
            'is_manual' => fake()->boolean(20),
        ];
    }
}
