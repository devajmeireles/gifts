<?php

return [
    'delivery_type' => [
        'locally' => 'Em Mãos',
        'remote'  => 'Remotamente',
    ],

    'dashboard' => [
        'card' => [
            1 => 'Todos os Itens',
            2 => 'Assinados',
            3 => 'Não Assinados',
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

    'signature' => [
        'notification' => '<b>Nova Assinatura Criada!</b> Assinante: :name (telefone: :phone). <b>Item: :item</b> (quantidade: :quantity, categoria: :category)',
    ],
];
