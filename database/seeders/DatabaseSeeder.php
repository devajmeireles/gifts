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
                'password' => bcrypt('password'),
            ]);

        $this->call(SettingSeeder::class);
    }
}
