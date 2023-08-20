<?php

return [
    'delivery_type' => [
        'locally' => 'Em Mãos',
        'remote'  => 'Remotamente',
    ],

    'dashboard' => [
        'card' => [
            1 => 'Todos os Itens',
            2 => 'Itens Assinados',
            3 => 'Itens Não Assinados',
        ],
    ],

    'user' => [
        'role' => [
            1 => 'Administrador',
            2 => 'Usuário',
            3 => 'Convidado',
        ],
    ],

    'item' => [
        'delete' => [
            'signature_exists' => 'Este item possui :count assinatura(s) vinculada(s). Ao deletá-lo, todas as assinaturas serão apagadas. Você tem certeza que deseja realmente apagar este item?',
        ],
    ],
];
