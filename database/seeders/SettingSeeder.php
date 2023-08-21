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
                'key'   => 'rodape',
                'value' => 'Laravel',
                'type'  => 'text',
            ],
            [
                'key'   => 'recebimento_evento',
                'value' => 'Recebemos a assinatura do seu presente! Como você escolheu entregar o presente no evento gostaríamos de te lembrar os detalhes sobre o evento. O evento ocorrerá em {%local%}, as {%hora%} do dia {%data%}. Esperamos por você. Obrigado!',
                'type'  => 'textarea',
            ],
            [
                'key'   => 'recebimento_remotamente',
                'value' => 'Recebemos a assinatura do seu presente! Entraremos em contato com você pelo número informado em breve. Obrigado!',
                'type'  => 'textarea',
            ],
        ];

        foreach ($settings as $setting) {
            $setting['key'] = strtoupper($setting['key']);

            Setting::create($setting);
        }
    }
}
