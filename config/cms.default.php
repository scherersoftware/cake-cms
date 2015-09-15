<?php
return [
    'Cms' => [
        'Frontend' => [
            // Controller and action to which SlugRoute will point by default
            'renderAction' => [
                'plugin' => 'Cms',
                'controller' => 'CmsPages',
                'action' => 'show'
            ]
        ],
        'Administration' => [
            'layout' => 'default',
            'helpers' => []
        ],
        'Widgets' => [
            // if false the list will be compiled dynamically
            'availableWidgets' => false,
            // widgets in this list won't be offered to users when creating blocks
            'excludedWidgets' => []
        ],
        'Design' => [
            'rowLayouts' => [
                '4-4-4',
                '4-8',
                '6-6',
                '8-4',
                '12',
                '2-2-2-2-2-2'
            ]
        ]
    ]
];
