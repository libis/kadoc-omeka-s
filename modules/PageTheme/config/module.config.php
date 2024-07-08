<?php
return [
    'block_layouts' => [
        'invokables' => [
            'PageTheme' => PageTheme\Site\BlockLayout\PageTheme::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
