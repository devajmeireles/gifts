<?php

return [
    'delivery_type' => [
        'inperson' => 'Presencialmente',
        'remotely' => 'Remotamente',
        'tip'      => [
            'in_person' => 'Indica que você irá ao evento',
            'remotely'  => 'A entrega será combinada',
        ],
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
