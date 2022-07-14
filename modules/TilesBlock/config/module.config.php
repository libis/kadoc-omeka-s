<?php
return [
    'block_layouts' => [
        'invokables' => [
            'tilesBlock' => TilesBlock\Site\BlockLayout\TilesBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
