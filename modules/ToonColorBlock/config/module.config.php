<?php
return [
    'block_layouts' => [
        'invokables' => [
            'toonColorBlock' => ToonColorBlock\Site\BlockLayout\ToonColorBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
