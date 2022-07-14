<?php
return [
    'block_layouts' => [
        'invokables' => [
            'storiesBlock' => StoriesBlock\Site\BlockLayout\StoriesBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
