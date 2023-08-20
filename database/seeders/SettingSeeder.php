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
                'key'   => 'titulo_evento',
                'value' => 'Casamento de João & Maria',
            ],
            [
                'key'   => 'subtitulo_evento',
                'value' => 'O dia mais feliz de nossas vidas',
            ],
            [
                'key'   => 'local_evento',
                'value' => 'Igreja Matriz de São José',
            ],
            [
                'key'   => 'data_evento',
                'value' => now()->addWeek()->format('d/m/Y'),
            ],
            [
                'key'   => 'hora_evento',
                'value' => now()->addWeek()->format('H:i'),
            ],
            [
                'key'   => 'contato_evento',
                'value' => '(11) 99999-9999',
            ],
        ];

        foreach ($settings as $setting) {
            $setting['key'] = strtoupper($setting['key']);

            Setting::create($setting);
        }
    }
}
