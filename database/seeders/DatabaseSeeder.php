<?php

namespace Database\Seeders;

use App\Models\{Item, User};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(SettingSeeder::class);
    }
}
