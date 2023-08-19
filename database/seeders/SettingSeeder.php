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
                'value' => now()->addWeek()->format('Y-m-d'),
            ],
            [
                'key'   => 'itens_cotas_via_pix',
                'value' => true,
            ],
            [
                'key'   => 'pix',
                'value' => '123.456.789-00',
            ],
        ];

        foreach ($settings as $setting) {
            $setting['key'] = strtoupper($setting['key']);

            Setting::create($setting);
        }
    }
}
