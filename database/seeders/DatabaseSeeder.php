<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\{Category, Item, User};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'  => 'AJ',
            'email' => 'aj@aj.com',
        ]);

        Item::factory(10)
            ->forCategory()
            ->activated()
            ->create();
    }
}
