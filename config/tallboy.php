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
    | Tallboy provides a number of blade components broken up into functional
    | groups. If you want to modify the functionality of the base classes,
    | you can define your own components here for Tallboy to swap over.
    |
    */
    'components' => [
        'icon' => \Tallboy\View\Components\Icon::class,
        'form' => [
            'field-error' => \Tallboy\View\Components\Form\FieldError::class,
            'field-hint' => \Tallboy\View\Components\Form\FieldHint::class,
            'input' => \Tallboy\View\Components\Form\Input::class,
            'input-errors' => \Tallboy\View\Components\Form\InputErrors::class,
            'label' => \Tallboy\View\Components\Form\Label::class,
            'opt-group' => \Tallboy\View\Components\Form\OptGroup::class,
            'option' => \Tallboy\View\Components\Form\Option::class,
            'select' => \Tallboy\View\Components\Form\Select::class,
        ],
        'feedback' > [],
    ]
];
