<?php

return [

    /*
    |---------------------------------------------------------------------------
    | Icon sets
    |---------------------------------------------------------------------------
    |
    | This allows configuration of the icon sets used in Tallboy components.
    | Tallboy ships with 'tallboicon' but you can also install 'heroicon'
    | or 'feathericon' blade-icon packages or configure your own sets.
    |
    */
    'icons' => [
        // Force a specific icon set: 'tallboicon', 'heroicon', 'feathericon'
        'default' => null,

        // Alternative icon sets (the tallboicon set is always available)
        'sets' => [
            \Tallboy\Icons\HeroiconSet::class,
            \Tallboy\Icons\FeathericonSet::class,
        ],

        // You can override specific icons here, including using your own custom icons.
        'custom' => [
            // 'alert' => 'heroicon-alert',
        ]
    ],

    /*
    |---------------------------------------------------------------------------
    | Components
    |---------------------------------------------------------------------------
    |
    | This allows configuration of the componemts available from Tallboy.
    | Tallboy provides a number of blade components, broken up loosely
    | into related groups. This allows subtituting your components.
    |
    */
    'components' => [
        'icon' => \Tallboy\View\Components\Icon::class,
        'form' => [
            'label' => \Tallboy\View\Components\Form\Label::class,
        ],
        'feedback' > [],
    ]
];
