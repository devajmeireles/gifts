<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key'   => 'titlo_evento',
                'value' => 'Casamento de João & Maria',
            ],
            [
                'key'   => 'data_evento',
                'value' => now()->addWeek()->format('d/m/Y'),
            ],
        ];

        foreach ($settings as $setting) {
            $setting['key'] = strtoupper($setting['key']);

            Setting::create($setting);
        }
    }
}
