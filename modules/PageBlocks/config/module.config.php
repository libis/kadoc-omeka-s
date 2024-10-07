<?php
return [
    'block_layouts' => [
        'invokables' => [
            'PageBlocks' => PageBlocks\Site\BlockLayout\PageBlocks::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
