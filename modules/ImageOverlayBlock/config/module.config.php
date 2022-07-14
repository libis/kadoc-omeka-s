<?php
return [
    'block_layouts' => [
        'invokables' => [
            'imageOverlayBlock' => ImageOverlayBlock\Site\BlockLayout\ImageOverlayBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
