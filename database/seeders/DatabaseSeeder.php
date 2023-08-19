<?php

namespace Database\Seeders;

use App\Models\{Item, User};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->admin()
            ->create([
                'name'  => 'AJ',
                'email' => 'aj@aj.com',
            ]);

        Item::factory(25)
            ->forCategory()
            ->activated()
            ->create();
    }
}
