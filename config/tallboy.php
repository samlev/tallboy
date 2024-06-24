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
        // Alternative icon sets
        'sets' => [
            \Tallboy\Concerns\Icons\Sets\HeroiconSet::class,
            \Tallboy\Concerns\Icons\Sets\FeathericonSet::class,
        ],

        // You can override specific icons here, including using your own custom icons.
        'custom' => [
            // @see src/Icons/Icons.md
        ]
    ],
];
