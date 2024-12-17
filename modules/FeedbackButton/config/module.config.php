<?php
return [
    'block_layouts' => [
        'invokables' => [
            'feedbackButton' => FeedbackButton\Site\BlockLayout\FeedbackButton::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
