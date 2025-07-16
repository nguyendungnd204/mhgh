<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()
            ->count(10)
            ->hasCharacters(2)
            ->hasTopupTransactions(3)
            ->create();
        \App\Models\UserCharacter::factory()->count(10)->create();
        \App\Models\GiftCode::factory()->count(16)->create();
        \App\Models\Event::factory()->count(16)->create();
        \App\Models\News::factory()->count(16)->create();
        \App\Models\TopupTransaction::factory()->count(16)->create();
        
    }
}
