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
                'name'     => 'AJ',
                'username' => 'admin',
            ]);

        User::factory(10)
            ->user()
            ->create();

        Item::factory(25)
            ->forCategory()
            ->activated()
            ->create();

        $this->call(SettingSeeder::class);
    }
}
