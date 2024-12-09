<?php
return [
    'block_layouts' => [
        'invokables' => [
            'verhaalBlock' => VerhaalBlock\Site\BlockLayout\VerhaalBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
