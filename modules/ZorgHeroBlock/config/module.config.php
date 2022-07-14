<?php
return [
    'block_layouts' => [
        'invokables' => [
            'zorgHeroBlock' => ZorgHeroBlock\Site\BlockLayout\ZorgHeroBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
