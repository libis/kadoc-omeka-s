<?php
return [
    'block_layouts' => [
        'invokables' => [
            'tentoonstellingBlock' => TentoonstellingBlock\Site\BlockLayout\TentoonstellingBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
