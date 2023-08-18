<?php

namespace Database\Seeders;

use App\Models\Signature;
use Illuminate\Database\Seeder;

class SignatureSeeder extends Seeder
{
    public function run(): void
    {
        Signature::factory(50)->create();
    }
}
