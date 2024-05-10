<?php
return [
    'block_layouts' => [
        'invokables' => [
            'PageFeature' => PageFeature\Site\BlockLayout\PageFeature::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
