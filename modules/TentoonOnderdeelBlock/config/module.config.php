<?php
return [
    'block_layouts' => [
        'invokables' => [
            'tentoonOnderdeelBlock' => TentoonOnderdeelBlock\Site\BlockLayout\TentoonOnderdeelBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
