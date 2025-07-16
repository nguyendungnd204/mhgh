<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GiftCode>
 */
class GiftCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper(fake()->unique()->bothify('GIFTCODE###')),
            'reward' => fake()->sentence(),
            'expired_at' => fake()->optional()->dateTimeBetween('+1 day', '+1 month'),
            'max_uses' => fake()->optional()->numberBetween(1, 10),
            'used_count' => 0,
            'created_by' => User::factory(),
            'is_active' => true,
        ];
    }
}
