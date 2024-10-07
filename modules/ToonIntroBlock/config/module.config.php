<?php
return [
    'block_layouts' => [
        'invokables' => [
            'toonIntroBlock' => ToonIntroBlock\Site\BlockLayout\ToonIntroBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
