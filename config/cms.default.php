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
        'Pages' => [
            'attributes' => []
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
        ],
        // *
        // * You can use the following options for BlockAnimations Array
        // * e.g. 'bounceIn' => 'Bounce in', where 'Bounce in' is arbitrary
        //
        // bounceIn
        // bounceInDown
        // bounceInRight
        // bounceInUp
        // bounceInLeft
        // fadeInDownShort
        // fadeInUpShort
        // fadeInLeftShort
        // fadeInRightShort
        // fadeInDown
        // fadeInUp
        // fadeInLeft
        // fadeInRight
        // fadeIn
        // growIn
        // shake
        // shakeUp
        // rotateIn
        // rotateInUpLeft
        // rotateInDownLeft
        // rotateInUpRight
        // rotateInDownRight
        // rollIn
        // wiggle
        // swing
        // tada
        // wobble
        // pulse
        // lightSpeedInRight
        // lightSpeedInLeft
        // flip
        // flipInX
        // flipInY
        //
        'BlockAnimations' => false
    ]
];
