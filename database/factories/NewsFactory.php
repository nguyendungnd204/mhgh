<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'thumbnail' => fake()->optional()->imageUrl(),
            'start_date' => fake()->dateTimeBetween('-5 days', '+5 days'),
            'end_date' => fake()->dateTimeBetween('+6 days', '+20 days'),
            'created_by' => User::factory(),
            'is_active' => true,
        ];
    }
}
