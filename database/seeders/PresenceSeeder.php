<?php

namespace Database\Seeders;

use App\Models\Presence;
use Illuminate\Database\Seeder;

class PresenceSeeder extends Seeder
{
    public function run(): void
    {
        Presence::factory(50)->create();
    }
}
