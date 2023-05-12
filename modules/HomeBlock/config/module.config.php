<?php
return [
    'block_layouts' => [
        'invokables' => [
            'HomeBlock' => HomeBlock\Site\BlockLayout\HomeBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
