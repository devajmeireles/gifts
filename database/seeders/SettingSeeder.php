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
                'key'   => 'titulo',
                'value' => 'Casamento de João & Maria',
                'type'  => 'text',
            ],
            [
                'key'   => 'subtitulo',
                'value' => 'O dia mais feliz de nossas vidas',
                'type'  => 'textarea',
            ],
            [
                'key'   => 'local',
                'value' => 'Igreja Matriz de São José',
                'type'  => 'text',
            ],
            [
                'key'   => 'data',
                'value' => now()->addWeek()->format('Y-m-d'),
                'type'  => 'date',
            ],
            [
                'key'   => 'hora',
                'value' => now()->addWeek()->format('H:i'),
                'type'  => 'time',
            ],
            [
                'key'   => 'contato',
                'value' => '(11) 99999-9999',
                'type'  => 'phone',
            ],
            [
                'key'   => 'duvida_1_titulo',
                'value' => 'Onde vai ser o {%titulo%}?',
                'type'  => 'text',
            ],
            [
                'key'   => 'duvida_1_resposta',
                'value' => 'Na Igreja Matriz de São José',
                'type'  => 'textarea',
            ],
            [
                'key'   => 'duvida_2_titulo',
                'value' => 'Quando vai ser realizado o {%titulo%}?',
                'type'  => 'text',
            ],
            [
                'key'   => 'duvida_2_resposta',
                'value' => 'No dia {%data%} às {%hora%}',
                'type'  => 'textarea',
            ],
            [
                'key'   => 'duvida_3_titulo',
                'value' => 'Posso presentar os noivos?',
                'type'  => 'text',
            ],
            [
                'key'   => 'duvida_3_resposta',
                'value' => 'Sim, você pode presentear os noivos escolhendo um item da lista acima',
                'type'  => 'textarea',
            ],
            [
                'key'   => 'rodape',
                'value' => 'Laravel',
                'type'  => 'text',
            ],
            [
                'key'   => 'rodape_whatsapp',
                'value' => '{%contato%}',
                'type'  => 'text',
            ],
            [
                'key'   => 'rodape_instagram',
                'value' => 'https://www.instagram.com',
                'type'  => 'text',
            ],
        ];

        foreach ($settings as $setting) {
            $setting['key'] = strtoupper($setting['key']);

            Setting::create($setting);
        }
    }
}
