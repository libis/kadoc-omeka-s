<?php
return [
    'block_layouts' => [
        'invokables' => [
            'collectieBlock' => CollectieBlock\Site\BlockLayout\CollectieBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
